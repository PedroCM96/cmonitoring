<?php


namespace ComputerMonitoring\src\computerMonitoring\MonitoringResult\Domain;


use ComputerMonitoring\src\computerMonitoring\Exceptions\ValueIsNotPercentage;
use ComputerMonitoring\src\shared\ValueObjects\IntValueObject;

final class MonitoringResultMemoryPercent extends IntValueObject
{
    /**
     * MonitoringResultDiskPercent constructor.
     * @param int $value
     * @throws ValueIsNotPercentage
     */
    public function __construct(int $value)
    {
        parent::__construct($value);
        $this->ensureIsPercent($value);
    }

    /**
     * @param int $value
     * @throws ValueIsNotPercentage
     */
    private function ensureIsPercent(int $value) {
        if($value < 0 || $value > 100)
            throw new ValueIsNotPercentage($value);
    }
}