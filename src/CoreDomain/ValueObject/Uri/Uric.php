<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

use UPA\GenericDomain\ValueObject;

abstract class Uric implements ValueObject
{
    private const ENCODED = '%[0-9A-Fa-f]{2}';
    private const ALPHANUMERIC = 'a-zA-Z0-9';
    private const RESERVED = ';\/\?:@&=+$,';
    private const UNRESERVED = self::ALPHANUMERIC . "\-_\.!~*'()";

    private const URIC_REGEXP = '/^([' . self::UNRESERVED . self::RESERVED . ']|' . self::ENCODED . ')+$/';

    /**
     * @var string
     */
    private $uric;

    /**
     * Uric constructor.
     * @param string $uric
     * @throws \InvalidArgumentException
     */
    public function __construct(string $name, string $uric)
    {
        if (!preg_match(self::URIC_REGEXP, $uric)) {
            throw new \InvalidArgumentException("URI \"{$name}\" part must be valid");
        }

        $this->uric = $uric;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->uric;
    }

    public function __toString(): string
    {
        return (string) $this->uric;
    }
}
