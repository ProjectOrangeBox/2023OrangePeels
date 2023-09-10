<?php

declare(strict_types=1);

use peel\validate\Validate;

final class filterFilenameTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $Filename;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->Filename = new \peel\validate\filters\Filename($this->config,$this->validateParent);
    }

    public function testEmpty(): void
    {
        $this->assertEquals('',$this->Filename->filter('',''));
    }

    public function testString(): void
    {
        $this->assertEquals('',$this->Filename->filter('abc',''));
    }

    public function testInteger(): void
    {
        $this->assertEquals('',$this->Filename->filter(123,''));
    }

    public function testInteger100(): void
    {
        $this->assertEquals('',$this->Filename->filter(100,''));
    }

    public function testInteger200(): void
    {
        $this->assertEquals('',$this->Filename->filter(200,''));
    }

    public function testHex(): void
    {
        $this->assertEquals('',$this->Filename->filter('abc123',''));
    }

    public function testDecimal(): void
    {
        $this->assertEquals('',$this->Filename->filter(123.45,''));
    }

    public function testStdClass(): void
    {
        $this->assertEquals('',$this->Filename->filter(new \StdClass(),''));
    }

    public function testArray(): void
    {
        $this->assertEquals('',$this->Filename->filter([],''));
    }

    public function testAssocArray(): void
    {
        $this->assertEquals('',$this->Filename->filter(['foo'=>'bar'],''));
    }

    public function testTrue(): void
    {
        $this->assertEquals('',$this->Filename->filter(true,''));
    }

    public function testFalse(): void
    {
        $this->assertEquals('',$this->Filename->filter(false,''));
    }

    public function testZero(): void
    {
        $this->assertEquals('',$this->Filename->filter(0,''));
    }

    public function testOne(): void
    {
        $this->assertEquals('',$this->Filename->filter(1,''));
    }

    public function testNull(): void
    {
        $this->assertEquals('',$this->Filename->filter(null,''));
    }

    public function testLetters(): void
    {
        $this->assertEquals('',$this->Filename->filter('abcdefghijklmnopqrstuvwxyz',''));
    }

    public function testUppercase(): void
    {
        $this->assertEquals('',$this->Filename->filter('ABCDEFG',''));
    }

    public function testLowercase(): void
    {
        $this->assertEquals('',$this->Filename->filter('abcdefg',''));
    }

    public function testUuid(): void
    {
        $this->assertEquals('',$this->Filename->filter('50e03466-4810-11ee-be56-0242ac120002',''));
    }

    public function testEmail(): void
    {
        $this->assertEquals('',$this->Filename->filter('johnny@appleseed.com',''));
    }

    public function testEmails(): void
    {
        $this->assertEquals('',$this->Filename->filter('johnny@appleseed.com,jenny@appleseed.com',''));
    }

    public function testBase64(): void
    {
        $this->assertEquals('',$this->Filename->filter('dGVzdA==',''));
    }

    public function testIp(): void
    {
        $this->assertEquals('',$this->Filename->filter('192.168.1.2',''));
    }

    public function testUrl(): void
    {
        $this->assertEquals('',$this->Filename->filter('http://www.example.com',''));
    }

    public function testOneof(): void
    {
        $this->assertEquals('',$this->Filename->filter('a','a,b,c'));
    }


}
