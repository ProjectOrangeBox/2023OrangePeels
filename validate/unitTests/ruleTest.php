<?php

declare(strict_types=1);

use peel\validate\Validate;

final class ruleTest extends \unitTestHelper
{
    protected $instance;

    protected function setUp(): void
    {
        $config = [
            'dotSeparator' => '.',
            'throwErrorOnFailure' => false,

            'isBool' => [0, 1, '0', '1', true, false, 'true', 'false'],
            'errorMsg' => 'The rule "%s[%s]" failed on the field: "%s" value: "%s"',

            'separator' => '|',
            'optionRightDelimiter' => '[',
            'optionLeftDelimiter' => ']',

            'rules' => [
                'differs' => '\\peel\\validate\\rules\\Differs',
                'matches' => '\\peel\\validate\\rules\\Matches',
                'allowEmpty' => '\\peel\\validate\\rules\\allowEmpty',
                'alpha' => '\\peel\\validate\\rules\\alpha',
                'alphaDash' => '\\peel\\validate\\rules\\alphaDash',
                'alphaNumeric' => '\\peel\\validate\\rules\\alphaNumeric',
                'alphaNumericDash' => '\\peel\\validate\\rules\\alphaNumericDash',
                'alphaNumericSpace' => '\\peel\\validate\\rules\\alphaNumericSpace',
                'alphaSpace' => '\\peel\\validate\\rules\\alphaSpace',
                'exactLength' => '\\peel\\validate\\rules\\exactLength',
                'greaterThan' => '\\peel\\validate\\rules\\greaterThan',
                'greaterThanEqualTo' => '\\peel\\validate\\rules\\greaterThanEqualTo',
                'human' => '\\peel\\validate\\rules\\human',
                'isArray' => '\\peel\\validate\\rules\\isArray',
                'isBool' => '\\peel\\validate\\rules\\isBool',
                'isClass' => '\\peel\\validate\\rules\\isClass',
                'isDecimal' => '\\peel\\validate\\rules\\isDecimal',
                'isFloat' => '\\peel\\validate\\rules\\isFloat',
                'isHex' => '\\peel\\validate\\rules\\isHex',
                'isInteger' => '\\peel\\validate\\rules\\isInteger',
                'isLowercase' => '\\peel\\validate\\rules\\isLowercase',
                'isNatural' => '\\peel\\validate\\rules\\isNatural',
                'isNaturalNoZero' => '\\peel\\validate\\rules\\isNaturalNoZero',
                'isNumeric' => '\\peel\\validate\\rules\\isNumeric',
                'isScalar' => '\\peel\\validate\\rules\\isScalar',
                'isStdClass' => '\\peel\\validate\\rules\\isStdClass',
                'isString' => '\\peel\\validate\\rules\\isString',
                'isUppercase' => '\\peel\\validate\\rules\\isUppercase',
                'lessThan' => '\\peel\\validate\\rules\\lessThan',
                'lessThanEqualTo' => '\\peel\\validate\\rules\\lessThanEqualTo',
                'maxLength' => '\\peel\\validate\\rules\\maxLength',
                'minLength' => '\\peel\\validate\\rules\\minLength',
                'oneOf' => '\\peel\\validate\\rules\\oneOf',
                'regexMatch' => '\\peel\\validate\\rules\\regexMatch',
                'required' => '\\peel\\validate\\rules\\required',
                'validBase64' => '\\peel\\validate\\rules\\validBase64',
                'validDate' => '\\peel\\validate\\rules\\validDate',
                'validEmail' => '\\peel\\validate\\rules\\validEmail',
                'validEmails' => '\\peel\\validate\\rules\\validEmails',
                'validIP' => '\\peel\\validate\\rules\\validIP',
                'validJson' => '\\peel\\validate\\rules\\validJson',
                'validTimezone' => '\\peel\\validate\\rules\\validTimezone',
                'validURL' => '\\peel\\validate\\rules\\validURL',
                'validUuid' => '\\peel\\validate\\rules\\validUuid',
            ],
            'filters' => [
                'StrToLower' => '\\peel\\validate\\filters\\StrToLower'
            ]
        ];

        $this->instance = new Validate($config);
    }

    public function testIsHexTrue(): void
    {
        $this->assertTrue($this->instance->validateValue('xyz', 'isHex')->hasError());
    }

    public function testIsHexFalse(): void
    {
        $this->assertFalse($this->instance->validateValue('abc', 'isHex')->hasError());
    }

    public function testIsUppercaseTrue(): void
    {
        $this->assertFalse($this->instance->validateValue('XYZ', 'isUppercase')->hasError());
    }

    public function testIsUppercaseFalse(): void
    {
        $this->assertTrue($this->instance->validateValue('abc', 'isUppercase')->hasError());
    }

    public function test1(): void
    {
        $this->assertFalse($this->instance->validateValue('ABC', 'isUppercase|isHex')->hasError());
    }

    public function test2(): void
    {
        $i = $this->instance->validateValue('ABC', 'isUppercase|isHex');

        $this->assertFalse($i->hasError());
    }

    public function test3(): void
    {
        $i = $this->instance->validateValue('xyz', 'isUppercase|isHex');

        $this->assertTrue($i->hasError());
        $this->assertEquals('input may only contain uppercase letters.', $i->error());
    }

    public function test4(): void
    {
        $i = $this->instance->validateValue('ABC', 'isUppercase|isHex|strToLower');

        $this->assertFalse($i->hasError());
        $this->assertEquals('abc', $i->value());
    }

    public function test5(): void
    {
        $input = [
            'name' => 'ABCEF',
            'age' => 'AB',
        ];

        $rules = [
            'name' => 'isUppercase|isHex|strToLower',
            'age' => 'isHex',
        ];

        $i = $this->instance->validateSet($input, $rules);

        $this->assertFalse($i->hasError());
        $this->assertEquals([], $i->errors());
        $this->assertEquals(['name' => 'abcef', 'age' => 'AB'], $i->values());
    }

    public function test6(): void
    {
        $input = [
            'name' => 'Johnny',
            'age' => 'xy',
        ];

        $rules = [
            'name' => 'isUppercase|isHex|strToLower',
            'age' => 'isHex',
        ];

        $i = $this->instance->validateSet($input, $rules);

        $this->assertTrue($i->hasErrors());
        $this->assertEquals(['name may only contain uppercase letters.','age may only contain hex characters a-f0-9'], $i->errors());
        $this->assertEquals(['name' => 'Johnny', 'age' => 'xy'], $i->values());
    }
}
