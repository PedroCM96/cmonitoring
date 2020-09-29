<?php


namespace ComputerMonitoring\src\shared\Infrastructure\MonitoringTools\Disk;


final class DfhDiskMonitor implements DiskMonitor
{
    private $percent;

    /**
     * DfhDiskMonitor constructor.
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
        return $this->getIntValOfDfhOutput((string) shell_exec("df -h | grep '/dev/sdb1'"));
    }

    /**
     * @return int
     */
    public function percent(): int
    {
        return $this->percent;
    }

    /**
     * @param string $output
     * @return int
     */
    private function getIntValOfDfhOutput(string $output) : int
    {
        $index = strpos($output, '%');
        return intval(substr($output, $index - 2, 2));
    }
}