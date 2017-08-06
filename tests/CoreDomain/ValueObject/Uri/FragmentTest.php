<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class FragmentTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $fragment = new Fragment('key=value');

        $this->assertInstanceOf(ValueObject::class, $fragment);
        $this->assertEquals('key=value', $fragment->getValue());
        $this->assertEquals('key=value', (string) $fragment);
    }

    /**
     * @test
     * @dataProvider validFragments
     */
    public function itShouldBeValidFor($validFragment)
    {
        $this->assertEquals($validFragment, (new Fragment($validFragment))->getValue());
    }

    /**
     * @test
     * @dataProvider invalidFragments
     */
    public function itShouldBeInvalidFor($invalidFragment)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "fragment" part must be valid');

        new Fragment($invalidFragment);
    }

    public function validFragments()
    {
        return [
            '?ddd=jj' => ['?ddd=jj'],
            'k@' => ['k@'],
            'sdsadsadas;%20%21' => ['sdsadsadas;;%20%21'],
        ];
    }

    public function invalidFragments()
    {
        return [
            '.;.' => ['#.;.'],
            '"jkjk'  => ['"jkjk'],
            "\\"  => ['\\'],
            "'`212'"  => ['`212'],
        ];
    }
}
