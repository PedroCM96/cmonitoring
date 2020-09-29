<?php


namespace ComputerMonitoring\src\shared\Infrastructure\Persistence;


use ComputerMonitoring\src\shared\Infrastructure\Persistence\Connection\ConnectionRepository;
use PDO;

class MySQLConnectionRepository implements ConnectionRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=" . $_ENV['MYSQL_DBHOST'] . ";dbname=" . $_ENV['MYSQL_DBNAME'] . ";charset=utf8mb4", $_ENV['MYSQL_DBUSER'], $_ENV['MYSQL_DBPASS']);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function connection()
    {
        return $this->conn;
    }
}