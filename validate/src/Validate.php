<?php

declare(strict_types=1);

namespace peel\validate;

use stdClass;
use peel\validate\exceptions\RuleNotFound;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\ValidateInterface;

class Validate implements ValidateInterface
{
    protected array $config = [];
    protected array $errors = [];

    protected string $currentRule = '';
    protected string $currentParams = '';

    protected string $currentErrorMsg = '';
    protected mixed $currentValue = null;

    // flag for a rule to stop processing of further rules for a given field
    protected bool $stopProcessing = false;

    // defaults
    protected string $dotSeparator = '.';
    protected bool $throwErrorOnFailure = false;

    protected array $isBool = [];
    protected string $defaultErrorMsg = '%s is not valid.';

    protected string $ruleSeparator = '|';
    protected string $optionLeftDelimiter = '[';
    protected string $optionRightDelimiter = ']';

    protected array $rules = [];

    public function __construct(array $config)
    {
        $this->config = mergeDefaultConfig($config, __DIR__ . '/config/validate.php');

        $this->defaultErrorMsg = $this->config['defaultErrorMsg'] ?? $this->defaultErrorMsg;
        $this->dotSeparator = $this->config['dotSeparator'] ?? $this->dotSeparator;
        $this->ruleSeparator = $this->config['ruleSeparator'] ?? $this->ruleSeparator;

        $this->throwErrorOnFailure = $this->config['throwErrorOnFailure'] ?? $this->throwErrorOnFailure;
        $this->optionLeftDelimiter = $this->config['optionLeftDelimiter'] ?? $this->optionLeftDelimiter;
        $this->optionRightDelimiter = $this->config['optionRightDelimiter'] ?? $this->optionRightDelimiter;

        // these are considered valid boolean values
        $this->isBool = $this->config['isTrue'] + $this->config['isFalse'];

        $this->addRules($this->config['rules']);

        // reset class
        $this->reset();
    }

    public static function getInstance(array $config): self
    {
        // fresh copy each time there is NOTHING carried over between instances
        return new self($config);
    }

    public function reset(): self
    {
        $this->errors = [];

        $this->currentValue = null;
        $this->currentErrorMsg = '';
        $this->currentRule = '';
        $this->currentParams = '';

        $this->stopProcessing = false;

        return $this;
    }

    // rules and filters are the same
    public function addRule(string $name, string $class): self
    {
        $this->rules[strtolower($name)] = $class;

        return $this;
    }

    public function addRules(array $rules): self
    {
        foreach ($rules as $name => $class) {
            $this->addRule($name, $class);
        }

        return $this;
    }

    public function validateArray(array $input, array $ruleSet): self
    {
        return $this->validateArrayObject($input, $ruleSet, true);
    }

    public function validateObject(object $input, array $ruleSet): self
    {
        return $this->validateArrayObject($input, $ruleSet, true);
    }

    public function validateSet(mixed $input, array $ruleSet): self
    {
        return $this->validateArrayObject($input, $ruleSet, false);
    }

    protected function validateArrayObject(mixed $input, array $ruleSet, bool $processDot = false): self
    {
        $this->reset();

        $this->currentValue = $input;

        foreach ($ruleSet as $key => $rules) {
            if (is_array($rules)) {
                $human = $rules['human'];
                $rules = $rules['rules'];
            } else {
                $human = $this->makeHumanLookNice(null, $key);
            }

            if ($processDot) {
                $this->validateValueRules($this->getDotNotation($input, $key, $this->dotSeparator), $rules, $human);

                $this->setDotNotation($input, $key, $this->currentValue, $this->dotSeparator);
            } else {
                $this->validateValueRules($input[$key], $rules, $human);

                $input[$key] = $this->currentValue;
            }
        }

        $this->currentValue = $input;

        return $this->throwException();
    }

    public function validateValue(mixed $input, string $rules, ?string $human = null): self
    {
        $this->reset();

        $this->validateValueRules($input, $rules, $this->makeHumanLookNice($human, 'Input'));

        return $this->throwException();
    }

    // returns a value
    public function filter(mixed $input, string $filters, ?string $human = null): mixed
    {
        $this->reset();

        $this->validateValueRules($input, $filters, $this->makeHumanLookNice($human, 'Input'));

        // if it has an error clear the value completely
        if ($this->hasErrors()) {
            $this->currentValue = '';
        }

        $this->throwException();

        return $this->currentValue;
    }

    protected function throwException(): self
    {
        if ($this->throwErrorOnFailure && $this->hasErrors()) {
            throw new ValidationFailed($this->error(), $this->errors());
        }

        return $this;
    }

    protected function validateValueRules(mixed $input, string $rules, string $human = null): self
    {
        // continue processing rules
        $this->stopProcessing = false;

        foreach (explode($this->ruleSeparator, $rules) as $rule) {
            $this->validateValueRule($input, $rule, $human);

            // if they trigger the stop processing flag then break from the foreach loop
            if ($this->stopProcessing) {
                break;
            }
        }

        return $this;
    }

