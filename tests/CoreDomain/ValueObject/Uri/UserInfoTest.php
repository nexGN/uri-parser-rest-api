<?php

namespace UPA\CoreDomain\ValueObject\Uri;

use PHPUnit\Framework\TestCase;
use UPA\GenericDomain\ValueObject;

class UserInfoTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAValueObject()
    {
        $userInfo = new UserInfo('test:test');

        $this->assertInstanceOf(ValueObject::class, $userInfo);
        $this->assertEquals('test:test', $userInfo->getValue());
        $this->assertEquals('test:test', (string) $userInfo);
    }

    /**
     * @test
     * @dataProvider validUserInfos
     */
    public function itShouldBeValidFor($validUserInfo)
    {
        $this->assertEquals($validUserInfo, (new UserInfo($validUserInfo))->getValue());
    }

    /**
     * @test
     * @dataProvider invalidUserInfos
     */
    public function itShouldBeInvalidFor($invalidUserInfo)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('URI "user_information" part must be valid');

        new UserInfo($invalidUserInfo);
    }

    public function validUserInfos()
    {
        return [
            'md:dasd' => ['md:dasd'],
            'mmmm;mmmpp:fff' => ['mmmm;mmmpp:fff'],
            'mmmm;%20%21mmmpp:fff' => ['mmmm;;%20%21mmmpp:fff'],
        ];
    }

    public function invalidUserInfos()
    {
        return [
            'md?dasd' => ['md?dasd'],
            ';mmmm@mmmpp:fff' => [';mmmm@mmmpp:fff'],
            'mmmm@mmmpp:fff' => ['mmmm@mmmpp:fff'],
        ];
    }
}
