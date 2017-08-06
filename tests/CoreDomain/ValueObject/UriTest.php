<?php

namespace UPA\CoreDomain\ValueObject;

use PHPUnit\Framework\TestCase;
use UPA\CoreDomain\ValueObject\Uri\Authority;
use UPA\CoreDomain\ValueObject\Uri\Fragment;
use UPA\CoreDomain\ValueObject\Uri\Host;
use UPA\CoreDomain\ValueObject\Uri\Path;
use UPA\CoreDomain\ValueObject\Uri\Port;
use UPA\CoreDomain\ValueObject\Uri\Query;
use UPA\CoreDomain\ValueObject\Uri\Scheme;
use UPA\CoreDomain\ValueObject\Uri\UserInfo;
use UPA\GenericDomain\ValueObject;

class UriTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $uri = new Uri(new Scheme('uri'), new Path('path'));

        $this->assertInstanceOf(ValueObject::class, $uri);
        $this->assertEquals(
            [
                'scheme' => 'uri',
                'authority' => null,
                'path' => 'path',
                'query' => null,
                'fragment' => null,
            ],
            $uri->getValue()
        );
        $this->assertEquals('uri:path', (string) $uri);
    }

    /**
     * @test
     * @dataProvider validUrisParts
     */
    public function itShouldBeValidFor($validUri, $validUriParts, $validValue)
    {
        $uri = new Uri(
            $validUriParts['scheme'],
            $validUriParts['path'],
            $validUriParts['authority'],
            $validUriParts['query'],
            $validUriParts['fragment']
        );

        $this->assertEquals($validValue, $uri->getValue());
        $this->assertEquals($validUri, (string) $uri);
    }

    /**
     * @test
     */
    public function itShouldBeAbsolutePathRequiredWhenAuthorityExists()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Path "part" must be absolute when authority "part" exists');

        new Uri(
            new Scheme('ftp'),
            new Path('path'),
            new Authority(new Host('example.org'))
        );
    }

    public function validUrisParts()
    {
        return [
            'http://olx.pl' => [
                'uri' => 'http://olx.pl',
                'parts' => [
                    'scheme' => new Scheme('http'),
                    'authority' => new Authority(
                        new Host('olx.pl')
                    ),
                    'path' => new Path(),
                    'query' => null,
                    'fragment' => null,
                ],
                'value' => [
                    'scheme' => 'http',
                    'authority' => [
                        'user_information' => null,
                        'host' => 'olx.pl',
                        'port' => null,
                    ],
                    'path' => '',
                    'query' => null,
                    'fragment' => null,
                ],
            ],
            'ftp://example.org/upload' => [
                'uri' => 'ftp://example.org/upload',
                'parts' => [
                    'scheme' => new Scheme('ftp'),
                    'authority' => new Authority(
                        new Host('example.org')
                    ),
                    'path' => new Path('/upload'),
                    'query' => null,
                    'fragment' => null,
                ],
                'value' => [
                    'scheme' => 'ftp',
                    'authority' => [
                        'user_information' => null,
                        'host' => 'example.org',
                        'port' => null,
                    ],
                    'path' => '/upload',
                    'query' => null,
                    'fragment' => null,
                ],
            ],
            'ftp://mstrzele:qwe123@olx.pl:21/rekrutacja/upload' => [
                'uri' => 'ftp://mstrzele:qwe123@olx.pl:21/rekrutacja/upload',
                'parts' => [
                    'scheme' => new Scheme('ftp'),
                    'authority' => new Authority(
                        new Host('olx.pl'),
                        new UserInfo('mstrzele:qwe123'),
                        new Port('21')
                    ),
                    'path' => new Path('/rekrutacja/upload'),
                    'query' => null,
                    'fragment' => null,
                ],
                'value' => [
                    'scheme' => 'ftp',
                    'authority' => [
                        'user_information' => 'mstrzele:qwe123',
                        'host' => 'olx.pl',
                        'port' => 21,
                    ],
                    'path' => '/rekrutacja/upload',
                    'query' => null,
                    'fragment' => null,
                ],
            ],
            'https://www.olx.pl/praca/informatyka/q-php/?fikcyjne_query#fikcyjny_fragment' => [
                'uri' => 'https://www.olx.pl/praca/informatyka/q-php/?fikcyjne_query#fikcyjny_fragment',
                'parts' => [
                    'scheme' => new Scheme('https'),
                    'authority' => new Authority(
                        new Host('www.olx.pl')
                    ),
                    'path' => new Path('/praca/informatyka/q-php/'),
                    'query' => new Query('fikcyjne_query'),
                    'fragment' => new Fragment('fikcyjny_fragment'),
                ],
                'value' => [
                    'scheme' => 'https',
                    'authority' => [
                        'user_information' => null,
                        'host' => 'www.olx.pl',
                        'port' => null,
                    ],
                    'path' => '/praca/informatyka/q-php/',
                    'query' => 'fikcyjne_query',
                    'fragment' => 'fikcyjny_fragment',
                ],
            ],
            'ldap://ldap.example.com:636/cn=Jan%20Kowalski,dc=example,dc=com?cn,mail,telephoneNumber'=> [
                'uri' => 'ldap://ldap.example.com:636/cn=Jan%20Kowalski,dc=example,dc=com?cn,mail,telephoneNumber',
                'parts' => [
                    'scheme' => new Scheme('ldap'),
                    'authority' => new Authority(
                        new Host('ldap.example.com'),
                        null,
                        new Port('636')
                    ),
                    'path' => new Path('/cn=Jan%20Kowalski,dc=example,dc=com'),
                    'query' => new Query('cn,mail,telephoneNumber'),
                    'fragment' => null,
                ],
                'value' => [
                    'scheme' => 'ldap',
                    'authority' => [
                        'user_information' => null,
                        'host' => 'ldap.example.com',
                        'port' => 636,
                    ],
                    'path' => '/cn=Jan%20Kowalski,dc=example,dc=com',
                    'query' => 'cn,mail,telephoneNumber',
                    'fragment' => null,
                ],
            ],
        ];
    }
}
