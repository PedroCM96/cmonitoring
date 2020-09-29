<?php


namespace ComputerMonitoring\src\shared\Infrastructure\Persistence\MySQL;


use ComputerMonitoring\src\shared\Infrastructure\Persistence\Connection\ConnectionRepository;
use ComputerMonitoring\src\shared\Infrastructure\Persistence\Table;
use PDOException;

class TableMonitoringResults extends Table
{
    protected $create_sql = "CREATE TABLE IF NOT EXISTS monitoring_results (
		  `id` char(36) NOT NULL,
		  `disk_percent` tinyint(4) NOT NULL DEFAULT '0',
		  `memory_percent` tinyint(4) NOT NULL DEFAULT '0',
		  `cpu_percent` tinyint(4) NOT NULL DEFAULT '0',
		  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
		SET SQL_SAFE_UPDATES = 0;";

    protected $drop_sql = "DROP TABLE IF EXISTS monitoring_results;";

    private $connection_repository;

    private $conn;

    public function __construct(ConnectionRepository $connection_repository)
    {
        parent::__construct('monitoring_results');
        $this->connection_repository = $connection_repository;
        $this->conn = $connection_repository->connection();

    }

    public function create()
    {
        try {
            $this->conn->exec($this->create_sql);
        } catch(PDOException $ex) {
            echo "An Error occured!: " . $ex->getMessage();
        }
    }

    public function drop()
    {
        try {
            $this->conn->exec($this->drop_sql);
        } catch(PDOException $ex) {
            echo "An Error occured!: " . $ex->getMessage();
        }
    }
}