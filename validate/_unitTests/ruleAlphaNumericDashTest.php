<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\exceptions\ValidationFailed;

final class ruleAlphaNumericDashTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $alphaNumericDash;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->alphaNumericDash = new \peel\validate\rules\alphaNumericDash($this->config,$this->validateParent);
    }

    public function testEmpty(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testString(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abc';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 123;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger100(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 100;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger200(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 200;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testHex(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abc123';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testDecimal(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 123.45;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testStdClass(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = new \StdClass();

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = [];

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testAssocArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = ['foo'=>'bar'];

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testTrue(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = true;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testFalse(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = false;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testZero(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 0;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOne(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 1;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testNull(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = null;

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLetters(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefghijklmnopqrstuvwxyz';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUppercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'ABCDEFG';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLowercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefg';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUuid(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '50e03466-4810-11ee-be56-0242ac120002';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmail(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmails(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com,jenny@appleseed.com';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testBase64(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'dGVzdA==';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testIp(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '192.168.1.2';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUrl(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'http://www.example.com';

        $this->alphaNumericDash->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOneof(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'a';

        $this->alphaNumericDash->isValid($value,'a,b,c');

        // if we get here then it's valid
        $this->assertTrue(true);
    }


}
