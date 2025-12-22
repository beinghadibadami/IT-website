<?php
// MongoDB connection and helper for users and transactions
// Usage: require this file, use $users and $transactions collections

require_once __DIR__ . '/../vendor/autoload.php';

$mongoUri = getenv('MONGODB_URI') ?: 'mongodb+srv://rizzler:luuklpHafE6hVynk@cluster0.8pkoglo.mongodb.net/?appName=Cluster0';
$mongoDb = getenv('MONGODB_DB') ?: 'divinesyncserve';

$client = new MongoDB\Client($mongoUri);
$db = $client->selectDatabase($mongoDb);

$users = $db->users;
$transactions = $db->transactions;

// Example: Insert user (call this when user signs up)
function insert_user($users, $userData)
{
    $userData['created_at'] = new MongoDB\BSON\UTCDateTime();
    $userData['updated_at'] = new MongoDB\BSON\UTCDateTime();
    $result = $users->insertOne($userData);
    return $result->getInsertedId();
}

// Example: Insert transaction (user_id can be null)
function insert_transaction($transactions, $txnData)
{
    $txnData['created_at'] = new MongoDB\BSON\UTCDateTime();
    $txnData['updated_at'] = new MongoDB\BSON\UTCDateTime();
    $result = $transactions->insertOne($txnData);
    return $result->getInsertedId();
}

// Update transaction by order_id
function update_transaction($transactions, $orderId, $updateData)
{
    // Ensure updated_at is set if not already
    if (!isset($updateData['updated_at'])) {
        $updateData['updated_at'] = new MongoDB\BSON\UTCDateTime();
    }

    $result = $transactions->updateOne(
        ['order_id' => $orderId],
        ['$set' => $updateData]
    );

    return $result->getModifiedCount();
}
