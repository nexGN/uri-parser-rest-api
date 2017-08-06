<?php
declare(strict_types=1);

namespace UPA\CoreDomain;

class UriParser
{
    private const SCHEME_REGEXP_PART = '(?:(?P<scheme>[^:\/\?#]+):)?';
    private const AUTHORITY_REGEXP_PART = '(?:\/\/(?P<authority>[^\/\?#]*))?';
    private const PATH_REGEXP_PART = '(?P<path>[^\?#]*)';
    private const QUERY_REGEXP_PART = '(?:\?(?P<query>[^#]*))?';
    private const FRAGMENT_REGEXP_PART = '(?:#(?P<fragment>.*))?';

    private const URI_MATCH_REGEXP = '/^'
        . self::SCHEME_REGEXP_PART
        . self::AUTHORITY_REGEXP_PART
        . self::PATH_REGEXP_PART
        . self::QUERY_REGEXP_PART
        . self::FRAGMENT_REGEXP_PART
        . '$/';

    private const USER_INFO_REGEXP = '(?:(?P<user_info>[^@]+)@)?';
    private const HOST_REGEXP = '(?P<host>[^@:]+)';
    private const PORT_REGEXP = '(?::(?P<port>\d+))?';

    private const AUTHORITY_REGEXP = '/^' . self::USER_INFO_REGEXP . self::HOST_REGEXP . self::PORT_REGEXP . '$/';

    /**
     * @param string $uriString
     * @return string[]
     * @throws \InvalidArgumentException
     */
    public function parse(string $uriString): array
    {
        if (!preg_match(self::URI_MATCH_REGEXP, $uriString, $matches)) {
            throw new \InvalidArgumentException('Invalid URI'); // For 99,9% these will never happend
        }

        $parsedData = $this->filterMatches($matches);

        $authority = null;
        if (isset($parsedData['authority']) && $parsedData['authority']) {
            if (preg_match(self::AUTHORITY_REGEXP, $parsedData['authority'], $authorityMatches)) {
                $parsedData += $this->filterMatches($authorityMatches);
            } else {
                throw new \InvalidArgumentException('Invalid URI "authority" part');
            }
        }

        return $parsedData;
    }

    /**
     * @param array $matches
     * @return string[]
     */
    private function filterMatches(array $matches): array
    {
        return array_filter(
            $matches,
            function ($value, $key) {
                return is_string($key) && !empty($value);
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
}
