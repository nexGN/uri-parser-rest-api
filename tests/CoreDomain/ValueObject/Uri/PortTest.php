<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class PortTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $port = new Port('8081');

        $this->assertInstanceOf(ValueObject::class, $port);
        $this->assertEquals(8081, $port->getValue());
        $this->assertEquals('8081', (string) $port);
    }

    /**
     * @test
     * @dataProvider validPortNumbers
     */
    public function itShouldBeValidForNumberBetween0And65535($portNumber)
    {
        $this->assertEquals($portNumber, (new Port((string) $portNumber))->getValue());
    }

    /**
     * @test
     * @dataProvider invalidPortNumbers
     */
    public function itShouldBeInvalidForNotANumberOrNumberOutOfRangeBetween0And65535($invalidPortNumber)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "port" part must be a number in range between 0 and 65535');

        new Port($invalidPortNumber);
    }

    public function validPortNumbers()
    {
        return [
            '0' => ['0'],
            '21' => ['21'],
            '80' => ['80'],
            '8081' => ['8081'],
            '9000' => ['9000'],
            '65535' => ['65535'],
        ];
    }

    public function invalidPortNumbers()
    {
        return [
            '-0' => ['-0'],
            '-21' => ['-21'],
            '-80' => ['-80'],
            '-8081' => ['-8081'],
            '-9000' => ['-9000'],
            '-65535' => ['-65535'],
            '65536' => ['65536'],
            '655361' => ['655361'],
            '6553620' => ['6553620'],
            '65536333' => ['65536333'],
            '655364000' => ['655364000'],
            '0 a' => ['0 a'],
            'd21' => ['d21'],
            '$80' => ['$80'],
            '!8081' => ['!8081'],
            'port' => ['port'],
            ':port' => [':port'],
        ];
    }
}
