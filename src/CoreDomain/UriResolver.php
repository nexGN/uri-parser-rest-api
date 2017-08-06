<?php
declare(strict_types=1);

namespace UPA\CoreDomain;

use UPA\CoreDomain\ValueObject\Uri;

class UriResolver
{
    /**
     * @var UriParser
     */
    private $uriParser;

    public function __construct(UriParser $uriParser)
    {
        $this->uriParser = $uriParser;
    }

    public function resolve(string $uriString): Uri
    {
        $uriParts = $this->uriParser->parse($uriString);

        $authority = null;
        if (isset($uriParts['host'])) {
            $authority = new Uri\Authority(
                new Uri\Host($uriParts['host']),
                isset($uriParts['user_info']) ? new Uri\UserInfo($uriParts['user_info']) : null,
                isset($uriParts['port']) ? new Uri\Port($uriParts['port']) : null
            );
        }

        return new Uri(
            isset($uriParts['scheme']) ? new Uri\Scheme($uriParts['scheme']) : null,
            new Uri\Path($uriParts['path'] ?? null),
            $authority,
            isset($uriParts['query']) ? new Uri\Query($uriParts['query']) : null,
            isset($uriParts['fragment']) ? new Uri\Fragment($uriParts['fragment']) : null
        );
    }
}
