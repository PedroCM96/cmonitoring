<?php


namespace ComputerMonitoring\src\computerMonitoring\Exceptions;


final class ValueIsNotPercentage extends \Exception
{
    /**
     * ValueIsNotPercentage constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        parent::__construct("The value passed is not a percent ($value)");
    }
}