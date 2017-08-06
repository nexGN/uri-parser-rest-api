<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

use UPA\GenericDomain\ValueObject;

class UserInfo implements ValueObject
{
    private const ENCODED = '%[0-9A-Fa-f]{2}';

    private const USERINFO_REGEXP = "/^[a-zA-Z0-9]([a-zA-Z0-9\-_\.!~*'();:&=+$,]|" . self::ENCODED . ')+$/';
    /**
     * @var string
     */
    private $userInfo;

    /**
     * UserInfo constructor.
     * @param string $userInfo
     * @throws \InvalidArgumentException
     */
    public function __construct(string $userInfo)
    {
        if (!preg_match(self::USERINFO_REGEXP, $userInfo)) {
            throw new \InvalidArgumentException('URI "user_information" part must be valid');
        }

        $this->userInfo = $userInfo;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->userInfo;
    }

    public function __toString(): string
    {
        return (string) $this->userInfo;
    }
}
