<?php

declare(strict_types=1);

namespace dmyers\validate;

use dmyers\validate\exceptions\InvalidValue;
use Exception;
use dmyers\validate\interfaces\ValidateInterface;

class Validate implements ValidateInterface
{
    private static ValidateInterface $instance;

    protected array $config = [];

    protected string $errorString = '';
    protected string $errorHuman = '';
    protected string $errorParams = '';
    protected string $errorFieldValue = '';

    protected array $fieldsData = [];
    protected array $errors = [];
    protected array $groupedRules = [];
    protected array $rules = [];
    protected array $filters = [];

    private function __construct(array $config)
    {
        $this->config = mergeDefaultConfig($config, __DIR__ . '/config/validate.php');

        /* normalize */
        $this->rules = \array_change_key_case($this->config['rules'], \CASE_LOWER);
        $this->filters = \array_change_key_case($this->config['filters'], \CASE_LOWER);

        /* reset class */
        $this->reset();
    }

    public static function getInstance(array $config): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function reset(): self
    {
        $this->errors = [];
        $this->fieldsData = [];
        $this->groupedRules = [];
        $this->errorString = '';
        $this->errorHuman = '';
        $this->errorParams = '';
        $this->errorFieldValue = '';

        return $this;
    }

    public function attachRule(string $name, string $class): self
    {
        $this->rules[strtolower($name)] = $class;

        return $this;
    }

    public function attachFilter(string $name, string $class): self
    {
        $this->filters[strtolower($name)] = $class;

        return $this;
    }

    /* one up test */
    public function isValid($input, string $rules): bool
    {
        $this->reset();

        $data = is_array($input) ? $input : ['input' => $input];
        $rules = is_array($rules) ? $rules : ['input' => $rules];

        return $this->data($data)->rules($rules)->run()->success();
    }

    /* one up filter */
    public function filter($input, string $rules): mixed
    {
        $this->reset();

        $data = is_array($input) ? $input : ['input' => $input];
        $rules = is_array($rules) ? $rules : ['input' => $rules];

        $this->data($data)->rules($rules)->run();

        return $data['input'];
    }

    /**
     * rule set
     *
     * $validate->fields('formgroup');
     *
     */
    public function run(): self
    {
        return $this->runGroup('default');
    }

    public function runGroup(string $namedGroup): self
    {
        if (!isset($this->groupedRules[$namedGroup])) {
            throw new InvalidValue('Validate rule group "' . $namedGroup . '" was not found.');
        }

        /* process each field and rule as a single rule, field, and human label */
        foreach ($this->groupedRules[$namedGroup] as $rule) {
            $this->single($rule['field'], $rule['rules'], $rule['human']);
        }

        return $this;
    }

    public function data(array &$fieldsData): self
    {
        $this->fieldsData = &$fieldsData;

        return $this;
    }

    public function rules(array $rules, string $namedGroup = 'default'): self
    {
        foreach ($rules as $key => $value) {
            if (is_array($value)) {
                $rulesToUse = $value['rules'];
                $fieldToUse = $value['field'];
                $humanToUse = (isset($value['human'])) ? $value['human'] : $fieldToUse;
            } else {
                $rulesToUse = $value;
                $fieldToUse = $key;
                $humanToUse = $key;
            }

            $this->groupedRules[$namedGroup][$fieldToUse] = ['rules' => $rulesToUse, 'field' => $fieldToUse, 'human' => $humanToUse];
        }

        return $this;
    }

    public function success(): bool
    {
        return count($this->errors) == 0;
    }

    /**
     * used by orange collectErrors
     */
    public function errors(): array
    {
        return array_values($this->errors);
    }

    public function error(): string
    {
        $errors = array_values($this->errors);

        return (isset($errors[0])) ? $errors[0] : '';
    }

    /**
     * Protected
     */

    protected function single(string $key, string $rules, string $human = null): self
    {
        $rules = explode('|', $rules);

        /* do we have any rules? */
        if (count($rules)) {
            /* field value before any validations / filters */
            if (!isset($this->fieldsData[$key])) {
                $this->fieldsData[$key] = null;
            }

            $this->errorFieldValue =  (string)$this->fieldsData[$key];

            foreach ($rules as $rule) {
                if ($this->processRule($key, strtolower($rule), $human) === false) {
                    break; /* break from for each */
                }
            }
        }

        return $this;
    }

    protected function processRule(string $key, string $rule, string $human): bool
    {
        /* no rule? exit processing of the $rules array */
        if (empty($rule)) {
            return false;
        }

        /* do we have this special rule? */
        if ($rule == 'allow_empty' && empty($this->fieldsData[$key])) {
            return false;
        }

        $param = '';

        if (preg_match(';(?<rule>.*)\[(?<param>.*)\];', $rule, $matches, 0, 0)) {
            $rule = $matches['rule'];
            $param = $matches['param'];
        }

        $this->errorHuman = $this->makeHumanLookNice($human, $rule);
        $this->errorParams = $this->makeParamsLookNice($param);

        return $this->processSingle($key, $rule, $param);
    }

    protected function makeHumanLookNice(string $human, string $rule): string
    {
        /* do we have a human readable field name? if not then try to make one */
        return ($human) ? $human : strtolower(str_replace('_', ' ', $rule));
    }

    protected function makeParamsLookNice(string $param): string
    {
        /* try to format the parameters into something human readable incase they need this in there error message  */
        if (strpos($param, ',') !== false) {
            $errorParams = str_replace(',', ', ', $param);

            if (($pos = strrpos($this->errorParams, ', ')) !== false) {
                $errorParams = substr_replace($this->errorParams, ' or ', $pos, 2);
            }
        } else {
            $errorParams = $param;
        }

        return $errorParams;
    }

    protected function processSingle(string $fieldsKey, string $rule, string $param = null): bool
    {
        $success = false;
        $rule = strtolower($rule);
        $class = '';
        $type = null;
        /* default error */
        $errorString = '%s is not valid.';

        if (isset($this->filters[$rule])) {
            $class = $this->filters[$rule];
            $type = 'filter';
        } elseif (isset($this->rules[$rule])) {
            $class = $this->rules[$rule];
            $type = 'rule';
        } else {
            throw new \Exception('Unknown Rule or Filter "' . $rule . '".');
        }

        /* make instance */
        $instance = new $class();

        switch ($type) {
            case 'rule':
                $success = $instance->fields($this->fieldsData)->errorString($errorString)->isValid($this->fieldsData[$fieldsKey], $param);

                if ($success === false) {
                    /**
                     * sprintf argument 1 human name for field
                     * sprintf argument 2 human version of options (computer generated)
                     * sprintf argument 3 field value
                     */
                    $this->errors[$this->errorHuman] = sprintf($errorString, $this->errorHuman, $this->errorParams, $this->errorFieldValue);
                }
                break;
            case 'filter':
                $this->fieldsData[$fieldsKey] = $instance->filter($this->fieldsData[$fieldsKey], $param);

                /* filters never fail */
                $success = true;
                break;
            default:
                throw new Exception('Unknown Type "' . $instance->type() . '".');
        }

        return $success;
    }
}
