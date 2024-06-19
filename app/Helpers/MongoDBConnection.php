<?php

namespace App\Helpers;

use MongoDB\Client;

class MongoDBConnection
{
    public static function getClient()
    {
        // Get MongoDB connection details from config
        $dsn      = config('database.connections.mongodb.dsn');
        $username = config('database.connections.mongodb.username');
        $password = config('database.connections.mongodb.password');
        $authDB   = config('database.connections.mongodb.options.database');

        // Construct the MongoDB URI
        $uri = "{$dsn}/?authSource={$authDB}";

        // Initialize MongoDB client with the constructed URI
        return new Client($uri, [
            'username' => $username,
            'password' => $password
        ]);
    }

    public static function getDatabase()
    {
        $client = self::getClient();
        $database = config('database.connections.mongodb.database');
        return $client->selectDatabase($database);
    }

    public static function getCollection($collection)
    {
        $database = self::getDatabase();
        return $database->selectCollection($collection);
    }
}
