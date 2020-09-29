<?php


namespace ComputerMonitoring\src\shared\ValueObjects;

use Exception;
use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    protected $value;

    /**
     * Uuid constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->ensureIsValidUuid($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param Uuid $other
     * @return bool
     */
    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    /**
     * @param $id
     */
    public function ensureIsValidUuid($id)
    {
        if(!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }

    /**
     * @return static
     * @throws Exception
     */
    public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }


    /**
     * @return string
     */
    public function __toString(): string {
        return $this->value();
    }

}