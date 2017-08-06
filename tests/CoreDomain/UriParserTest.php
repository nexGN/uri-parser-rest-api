<?php

namespace UPA\CoreDomain;

use PHPUnit\Framework\TestCase;

class UriParserTest extends TestCase
{
    /**
     * @var UriParser
     */
    private $uriParser;

    protected function setUp()
    {
        $this->uriParser = new UriParser();
    }

    /**
     * @test
     * @dataProvider validUris
     */
    public function itShouldParseValidUri(string $uriString, array $expectedData)
    {
        $parsedData = $this->uriParser->parse($uriString);

        $this->assertEquals($expectedData, $parsedData);
    }

    public function validUris()
    {
        return [
            'mailto:mstrzele@wp.pl' => [
                'uri' => 'mailto:mstrzele@wp.pl',
                'expected' => [
                    'scheme' =>'mailto',
                    'path' => 'mstrzele@wp.pl',
                ],
            ],
            'urn:example:mammal:monotreme:echidna' => [
                'uri' => 'urn:example:mammal:monotreme:echidna',
                'expected' => [
                    'scheme' => 'urn',
                    'path' => 'example:mammal:monotreme:echidna',
                ],
            ],
            'ldap://ldap.example.com:636/cn=Jan%20Kowalski,dc=example,dc=com?cn,mail,telephoneNumber' => [
                'uri' => 'ldap://ldap.example.com:636/cn=Jan%20Kowalski,dc=example,dc=com?cn,mail,telephoneNumber',
                'expected' => [
                    'scheme' => 'ldap',
                    'path' => '/cn=Jan%20Kowalski,dc=example,dc=com',
                    'authority' => 'ldap.example.com:636',
                    'host' => 'ldap.example.com',
                    'port' => '636',
                    'query' => 'cn,mail,telephoneNumber',
                ],
            ],
            'http://symfony.com/doc/current/components/using_components.html?cos#takiego' => [
                'uri' => 'http://symfony.com/doc/current/components/using_components.html?cos#takiego',
                'expected' => [
                    'scheme' => 'http',
                    'path' => '/doc/current/components/using_components.html',
                    'authority' => 'symfony.com',
                    'host' => 'symfony.com',
                    'query' => 'cos',
                    'fragment' => 'takiego'
                ],
            ],
            'ftp://mstrzele@wp.pl:21/uploads' => [
                'uri' => 'ftp://mstrzele@wp.pl:21/uploads',
                'expected' => [
                    'scheme' => 'ftp',
                    'path' => '/uploads',
                    'authority' => 'mstrzele@wp.pl:21',
                    'user_info' => 'mstrzele',
                    'host' => 'wp.pl',
                    'port' => '21',
                ],
            ],
            '/relative/URI/with/absolute/path/to/resource.txt' => [
                'uri' => '/relative/URI/with/absolute/path/to/resource.txt',
                'expected' => [
                    'path' => '/relative/URI/with/absolute/path/to/resource.txt',
                ],
            ],
            '../../../resource.txt' => [
                'uri' => '../../../resource.txt',
                'expected' => [
                    'path' => '../../../resource.txt',
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function itShouldFailOnParsingUriWithInvalidAuthorityPartSyntax()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URI "authority" part');

        $this->uriParser->parse('ftp://m@istrzele@wp.pl/dddd');
    }
}
