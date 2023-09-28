<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\exceptions\ValidationFailed;

final class ruleIsStringTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $isString;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->isString = new \peel\validate\rules\isString($this->config,$this->validateParent);
    }

    public function testEmpty(): void
    {
        $value = '';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testString(): void
    {
        $value = 'abc';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger(): void
    {
        $value = 123;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger100(): void
    {
        $value = 100;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger200(): void
    {
        $value = 200;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testHex(): void
    {
        $value = 'abc123';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testDecimal(): void
    {
        $value = 123.45;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testStdClass(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = new \StdClass();

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = [];

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testAssocArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = ['foo'=>'bar'];

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testTrue(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = true;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testFalse(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = false;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testZero(): void
    {
        $value = 0;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOne(): void
    {
        $value = 1;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testNull(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = null;

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLetters(): void
    {
        $value = 'abcdefghijklmnopqrstuvwxyz';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUppercase(): void
    {
        $value = 'ABCDEFG';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLowercase(): void
    {
        $value = 'abcdefg';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUuid(): void
    {
        $value = '50e03466-4810-11ee-be56-0242ac120002';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmail(): void
    {
        $value = 'johnny@appleseed.com';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmails(): void
    {
        $value = 'johnny@appleseed.com,jenny@appleseed.com';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testBase64(): void
    {
        $value = 'dGVzdA==';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testIp(): void
    {
        $value = '192.168.1.2';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUrl(): void
    {
        $value = 'http://www.example.com';

        $this->isString->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOneof(): void
    {
        $value = 'a';

        $this->isString->isValid($value,'a,b,c');

        // if we get here then it's valid
        $this->assertTrue(true);
    }


}