    protected function validateValueRule(mixed &$input, string $rule, ?string $human = ''): self
    {
        // save the current value
        $this->currentValue = &$input;

        try {
            // try to process the current value if it throws an exception current value isn't changed
            $this->callRule($input, $rule);
        } catch (ValidationFailed $e) {
            // if the rule or filter threw an error it is captured here
            $this->addError($e->getMessage(), $human, $this->currentParams, $this->currentRule, (string)$this->currentValue);

            // stop on first error
            $this->stopProcessing = true;
        }

        return $this;
    }

    /**
     * single value
     * single rule
     */
    protected function callRule(mixed &$value, string $rule): void
    {
        // default error
        $this->currentErrorMsg = $this->defaultErrorMsg;

        if (!empty($rule)) {
            $params = '';

            $regex = ';(?<rule>.*)' . preg_quote($this->optionLeftDelimiter) . '(?<param>.*)' . preg_quote($this->optionRightDelimiter) . ';';

            if (preg_match($regex, $rule, $matches, 0, 0)) {
                $rule = $matches['rule'];
                $params = $matches['param'];
            }

            $this->currentRule = $rule;
            $this->currentParams = $this->makeParamsLookNice($params);

            $rule = strtolower($rule);

            if (isset($this->rules[$rule])) {
                list($class, $method) = explode('>', $this->rules[$rule], 2);
            } else {
                throw new RuleNotFound('Unknown Rule or Filter "' . $rule . '".');
            }

            // make instance - this should autoload
            if (class_exists($class, true)) {
                $instance = new $class($value, $this->config, $this);
            } else {
                throw new RuleNotFound('Unknown Class "' . $class . '".');
            }

            // throws an error on fail
            if (method_exists($instance, $method)) {
                $instance->$method($params);
            } else {
                throw new RuleNotFound('Unknown Method "' . $method . '" on Class "' . $class . '".');
            }
        }
    }

    public function addError(string $errorMsg, string $human, string $params, string $rule, string $value): self
    {
        $this->errors[] = sprintf($errorMsg, $human, $rule, $params, $value);

        return $this;
    }

    public function value(): mixed
    {
        return $this->currentValue;
    }

    public function values(): mixed
    {
        return $this->value();
    }

    public function stopProcessing(): self
    {
        $this->stopProcessing = true;

        return $this;
    }

    public function throwErrorOnFailure(): self
    {
        $this->throwErrorOnFailure = true;

        return $this;
    }

    /**
     * Send in NULL if you want to turn "off" dot notation "drill down" into your input
     *
     * Send in something else if for some reason you would like to
     * use another separator to indicate how to drill down to the next level
     */
    public function changeDotNotationSeparator(string $dot): self
    {
        $this->dotSeparator = $dot;

        return $this;
    }

    public function disableDotNotation(): self
    {
        return $this->changeDotNotationSeparator('');
    }

    public function hasError(): bool
    {
        return (count($this->errors) > 0);
    }

    public function hasErrors(): bool
    {
        return $this->hasError();
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function error(): string
    {
        $error = '';

        if (isset($this->errors[0])) {
            $error = $this->errors[0];
        }

        return $error;
    }

    /* protected */

    protected function makeHumanLookNice(?string $human, string $key): string
    {

        // do we have a human readable field name? if not then try to make one
        $key = empty($key) ? 'Input' : $key;

        return $human ?? strtolower(str_replace('_', ' ', $key));
    }

    protected function makeParamsLookNice(string $param): string
    {
        // try to format the parameters into something human readable incase they need this in there error message
        if (strpos($param, ',') !== false) {
            $errorParams = str_replace(',', ', ', $param);

            if (($pos = strrpos($this->currentParams, ', ')) !== false) {
                $errorParams = substr_replace($this->currentParams, ' or ', $pos, 2);
            }
        } else {
            $errorParams = $param;
        }

        return $errorParams;
    }

    /**
     * drill into array or object
     */
    public function getDotNotation(mixed $input, string $dotNotation, string $dotSeparator = '.', $default = null): mixed
    {
        if (!empty($dotNotation) && !empty($dotSeparator)) {
            $keys = explode($dotSeparator, $dotNotation);

            foreach ($keys as $key) {
                if (is_array($input)) {
                    if (isset($input[$key])) {
                        $input = $input[$key];
                    } else {
                        return $default;
                    }
                } elseif (is_object($input)) {
                    if (isset($input->$key)) {
                        $input = $input->$key;
                    } else {
                        return $default;
                    }
                } else {
                    return $default;
                }
            }
        }

        return $input;
    }

    public function setDotNotation(mixed &$input, string $dotNotation, mixed $value, string $dotSeparator = '.')
    {
        if (!empty($dotNotation) && !empty($dotSeparator)) {
            $keys = explode($dotSeparator, $dotNotation);

            while (count($keys) > 1) {
                $key = array_shift($keys);

                // set if missing
                if (is_object($input)) {
                    if (!isset($input->$key)) {
                        $input->$key = new StdClass();
                    }

                    $input = &$input->$key;

                    $key = reset($keys);

                    $input->$key = $value;
                } else {
                    if (!isset($input[$key])) {
                        $input[$key] = [];
                    }

                    $input = &$input[$key];

                    $key = reset($keys);
                    $input[$key] = $value;
                }
            }
        }
    }
}
