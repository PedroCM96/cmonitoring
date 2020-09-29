<?php


namespace ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain;


interface MonitoringResultRepository
{
    public function save(MonitoringResult $monitoring_result);
    public function all();
    public function deleteLastDayResults();
}