<?php


namespace ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Memory;


interface MemoryMonitor
{
    public function getPercent(): int;

}