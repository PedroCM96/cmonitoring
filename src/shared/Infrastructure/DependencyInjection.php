<?php


namespace ComputerMonitoring\src\shared\Infrastructure;


use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultRepository;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Infraestructure\MySQLMonitoringResultRepository;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Infraestructure\SQLiteMonitoringResultRepository;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\CPU\CPUMonitor;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\CPU\ProcStatCPUMonitor;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Disk\DfhDiskMonitor;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Disk\DiskMonitor;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Memory\FreeMMemoryMonitor;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Memory\MemoryMonitor;
use ComputerMonitoring\src\shared\Infrastructure\Persistence\Connection\ConnectionRepository;
use ComputerMonitoring\src\shared\Infrastructure\Persistence\MySQL\TableMonitoringResults as MySQLTableMonitoringResults;
use ComputerMonitoring\src\shared\Infrastructure\Persistence\MySQLConnectionRepository;
use ComputerMonitoring\src\shared\Infrastructure\Persistence\SQLite\TableMonitoringResults as SQLiteTableMonitoringResults;
use ComputerMonitoring\src\shared\Infrastructure\Persistence\SQLiteConnectionRepository;

class DependencyInjection
{
    private static $instance;
    private $monitoring_results_repository;
    private $table_monitoring_results;
    private $connection;
    private $disk_monitor;
    private $memory_monitor;
    private $cpu_monitor;

    /**
     * DependencyInjection constructor.
     */
    public function __construct()
    {
        //Persistence drivers
        switch (strtolower($_ENV['PERSISTENCE_DRIVER'])) {
            case 'mysql':
                $this->connection = new MySQLConnectionRepository();
                $this->monitoring_results_repository = new MySQLMonitoringResultRepository($this->connection);
                $this->table_monitoring_results = new MySQLTableMonitoringResults($this->connection());
                $this->table_monitoring_results->create();
                break;

            case 'sqlite':
                $this->connection = new SQLiteConnectionRepository();
                $this->monitoring_results_repository = new SQLiteMonitoringResultRepository($this->connection);
                $this->table_monitoring_results = new SQLiteTableMonitoringResults($this->connection());
                $this->table_monitoring_results->create();
                break;
        }

        //Monitoring Tools
        switch (strtolower($_ENV['DISK_MONITOR'])) {
            case 'dfh':
                $this->disk_monitor = new DfhDiskMonitor();
                break;
        }

        switch (strtolower($_ENV['MEMORY_MONITOR'])) {
            case 'freem':
                $this->memory_monitor = new FreeMMemoryMonitor();
                break;
        }

        switch (strtolower($_ENV['CPU_MONITOR'])) {
            case 'procstat':
                $this->cpu_monitor = new ProcStatCPUMonitor();
                break;
        }
    }

    /**
     * @return ConnectionRepository
     */
    public function connection(): ConnectionRepository {
        return $this->connection;
    }

    /**
     * @return MonitoringResultRepository
     */
    public function monitoringResultsRepository(): MonitoringResultRepository
    {
        return $this->monitoring_results_repository;
    }

    /**
     * @return DiskMonitor
     */
    public function diskMonitor(): DiskMonitor
    {
        return $this->disk_monitor;
    }

    /**
     * @return MemoryMonitor
     */
    public function memoryMonitor(): MemoryMonitor
    {
        return $this->memory_monitor;
    }

    /**
     * @return CPUMonitor
     */
    public function CPUMonitor(): CPUMonitor
    {
        return $this->cpu_monitor;
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if(!isset(self::$instance))
            self::$instance = new self;

        return self::$instance;
    }
}