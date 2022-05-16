<?php

namespace Dudoserovich\ToDoPhp;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

class PdoAdapter
{
    private static $connection;

    private static function connect()
    {
        if (!isset(self::$connection)) {
            self::$connection = new \PDO('mysql:host=' . $_ENV['HOST']
                . ';dbname=' . $_ENV['DB_NAME'] . ';port='
                . $_ENV['PORT'],
                $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        }
    }

    private static function unsetConnect()
    {
        self::$connection = null;
    }

    public static function returnAllRequest(string $sql, array $bindings = [],
                                            int    $fetchMode = \PDO::FETCH_ASSOC)
    {
        self::connect();

        $statement = self::$connection->prepare($sql);
        $statement->execute($bindings);
        $result = $statement->fetchAll($fetchMode);

        self::unsetConnect();

        return $result;
    }

    public static function returnOneRequest(string $sql, array $bindings = [])
    {
        self::connect();

        $query = self::$connection->prepare($sql);
        $query->execute($bindings);
        $foundTask = $query->fetch();

        self::unsetConnect();

        return $foundTask;
    }

    public static function noReturnRequest(string $sql, array $bindings = [])
    {
        self::connect();

        $query = self::$connection->prepare($sql);
        $query->execute($bindings);

        self::unsetConnect();
    }

}