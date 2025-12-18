<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/mongo.php';

function auth_find_user_by_email($email)
{
    global $users;
    return $users->findOne(['email' => strtolower($email)]);
}

function auth_find_user_by_username($username)
{
    global $users;
    return $users->findOne(['username' => $username]);
}

function auth_register_user($fullName, $email, $username, $phone, $password, $confirmPassword, &$errors)
{
    $errors = [];

    if (trim($fullName) === '') {
        $errors['full_name'] = 'Full name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required.';
    }
    if (trim($username) === '') {
        $errors['username'] = 'Username is required.';
    }
    if (!preg_match('/^[0-9]{7,15}$/', $phone)) {
        $errors['phone'] = 'Valid phone number is required.';
    }
    if (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    if (auth_find_user_by_email($email)) {
        $errors['email'] = 'Email is already registered.';
    }
    if (auth_find_user_by_username($username)) {
        $errors['username'] = 'Username is already taken.';
    }

    if (!empty($errors)) {
        return null;
    }

    global $users;
    
    $user = [
        'full_name' => $fullName,
        'email' => strtolower($email),
        'username' => $username,
        'phone' => $phone,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => new MongoDB\BSON\UTCDateTime(),
        'updated_at' => new MongoDB\BSON\UTCDateTime()
    ];

    try {
        $result = $users->insertOne($user);
        $user['_id'] = $result->getInsertedId();
        
        // Ensure _id is a string in the returned user array
        $user['id'] = (string)$user['_id'];
        
        return $user;
    } catch (Exception $e) {
        error_log('Error registering user: ' . $e->getMessage());
        $errors['general'] = 'Failed to create user account. Please try again.';
        return null;
    }
}

function auth_authenticate($email, $password, &$errors)
{
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required.';
        return null;
    }

    $user = auth_find_user_by_email($email);
    if (!$user || !password_verify($password, $user->password_hash)) {
        $errors['general'] = 'Invalid email or password.';
        return null;
    }
    
    $userArray = json_decode(json_encode($user), true);
    
    // Ensure we have both _id and id fields for backward compatibility
    if (isset($userArray['_id'])) {
        $userArray['id'] = (string)$userArray['_id'];
    }
    
    return $userArray;
}

function auth_base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function auth_base64url_decode($data)
{
    $remainder = strlen($data) % 4;
    if ($remainder) {
        $data .= str_repeat('=', 4 - $remainder);
    }
    return base64_decode(strtr($data, '-_', '+/'));
}

function auth_generate_jwt(array $payload)
{
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $payload['iss'] = JWT_ISSUER;
    $payload['iat'] = time();
    $payload['exp'] = time() + JWT_EXPIRY_SECONDS;

    $headerEncoded = auth_base64url_encode(json_encode($header));
    $payloadEncoded = auth_base64url_encode(json_encode($payload));

    $signature = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, JWT_SECRET_KEY, true);
    $signatureEncoded = auth_base64url_encode($signature);

    return $headerEncoded . '.' . $payloadEncoded . '.' . $signatureEncoded;
}

function auth_verify_jwt($token)
{
    if (!$token) {
        return null;
    }

    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return null;
    }

    list($headerEncoded, $payloadEncoded, $signatureProvided) = $parts;

    $signature = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, JWT_SECRET_KEY, true);
    $expected = auth_base64url_encode($signature);

    if (!hash_equals($expected, $signatureProvided)) {
        return null;
    }

    $payloadJson = auth_base64url_decode($payloadEncoded);
    $payload = json_decode($payloadJson, true);
    if (!is_array($payload)) {
        return null;
    }

    if (isset($payload['exp']) && time() > $payload['exp']) {
        return null;
    }

    return $payload;
}

function auth_login_user(array $user)
{
    // Make sure we have the user ID and it's a string
    $userId = is_object($user['_id']) && method_exists($user['_id'], '__toString') 
        ? (string)$user['_id'] 
        : $user['_id'] ?? null;

    if (!$userId) {
        error_log('Cannot login user: No user ID found');
        return false;
    }

    $payload = [
        'sub' => $userId,  // Use _id as the subject
        'email' => $user['email'] ?? '',
        'name' => $user['full_name'] ?? '',
        'username' => $user['username'] ?? '',
        'iat' => time(),  // Issued at
        'exp' => time() + JWT_EXPIRY_SECONDS  // Expiration time
    ];
    
    $token = auth_generate_jwt($payload);
    return setcookie('auth_token', $token, time() + JWT_EXPIRY_SECONDS, '/', '', false, true);
}

function auth_logout_user()
{
    setcookie('auth_token', '', time() - 3600, '/', '', false, true);
}

function auth_current_user()
{
    if (!isset($_COOKIE['auth_token'])) {
        return null;
    }
    
    $payload = auth_verify_jwt($_COOKIE['auth_token']);
    if (!$payload || !isset($payload['sub'])) {
        return null;
    }

    global $users;
    
    try {
        // Get the user ID from the payload
        $userId = $payload['sub'];
        
        // If it's an array, try to get the $oid field
        if (is_array($userId)) {
            $userId = $userId['$oid'] ?? null;
        }
        
        // If we still don't have a valid ID, log and return
        if (!$userId) {
            error_log('Invalid user ID format in JWT payload: ' . json_encode($payload));
            return null;
        }

        // Convert string ID to ObjectId
        $userId = new MongoDB\BSON\ObjectId($userId);
        
        // Find the user
        $user = $users->findOne(['_id' => $userId]);
        
        if ($user) {
            // Convert to array
            $userArray = json_decode(json_encode($user), true);
            
            // Ensure consistent ID format
            if (isset($userArray['_id'])) {
                $userArray['id'] = $userArray['_id'];
            }
            
            return $userArray;
        }
    } catch (Exception $e) {
        error_log('Error in auth_current_user: ' . $e->getMessage() . ' | Payload: ' . json_encode($payload));
    }

    return null;
}

function auth_is_authenticated()
{
    return auth_current_user() !== null;
}
