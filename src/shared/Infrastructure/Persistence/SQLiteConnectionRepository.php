<?php


namespace ComputerMonitoring\src\shared\Infrastructure\Persistence;


use ComputerMonitoring\src\shared\Infrastructure\Persistence\Connection\ConnectionRepository;
use PDO;

class SQLiteConnectionRepository implements ConnectionRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("sqlite:computer-monitoring.db");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function connection()
    {
        return $this->conn;
    }
}