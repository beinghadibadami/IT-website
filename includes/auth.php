<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';

function auth_users_file_path()
{
    return __DIR__ . '/../data/users.json';
}

function auth_load_users()
{
    $path = auth_users_file_path();
    if (!file_exists($path)) {
        return [];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function auth_save_users(array $users)
{
    $path = auth_users_file_path();
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT));
}

function auth_find_user_by_email($email)
{
    $users = auth_load_users();
    foreach ($users as $user) {
        if (strcasecmp($user['email'], $email) === 0) {
            return $user;
        }
    }
    return null;
}

function auth_find_user_by_username($username)
{
    $users = auth_load_users();
    foreach ($users as $user) {
        if (strcasecmp($user['username'], $username) === 0) {
            return $user;
        }
    }
    return null;
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

    $users = auth_load_users();
    $id = uniqid('u_', true);

    $user = [
        'id' => $id,
        'full_name' => $fullName,
        'email' => strtolower($email),
        'username' => $username,
        'phone' => $phone,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('c')
    ];

    $users[] = $user;
    auth_save_users($users);

    return $user;
}

function auth_authenticate($email, $password, &$errors)
{
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required.';
        return null;
    }

    $user = auth_find_user_by_email($email);
    if (!$user || !password_verify($password, $user['password_hash'])) {
        $errors['general'] = 'Invalid email or password.';
        return null;
    }

    return $user;
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
    $payload = [
        'sub' => $user['id'],
        'email' => $user['email'],
        'name' => $user['full_name'],
        'username' => $user['username']
    ];
    $token = auth_generate_jwt($payload);
    setcookie('auth_token', $token, time() + JWT_EXPIRY_SECONDS, '/', '', false, true);
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

    $users = auth_load_users();
    foreach ($users as $user) {
        if ($user['id'] === $payload['sub']) {
            return $user;
        }
    }

    return null;
}

function auth_is_authenticated()
{
    return auth_current_user() !== null;
}
