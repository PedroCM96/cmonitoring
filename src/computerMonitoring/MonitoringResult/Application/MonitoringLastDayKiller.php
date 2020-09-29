<?php


namespace ComputerMonitoring\src\computerMonitoring\MonitoringResult\Application;


use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain\MonitoringResultRepository;

class MonitoringLastDayKiller
{
    protected $monitoring_result_repository;

    /**
     * MonitoringLastDayKiller constructor.
     * @param MonitoringResultRepository $monitoring_result_repository
     */
    public function __construct(MonitoringResultRepository $monitoring_result_repository)
    {
        $this->monitoring_result_repository = $monitoring_result_repository;
        $this->monitoring_result_repository->deleteLastDayResults();
    }
}