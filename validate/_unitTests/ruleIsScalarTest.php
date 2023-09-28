<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\exceptions\ValidationFailed;

final class ruleIsScalarTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $isScalar;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->isScalar = new \peel\validate\rules\isScalar($this->config,$this->validateParent);
    }

    public function testEmpty(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testString(): void
    {
        $value = 'abc';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger(): void
    {
        $value = 123;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger100(): void
    {
        $value = 100;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger200(): void
    {
        $value = 200;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testHex(): void
    {
        $value = 'abc123';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testDecimal(): void
    {
        $value = 123.45;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testStdClass(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = new \StdClass();

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = [];

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testAssocArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = ['foo'=>'bar'];

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testTrue(): void
    {
        $value = true;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testFalse(): void
    {
        $value = false;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testZero(): void
    {
        $value = 0;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOne(): void
    {
        $value = 1;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testNull(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = null;

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLetters(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefghijklmnopqrstuvwxyz';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUppercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'ABCDEFG';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLowercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefg';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUuid(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '50e03466-4810-11ee-be56-0242ac120002';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmail(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmails(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com,jenny@appleseed.com';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testBase64(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'dGVzdA==';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testIp(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '192.168.1.2';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUrl(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'http://www.example.com';

        $this->isScalar->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOneof(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'a';

        $this->isScalar->isValid($value,'a,b,c');

        // if we get here then it's valid
        $this->assertTrue(true);
    }


}
