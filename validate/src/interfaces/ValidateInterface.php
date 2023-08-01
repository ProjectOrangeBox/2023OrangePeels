<?php

declare(strict_types=1);

namespace dmyers\validate\interfaces;

interface ValidateInterface
{
    public function reset(): self;
    public function attachRule(string $name, string $class): self;
    public function attachFilter(string $name, string $class): self;
    public function isValid($input, string $rules): bool;
    public function filter($input, string $rules): mixed;
    public function run(): self;
    public function runGroup(string $namedGroup): self;
    public function data(array &$fieldsData): self;
    public function rules(array $rules, string $namedGroup = 'default'): self;
    public function success(): bool;
    public function errors(): array;
    public function error(): string;
}
