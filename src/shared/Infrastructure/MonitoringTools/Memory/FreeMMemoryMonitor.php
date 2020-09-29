<?php


namespace ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Memory;


final class FreeMMemoryMonitor implements MemoryMonitor
{
    private $percent;

    /**
     * FreeMMemoryMonitor constructor.
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
        return intval(shell_exec("free -m -h -t | grep T | awk '{usage=($3*100)/$2} END {print usage}'"));
    }

    /**
     * @return int
     */
    public function percent(): int
    {
        return $this->percent;
    }
}