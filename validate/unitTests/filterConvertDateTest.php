<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\filters\ConvertDate;
use peel\validate\exceptions\ValidationFailed;

final class filterConvertDateTest extends \unitTestHelper
{
    private $validate;

    protected function setUp(): void
    {
        $vConfig = require __DIR__.'/../src/config/validate.php';
        
        $this->validate = new Validate($vConfig);
    }

    public function testEmpty(): void
    {

        $value = '';
        
        $this->expectException(ValidationFailed::class);

        (new ConvertDate($value, [], $this->validate))->filter();
    }

    public function testMySQL(): void
    {
        $value = 'Jan 21st 1901';
        
        (new ConvertDate($value, [], $this->validate))->filter('Y-m-d H:i:s');

        $this->assertEquals('1901-01-21 00:00:00',$value);
    }

    public function testMySQL2(): void
    {
        $value = 'Jan 21st 1901 4:45pm';
        
        (new ConvertDate($value, [], $this->validate))->filter('Y-m-d H:i:s');

        $this->assertEquals('1901-01-21 16:45:00',$value);
    }

    public function testInvalid(): void
    {
        $value = [];
        
        $this->expectException(ValidationFailed::class);

        (new ConvertDate($value, [], $this->validate))->filter('Y-m-d H:i:s');
    }
}
