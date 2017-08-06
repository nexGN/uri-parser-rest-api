<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class PathTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $path = new Path('/api.php');

        $this->assertInstanceOf(ValueObject::class, $path);
        $this->assertEquals('/api.php', $path->getValue());
        $this->assertEquals('/api.php', (string) $path);
    }

    /**
     * @test
     * @dataProvider validPaths
     */
    public function itShouldBeValidFor($validPath)
    {
        $this->assertEquals($validPath, (new Path($validPath))->getValue());
    }

    /**
     * @test
     */

    /**
     * @test
     * @dataProvider invalidPaths
     */
    public function itShouldBeInvalidFor($invalidPath)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "path" part must be valid');

        new Path($invalidPath);
    }

    public function validPaths()
    {
        return [
            '/' => ['/'],
            '/../s' => ['/../s'],
            '/../' => ['/../'],
            '../../' => ['../../'],
            '../../dd' => ['../../dd'],
            '../ff' => ['../ff'],
            '../dd$d/g' => ['../dd$d/g'],
            'cos@e/f/f;p' => ['cos@e/f/f;p'],
            'cos/ty;fg/g.txt' => ['cos/ty;fg/g.txt'],
            'test/test.json' => ['test/test.json'],
            '/asa/sadsa;fff/fff;fff' => ['/asa/sadsa;fff/fff;fff'],
            'a:d:b:f' => ['a:d:b:f'],
            '/tta/a;f%54/fff;fff' => ['/asa/sadsa;f%54/fff;fff'],

        ];
    }

    public function invalidPaths()
    {
        return [
            '/#/fff' => ['/#/fff'],
            '/?ddd/#fdd' => ['/?ddd/#fdd'],
            '/ddd/"fdd' => ['/ddd/"fdd'],
            '?ddd/fdf' => ['?ddd/fdf'],
        ];
    }
}
