<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class QueryTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $query = new Query('key=value');

        $this->assertInstanceOf(ValueObject::class, $query);
        $this->assertEquals('key=value', $query->getValue());
        $this->assertEquals('key=value', (string) $query);
    }

    /**
     * @test
     * @dataProvider validQuerys
     */
    public function itShouldBeValidFor($validQuery)
    {
        $this->assertEquals($validQuery, (new Query($validQuery))->getValue());
    }

    /**
     * @test
     * @dataProvider invalidQuerys
     */
    public function itShouldBeInvalidFor($invalidQuery)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "query" part must be valid');

        new Query($invalidQuery);
    }

    public function validQuerys()
    {
        return [
            '?ddd=jj' => ['?ddd=jj'],
            'k=10&12=er' => ['k=10&12=er'],
            ';%20%21' => [';%20%21'],
        ];
    }

    public function invalidQuerys()
    {
        return [
            '#.;.' => ['#.;.'],
            '"jkjk'  => ['"jkjk'],
            "\\"  => ['\\'],
            "'f=`212'"  => ['f=`212'],
        ];
    }
}
