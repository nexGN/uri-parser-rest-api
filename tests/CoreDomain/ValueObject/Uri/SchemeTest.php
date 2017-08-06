<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class SchemeTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $scheme = new Scheme('ftp');

        $this->assertInstanceOf(ValueObject::class, $scheme);
        $this->assertEquals('ftp', $scheme->getValue());
        $this->assertEquals('ftp', (string) $scheme);
    }

    /**
     * @test
     * @dataProvider validSchemes
     */
    public function itShouldBeValidFor($validScheme)
    {
        $this->assertEquals($validScheme, (new Scheme($validScheme))->getValue());
    }

    /**
     * @test
     */
    public function itShouldBeRequired()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "scheme" part is required');

        new Scheme('');
    }

    /**
     * @test
     * @dataProvider invalidSchemes
     */
    public function itShouldBeInvalidFor($invalidScheme)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "scheme" part must be valid');

        new Scheme($invalidScheme);
    }

    public function validSchemes()
    {
        return [
            'ftp' => ['ftp'],
            'ldap' => ['ldap'],
            'ajp' => ['ajp'],
            'amqp' => ['amqp'],
            'http' => ['http'],
            'c-.+06A' => ['c-.+06A'],
        ];
    }

    public function invalidSchemes()
    {
        return [
            '00' => ['-0'],
            '+2s' => ['-21'],
            '-sdd0' => ['-80'],
            '.8081' => ['-8081'],
            ':fff' => ['-9000'],
            's!65535' => ['-65535'],
        ];
    }
}
