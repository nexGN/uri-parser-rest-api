<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

use UPA\GenericDomain\ValueObject;

class Path implements ValueObject
{
    private const ENCODED = '%[0-9A-Fa-f]{2}';
    private const ALPHANUMERIC = 'a-zA-Z0-9';

    private const SEGMENT_REGEXP = '([' . self::ALPHANUMERIC . ":@&=+$\-_\.!~*'();,]|" . self::ENCODED . ')+';
    private const PATH_REGEXP = "/^\/$|^(\/?" . self::SEGMENT_REGEXP . '(;' . self::SEGMENT_REGEXP. ')*)+\/?$/';

    /**
     * @var string
     */
    private $path;

    /**
     * Path constructor.
     * @param null|string $path
     * @throws \InvalidArgumentException
     */
    public function __construct(?string $path = null)
    {
        if ($path && !preg_match(self::PATH_REGEXP, $path)) {
            throw new \InvalidArgumentException('URI "path" part must be valid');
        }

        $this->path = $path ?: '';
    }

    public function isAbsolute(): bool
    {
        return $this->path[0] === '/';
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->path;
    }

    public function __toString(): string
    {
        return (string) $this->path;
    }
}
