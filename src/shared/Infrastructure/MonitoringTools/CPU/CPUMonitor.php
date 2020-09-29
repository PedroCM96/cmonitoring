<?php


namespace ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\CPU;


interface CPUMonitor
{
    public function getPercent(): int;
}