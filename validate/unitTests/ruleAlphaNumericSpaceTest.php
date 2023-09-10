<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\exceptions\ValidationFailed;

final class ruleAlphaNumericSpaceTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $alphaNumericSpace;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->alphaNumericSpace = new \peel\validate\rules\alphaNumericSpace($this->config,$this->validateParent);
    }

    public function testEmpty(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testString(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abc';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 123;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger100(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 100;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger200(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 200;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testHex(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abc123';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testDecimal(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 123.45;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testStdClass(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = new \StdClass();

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = [];

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testAssocArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = ['foo'=>'bar'];

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testTrue(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = true;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testFalse(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = false;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testZero(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 0;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOne(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 1;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testNull(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = null;

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLetters(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefghijklmnopqrstuvwxyz';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUppercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'ABCDEFG';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLowercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefg';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUuid(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '50e03466-4810-11ee-be56-0242ac120002';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmail(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmails(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com,jenny@appleseed.com';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testBase64(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'dGVzdA==';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testIp(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '192.168.1.2';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUrl(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'http://www.example.com';

        $this->alphaNumericSpace->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOneof(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'a';

        $this->alphaNumericSpace->isValid($value,'a,b,c');

        // if we get here then it's valid
        $this->assertTrue(true);
    }


}
