<?php

declare(strict_types=1);

namespace dmyers\validate\interfaces;

interface FilterInterface
{
    public function attach(string $name, string $class): self;
    public function post(string $name, string $filters, $default = null): mixed;
    public function get(string $name, string $filters, $default = null): mixed;
    public function request(string $name, string $filters, $default = null): mixed;
    public function server(string $name, string $filters, $default = null): mixed;
    public function field(mixed $value, string $filter): mixed;
    public function remapInput(string $type, string $mapping): array;
    public function remap(array $input, string $mapping): array;
    public function copy(): array;
    public function replace(array $input): self;
}
