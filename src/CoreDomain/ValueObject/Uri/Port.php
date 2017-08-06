<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

use UPA\GenericDomain\ValueObject;

class Port implements ValueObject
{
    private const PORT_REGEXP = "/^0$|^[1-9]\d{0,4}$/";
    /**
     * @var int
     */
    private $number;

    /**
     * Port constructor.
     * @param string $port
     * @throws \InvalidArgumentException
     */
    public function __construct(string $port)
    {
        if (!preg_match(self::PORT_REGEXP, $port)
            || (int) $port > 65535
        ) {
            throw new \InvalidArgumentException('URI "port" part must be a number in range between 0 and 65535');
        }

        $this->number = (int) $port;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->number;
    }

    public function __toString(): string
    {
        return (string) $this->number;
    }
}
