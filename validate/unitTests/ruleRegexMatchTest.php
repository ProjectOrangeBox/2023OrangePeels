<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\exceptions\ValidationFailed;

final class ruleRegexMatchTest extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $regexMatch;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->regexMatch = new \peel\validate\rules\regexMatch($this->config,$this->validateParent);
    }

    public function testStringMatch(): void
    {
        $value = 'abc';

        $this->regexMatch->isValid($value,'/^([A-Za-z]*)$/');

        // if we get here then it's valid
        $this->assertTrue(true);
    }

    public function testStringNoMatch(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = '123';

        $this->regexMatch->isValid($value,'/^([A-Za-z]*)$/');

        // if we get here then it's valid
        $this->assertTrue(true);
    }
    
}
