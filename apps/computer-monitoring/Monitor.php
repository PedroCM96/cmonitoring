<?php

use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Application\MonitoringCreator;
use ComputerMonitoring\src\computerMonitoring\MonitoringResult\Application\MonitoringLastDayKiller;
use ComputerMonitoring\src\shared\Infrastructure\DependencyInjection;
use Symfony\Component\Dotenv\Dotenv;

require_once "vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load(".env");

$dependence_injector = DependencyInjection::getInstance();
$monitoring_results_repository = $dependence_injector->monitoringResultsRepository();
try {
    new MonitoringCreator($monitoring_results_repository,
        $dependence_injector->diskMonitor(), $dependence_injector->memoryMonitor(),
        $dependence_injector->CPUMonitor());

    new MonitoringLastDayKiller($monitoring_results_repository);
} catch (Exception $e) {
    echo "Exception! " . $e->getMessage();
}
