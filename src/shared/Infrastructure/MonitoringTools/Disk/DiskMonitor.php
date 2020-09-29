<?php


namespace ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Disk;


interface DiskMonitor
{
    public function getPercent(): int;
}