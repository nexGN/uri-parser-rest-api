<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject;

use UPA\CoreDomain\ValueObject\Uri\Authority;
use UPA\CoreDomain\ValueObject\Uri\Fragment;
use UPA\CoreDomain\ValueObject\Uri\Path;
use UPA\CoreDomain\ValueObject\Uri\Query;
use UPA\CoreDomain\ValueObject\Uri\Scheme;
use UPA\GenericDomain\ValueObject;

class Uri implements ValueObject
{
    /**
     * @var Scheme
     */
    private $scheme;

    /**
     * @var Authority
     */
    private $authority;

    /**
     * @var Path
     */
    private $path;

    /**
     * @var Query
     */
    private $query;

    /**
     * @var Fragment
     */
    private $fragment;

    /**
     * Uri constructor.
     * @param Scheme $scheme
     * @param Path $path
     * @param null|Authority $authority
     * @param null|Query $query
     * @param null|Fragment $fragment
     */
    public function __construct(
        ?Scheme $scheme,
        Path $path,
        ?Authority $authority = null,
        ?Query $query = null,
        ?Fragment $fragment = null
    ) {
        if ($authority && $path->getValue() && !$path->isAbsolute()) {
            throw new \InvalidArgumentException('Path "part" must be absolute when authority "part" exists');
        }

        $this->scheme = $scheme;
        $this->authority = $authority;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    /**
     * @return Scheme
     */
    public function getScheme(): Scheme
    {
        return $this->scheme;
    }

    /**
     * @return Authority
     */
    public function getAuthority(): ?Authority
    {
        return $this->authority;
    }

    /**
     * @return Path
     */
    public function getPath(): Path
    {
        return $this->path;
    }

    /**
     * @return Query
     */
    public function getQuery(): ?Query
    {
        return $this->query;
    }

    /**
     * @return Fragment
     */
    public function getFragment(): ?Fragment
    {
        return $this->fragment;
    }

    /**
     * @return array
     */
    public function getValue() : array
    {
        return [
            'scheme' => $this->scheme->getValue(),
            'authority' => $this->authority ? $this->authority->getValue() : null,
            'path' => $this->path->getValue(),
            'query' => $this->query ? $this->query->getValue() : null,
            'fragment' => $this->fragment ? $this->fragment->getValue() : null,
        ];
    }

    public function __toString(): string
    {
        $string = '' . $this->scheme . ':';

        if ($this->authority) {
            $string .= '//' . $this->authority;
        }

        $string .= $this->path;

        if ($this->query) {
            $string .= '?' . $this->query;
        }

        if ($this->fragment) {
            $string .= '#' . $this->fragment;
        }

        return $string;
    }
}
