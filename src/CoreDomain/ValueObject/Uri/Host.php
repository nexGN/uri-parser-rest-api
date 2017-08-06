<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

use UPA\GenericDomain\ValueObject;

class Host implements ValueObject
{
    private const DOMAIN_REGEXP = "/^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}$/";

    /**
     * @var string
     */
    private $host;

    /**
     * Host constructor.
     * @param string $host
     * @throws \InvalidArgumentException
     */
    public function __construct(string $host)
    {
        if (!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
            && !preg_match(self::DOMAIN_REGEXP, $host)
        ) {
            throw new \InvalidArgumentException('URI "host" part must be valid domain or ip4 address');
        }

        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->host;
    }

    public function __toString(): string
    {
        return (string) $this->host;
    }
}
