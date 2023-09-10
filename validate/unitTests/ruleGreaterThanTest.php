<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\exceptions\ValidationFailed;

final class ruleGreaterThanTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $greaterThan;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->greaterThan = new \peel\validate\rules\greaterThan($this->config,$this->validateParent);
    }

    public function testEmpty(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testString(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abc';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 123;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger100(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 100;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testInteger200(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 200;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testHex(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abc123';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testDecimal(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 123.45;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testStdClass(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = new \StdClass();

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = [];

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testAssocArray(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = ['foo'=>'bar'];

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testTrue(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = true;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testFalse(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = false;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testZero(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 0;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOne(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 1;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testNull(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = null;

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLetters(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefghijklmnopqrstuvwxyz';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUppercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'ABCDEFG';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testLowercase(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'abcdefg';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUuid(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '50e03466-4810-11ee-be56-0242ac120002';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmail(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testEmails(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'johnny@appleseed.com,jenny@appleseed.com';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testBase64(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'dGVzdA==';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testIp(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '192.168.1.2';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testUrl(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'http://www.example.com';

        $this->greaterThan->isValid($value,'');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testOneof(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = 'a';

        $this->greaterThan->isValid($value,'a,b,c');

        // if we get here then it's valid
        $this->assertTrue(true);
    }


}
