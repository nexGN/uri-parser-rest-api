<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

use UPA\GenericDomain\ValueObject;

class Scheme implements ValueObject
{
    private const SCHEME_REGEXP = '/^[a-zA-Z][a-zA-Z0-9+\-\.]*$/';

    /**
     * @var string
     */
    private $scheme;

    /**
     * Scheme constructor.
     * @param string $scheme
     * @throws \InvalidArgumentException
     */
    public function __construct(string $scheme)
    {
        if (!$scheme) {
            throw new \InvalidArgumentException('URI "scheme" part is required');
        }

        if (!preg_match(self::SCHEME_REGEXP, $scheme)) {
            throw new \InvalidArgumentException('URI "scheme" part must be valid');
        }

        $this->scheme = $scheme;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->scheme;
    }

    public function __toString(): string
    {
        return $this->scheme;
    }
}
