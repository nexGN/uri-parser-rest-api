<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class AuthorityTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $authority = new Authority(new Host('example.org'));

        $this->assertInstanceOf(ValueObject::class, $authority);
        $this->assertEquals(
            [
                'user_information' => null,
                'host' => 'example.org',
                'port' => null,
            ],
            $authority->getValue()
        );
        $this->assertEquals('example.org', (string) $authority);
    }

    /**
     * @test
     * @dataProvider validAuthorities
     */
    public function itShouldBeValidFor($validAuthority, $validValue)
    {
        $authority = new Authority($validAuthority['host'], $validAuthority['user_info'], $validAuthority['port']);

        $this->assertEquals($validValue, $authority->getValue());
        $this->assertEquals($validAuthority['string'], (string) $authority);
    }

    public function validAuthorities()
    {
        return [
            'user:password@wp.pl:8180' => [
                'expectedAuthority' =>[
                    'string' => 'user:password@wp.pl:8180',
                    'user_info' => new UserInfo('user:password'),
                    'host' => new Host('wp.pl'),
                    'port' => new Port('8180'),
                ],
                'expectedValue' => [
                    'user_information' => 'user:password',
                    'host' => 'wp.pl',
                    'port' => 8180,
                ],
            ],
            'onet.pl:80' => [
                'expectedAuthority' =>[
                    'string' => 'onet.pl:80',
                    'user_info' => null,
                    'host' => new Host('onet.pl'),
                    'port' => new Port('80'),
                ],
                'expectedValue' => [
                    'user_information' => null,
                    'host' => 'onet.pl',
                    'port' => 80,
                ],
            ],
            'olx.pl' => [
                'expectedAuthority' =>[
                    'string' => 'olx.pl',
                    'user_info' => null,
                    'host' => new Host('olx.pl'),
                    'port' => null,
                ]
                ,'expectedValue' => [
                    'user_information' => null,
                    'host' => 'olx.pl',
                    'port' => null,
                ],
            ],
            'www.olx.pl' => [
                'expectedAuthority' =>[
                    'string' => 'www.olx.pl',
                    'user_info' => null,
                    'host' => new Host('www.olx.pl'),
                    'port' => null,
                ],
                'expectedValue' => [
                    'user_information' => null,
                    'host' => 'www.olx.pl',
                    'port' => null,
                ],
            ],
        ];
    }
}
