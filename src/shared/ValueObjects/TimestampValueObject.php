<?php


namespace ComputerMonitoring\src\shared\ValueObjects;


class TimestampValueObject
{
    protected $value;

    /**
     * TimestampValueObject constructor.
     * @param \DateTimeImmutable $value
     */
    public function __construct(\DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function create(): self
    {
        return new static(new \DateTimeImmutable());
    }

    /**
     * @param string $date
     * @return static
     * @throws \Exception
     */
    public static function fromString(string $date): self
    {
        return new static(new \DateTimeImmutable($date));
    }

    /**
     * @return \DateTimeImmutable
     */
    public function value(): \DateTimeImmutable {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string{
        return $this->value()->format('Y-m-d H:i:s');
    }

}