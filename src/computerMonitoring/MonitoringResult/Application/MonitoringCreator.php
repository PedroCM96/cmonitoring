<?php


namespace ComputerMonitoring\src\computerMonitoring\MonitoringResult\Application;


use ComputerMonitoring\src\computerMonitoring\Exceptions\ValueIsNotPercentage;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResult;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultCPUPercent;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultDiskPercent;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultId;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultMemoryPercent;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultRepository;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\CPU\CPUMonitor;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Disk\DiskMonitor;
use ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Memory\MemoryMonitor;
use ComputerMonitoring\src\shared\ValueObjects\Uuid;

class MonitoringCreator
{
    protected $monitoring_result_respository;
    protected $disk_monitor;
    protected $memory_monitor;
    protected $cpu_monitor;


    /**
     * MonitoringCreator constructor.
     * @param MonitoringResultRepository $monitoring_result_repository
     * @param DiskMonitor $disk_monitor
     * @param MemoryMonitor $memory_monitor
     * @param CPUMonitor $cpu_monitor
     * @throws ValueIsNotPercentage
     */
    public function __construct(MonitoringResultRepository $monitoring_result_repository, DiskMonitor $disk_monitor, MemoryMonitor  $memory_monitor,
                                CPUMonitor $cpu_monitor)
    {
        $this->monitoring_result_respository = $monitoring_result_repository;
        $this->disk_monitor = $disk_monitor;
        $this->memory_monitor = $memory_monitor;
        $this->cpu_monitor = $cpu_monitor;

        $this->monitoring_result_respository->save(MonitoringResult::create(
            new MonitoringResultId(Uuid::random()->value()),
            new MonitoringResultDiskPercent($this->disk_monitor->percent()),
            new MonitoringResultMemoryPercent($this->memory_monitor->percent()),
            new MonitoringResultCPUPercent($this->cpu_monitor->percent())
        ));
    }



}