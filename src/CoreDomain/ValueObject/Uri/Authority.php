<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

use UPA\GenericDomain\ValueObject;

class Authority implements ValueObject
{
    /**
     * @var UserInfo
     */
    private $userInfo;

    /**
     * @var Host
     */
    private $host;

    /**
     * @var Port
     */
    private $port;

    /**
     * Authority constructor.
     * @param Host $host
     * @param null|UserInfo $userInfo
     * @param null|Port $port
     */
    public function __construct(Host $host, ?UserInfo $userInfo = null, ?Port $port = null)
    {
        $this->host = $host;
        $this->userInfo = $userInfo;
        $this->port = $port;
    }

    /**
     * @return UserInfo
     */
    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    /**
     * @return Host
     */
    public function getHost(): Host
    {
        return $this->host;
    }

    /**
     * @return Port
     */
    public function getPort(): ?Port
    {
        return $this->port;
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return [
            'user_information' => $this->userInfo ? $this->userInfo->getValue() : null,
            'host' => $this->host->getValue(),
            'port' => $this->port ? $this->port->getValue() : null,
        ];
    }

    public function __toString(): string
    {
        $string = '';
        if ($this->userInfo) {
            $string .= $this->userInfo . '@';
        }
        if ($this->host) {
            $string .= $this->host;
        }

        if ($this->port) {
            $string .= ':' . $this->port;
        }

        return $string;
    }
}
