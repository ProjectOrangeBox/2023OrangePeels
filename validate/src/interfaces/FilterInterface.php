<?php

declare(strict_types=1);

namespace peel\validate\interfaces;

interface FilterInterface
{
    public function post(string $name = null, string $filters = '', $default = null): mixed;
    public function get(string $name = null, string $filters = '', $default = null): mixed;
    public function request(string $name = null, string $filters = '', $default = null): mixed;
    public function server(string $name = null, string $filters = '', $default = null): mixed;
    public function file(string $name = null, string $filters = '', $default = null): mixed;
    public function cookie(string $name = null, string $filters = '', $default = null): mixed;
    
    public function attach(string $name, string $class): self;
    
    public function field(mixed $value, string $filter): mixed;
    
    public function remapInput(string $method, string $mapping): array;
    public function remap(array $input, string $mapping): array;

}
