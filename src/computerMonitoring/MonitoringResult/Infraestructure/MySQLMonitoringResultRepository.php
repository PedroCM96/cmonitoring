<?php


namespace ComputerMonitoring\src\computerMonitoring\MonitoringResult\Infraestructure;


use ComputerMonitoring\src\computerMonitoring\Exceptions\ValueIsNotPercentage;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResult;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultCPUPercent;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultDiskPercent;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultId;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultMemoryPercent;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultRepository;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultTimestamp;
use ComputerMonitoring\src\shared\Infrastructure\Persistence\Connection\ConnectionRepository;
use PDO;

final class MySQLMonitoringResultRepository implements MonitoringResultRepository
{
    protected $connection_repository;
    protected $conn = null;

    /**
     * MySQLMonitoringResultRepository constructor.
     * @param ConnectionRepository $connection_repository
     */
    public function __construct(ConnectionRepository $connection_repository)
    {
        $this->connection_repository = $connection_repository;
        $this->conn = $this->connection_repository->connection();
    }

    /**
     * @param MonitoringResult $monitoring_result
     */
    public function save(MonitoringResult $monitoring_result)
    {
        $stmt = $this->conn->prepare("INSERT INTO monitoring_results(id, disk_percent, memory_percent, cpu_percent, 
            timestamp) VALUES(:id, :disk_percent, :memory_percent, :cpu_percent, :timestamp)");

        $stmt->execute([
            ':id' => $monitoring_result->id()->__toString(),
            ':disk_percent' => $monitoring_result->disk_percent()->__toString(),
            ':memory_percent' => $monitoring_result->memory_percent()->__toString(),
            ':cpu_percent' => $monitoring_result->cpu_percent()->__toString(),
            ':timestamp' => $monitoring_result->timestamp()->__toString()
        ]);
    }


    /**
     * @return array
     * @throws ValueIsNotPercentage
     */
    public function all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM monitoring_results ORDER BY timestamp DESC");
        $stmt->execute();
        $monitoring_results = [];
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $monitoring_results[] = new MonitoringResult(
                new MonitoringResultId($row["id"]),
                new MonitoringResultDiskPercent(intval($row["disk_percent"])),
                new MonitoringResultMemoryPercent(intval($row["memory_percent"])),
                new MonitoringResultCPUPercent(intval($row["cpu_percent"])),
                new MonitoringResultTimestamp(MonitoringResultTimestamp::fromString($row["warn_timestamp"])->value())
            );
        }
        return $monitoring_results;
    }

    public function deleteLastDayResults()
    {
        $last_day =  date('Y-m-d', strtotime('-1 day')); // YYYY-MM-DD;
        $stmt = $this->conn->prepare("SET SQL_SAFE_UPDATES = 0;");
        $stmt->execute();
        $stmt = $this->conn->prepare("DELETE FROM monitoring_results WHERE timestamp LIKE '%$last_day%'");
        $stmt->execute();

    }
}