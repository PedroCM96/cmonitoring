<?php

namespace ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain;

final class MonitoringResult
{
    private $id;
    private $disk_percent;
    private $memory_percent;
    private $cpu_percent;
    private $timestamp;

    /**
     * MonitoringResult constructor.
     * @param MonitoringResultId $id
     * @param MonitoringResultDiskPercent $disk_percent
     * @param MonitoringResultMemoryPercent $memory_percent
     * @param MonitoringResultCPUPercent $cpu_percent
     * @param MonitoringResultTimestamp $timestamp
     */
    public function __construct(MonitoringResultId $id, MonitoringResultDiskPercent $disk_percent, MonitoringResultMemoryPercent $memory_percent,
                                MonitoringResultCPUPercent $cpu_percent, MonitoringResultTimestamp $timestamp)
    {
        $this->id = $id;
        $this->disk_percent = $disk_percent;
        $this->memory_percent = $memory_percent;
        $this->cpu_percent = $cpu_percent;
        $this->timestamp = $timestamp;
    }

    /**
     * @param MonitoringResultId $id
     * @param MonitoringResultDiskPercent $disk_percent
     * @param MonitoringResultMemoryPercent $memory_percent
     * @param MonitoringResultCPUPercent $cpu_percent
     * @return static
     */
    public static function create(MonitoringResultId $id, MonitoringResultDiskPercent $disk_percent, MonitoringResultMemoryPercent $memory_percent,
                                  MonitoringResultCPUPercent $cpu_percent): self
    {
        return new self($id, $disk_percent, $memory_percent, $cpu_percent, new MonitoringResultTimestamp(MonitoringResultTimestamp::create()->value()));
    }

    /**
     * @return MonitoringResultId
     */
    public function id(): MonitoringResultId
    {
        return $this->id;
    }

    /**
     * @return MonitoringResultDiskPercent
     */
    public function disk_percent(): MonitoringResultDiskPercent
    {
        return $this->disk_percent;
    }

    /**
     * @return MonitoringResultMemoryPercent
     */
    public function memory_percent(): MonitoringResultMemoryPercent
    {
        return $this->memory_percent;
    }

    /**
     * @return MonitoringResultCPUPercent
     */
    public function cpu_percent(): MonitoringResultCPUPercent
    {
        return $this->cpu_percent;
    }

    /**
     * @return MonitoringResultTimestamp
     */
    public function timestamp(): MonitoringResultTimestamp
    {
        return $this->timestamp;
    }

}