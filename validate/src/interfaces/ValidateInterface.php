<?php

declare(strict_types=1);

namespace peel\validate\interfaces;

interface ValidateInterface
{
    public function reset(): self;

    public function addRule(string $name, string $class): self;
    public function addRules(array $rules): self;

    public function validateArray(array $input, array $ruleSet): self;
    public function validateObject(object $input, array $ruleSet): self;
    public function validateSet(mixed $input, array $ruleSet): self;
    public function validateValue(mixed $input, string $rules, ?string $human = null): self;

    public function filter(mixed $input, string $filters, ?string $human = null): mixed;

    public function addError(string $errorMsg, string $human, string $params, string $rule, string $value): self;

    public function stopProcessing(): self;
    public function throwErrorOnFailure(): self;
    public function changeDotNotationSeparator(string $dot): self;
    public function disableDotNotation(): self;

    public function hasError(): bool;
    public function hasErrors(): bool;
    public function error(): string;
    public function errors(): array;
    public function value(): mixed;
    public function values(): mixed;

    public function getDotNotation(mixed $input, string $dotNotation, string $dotSeparator = '.', $default = null): mixed;
    public function setDotNotation(mixed &$input, string $dotNotation, mixed $value, string $dotSeparator = '.');
}
