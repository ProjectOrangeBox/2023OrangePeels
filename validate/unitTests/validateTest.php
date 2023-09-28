<?php

declare(strict_types=1);

use peel\validate\Validate;

final class validateTest extends \unitTestHelper
{
    private $validate;

    protected function setUp(): void
    {
        $vConfig = require __DIR__ . '/../src/config/validate.php';

        $this->validate = new Validate($vConfig);
    }

    public function testValidateFilter(): void
    {
        $value = $this->validate->filter('123', 'ConvertDate|Length[6]');

        $this->assertEquals('1970-0', $value);
    }

    public function testValidateValue(): void
    {
        $value = $this->validate->validateValue('123', 'ConvertDate|Length[6]')->value();

        $this->assertEquals('1970-0', $value);
    }

    public function testValidateSet(): void
    {
        $values = [
            'name' => 'Jane Doe',
            'age' => 27,
            'food' => 'pizza'
        ];

        $rules = [
            'name' => 'length[4]|isString',
            'age' => 'greaterThan[18]|lessThan[100]|isInteger',
            'food' => 'isString|oneOf[pizza,burger,hot dog,ice cream]',
        ];

        $this->assertEquals([
            'name' => 'Jane',
            'age' => 27,
            'food' => 'pizza',
        ], $this->validate->validateSet($values, $rules)->value());
    }

    public function testValidateSetError(): void
    {
        $values = [
            'name' => 456,
            'age' => 2,
            'food' => 'cat'
        ];

        $rules = [
            'name' => 'length[4]|isString',
            'age' => 'greaterThan[18]|lessThan[100]|isInteger',
            'food' => 'isString|oneOf[pizza,burger,hot dog,ice cream]',
        ];

        $this->validate->validateSet($values, $rules)->value();

        $this->assertTrue($this->validate->hasError());
        $this->assertEquals($values, $this->validate->values());

        $this->assertEquals([
            'age is not greater than 18.',
            'food is not one of pizza, burger, hot dog, ice cream.',
        ], $this->validate->errors());
    }
}
