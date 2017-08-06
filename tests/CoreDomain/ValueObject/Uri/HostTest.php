<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class HostTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $host = new Host('www.example.org');

        $this->assertInstanceOf(ValueObject::class, $host);
        $this->assertEquals('www.example.org', $host->getValue());
        $this->assertEquals('www.example.org', (string) $host);
    }

    /**
     * @test
     * @dataProvider validHosts
     */
    public function itShouldBeValidFor($validHost)
    {
        $this->assertEquals($validHost, (new Host($validHost))->getValue());
    }

    /**
     * @test
     * @dataProvider invalidHosts
     */
    public function itShouldBeInvalidFor($invalidHost)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "host" part must be valid domain or ip4 address');

        new Host($invalidHost);
    }

    public function validHosts()
    {
        return [
            'example.org' => ['example.org'],
            'www.example.org' => ['www.example.org'],
            'wp.pl' => ['wp.pl'],
            'a-b-c.net' => ['a-b-c.net'],
            '10.0.0.1' => ['10.0.0.1'],
            '192.168.0.254' => ['192.168.0.254'],
        ];
    }

    public function invalidHosts()
    {
        return [
            '-d.' => ['-d'],
            '192.256.0.1' => ['192.256.0.1'],
            '300.0.0.22' => ['300.0.0.22'],
            'wp:wp.pl' => ['wp:wp.pl'],
        ];
    }
}
