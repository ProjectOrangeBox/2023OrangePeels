<?php

declare(strict_types=1);

use peel\validate\Validate;

final class filterLengthTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $Length;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->Length = new \peel\validate\filters\Length($this->config,$this->validateParent);
    }

    public function testEmpty(): void
    {
        $this->assertEquals('',$this->Length->filter('',''));
    }

    public function testString(): void
    {
        $this->assertEquals('',$this->Length->filter('abc',''));
    }

    public function testInteger(): void
    {
        $this->assertEquals('',$this->Length->filter(123,''));
    }

    public function testInteger100(): void
    {
        $this->assertEquals('',$this->Length->filter(100,''));
    }

    public function testInteger200(): void
    {
        $this->assertEquals('',$this->Length->filter(200,''));
    }

    public function testHex(): void
    {
        $this->assertEquals('',$this->Length->filter('abc123',''));
    }

    public function testDecimal(): void
    {
        $this->assertEquals('',$this->Length->filter(123.45,''));
    }

    public function testStdClass(): void
    {
        $this->assertEquals('',$this->Length->filter(new \StdClass(),''));
    }

    public function testArray(): void
    {
        $this->assertEquals('',$this->Length->filter([],''));
    }

    public function testAssocArray(): void
    {
        $this->assertEquals('',$this->Length->filter(['foo'=>'bar'],''));
    }

    public function testTrue(): void
    {
        $this->assertEquals('',$this->Length->filter(true,''));
    }

    public function testFalse(): void
    {
        $this->assertEquals('',$this->Length->filter(false,''));
    }

    public function testZero(): void
    {
        $this->assertEquals('',$this->Length->filter(0,''));
    }

    public function testOne(): void
    {
        $this->assertEquals('',$this->Length->filter(1,''));
    }

    public function testNull(): void
    {
        $this->assertEquals('',$this->Length->filter(null,''));
    }

    public function testLetters(): void
    {
        $this->assertEquals('',$this->Length->filter('abcdefghijklmnopqrstuvwxyz',''));
    }

    public function testUppercase(): void
    {
        $this->assertEquals('',$this->Length->filter('ABCDEFG',''));
    }

    public function testLowercase(): void
    {
        $this->assertEquals('',$this->Length->filter('abcdefg',''));
    }

    public function testUuid(): void
    {
        $this->assertEquals('',$this->Length->filter('50e03466-4810-11ee-be56-0242ac120002',''));
    }

    public function testEmail(): void
    {
        $this->assertEquals('',$this->Length->filter('johnny@appleseed.com',''));
    }

    public function testEmails(): void
    {
        $this->assertEquals('',$this->Length->filter('johnny@appleseed.com,jenny@appleseed.com',''));
    }

    public function testBase64(): void
    {
        $this->assertEquals('',$this->Length->filter('dGVzdA==',''));
    }

    public function testIp(): void
    {
        $this->assertEquals('',$this->Length->filter('192.168.1.2',''));
    }

    public function testUrl(): void
    {
        $this->assertEquals('',$this->Length->filter('http://www.example.com',''));
    }

    public function testOneof(): void
    {
        $this->assertEquals('',$this->Length->filter('a','a,b,c'));
    }


}
