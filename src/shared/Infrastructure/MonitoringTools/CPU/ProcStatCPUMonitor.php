<?php


namespace ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\CPU;


final class ProcStatCPUMonitor implements CPUMonitor
{
    private $percent;

    /**
     * ProcStatCPUMonitor constructor.
     */
    public function __construct()
    {
        $this->percent = $this->getPercent();
    }

    /**
     * @return int
     */
    public function getPercent(): int
    {
        return intval(shell_exec("grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage}'"));
    }

    /**
     * @return int
     */
    public function percent(): int
    {
        return $this->percent;
    }
}