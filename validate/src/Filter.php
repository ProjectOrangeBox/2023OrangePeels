<?php

declare(strict_types=1);

namespace peel\validate;

use dmyers\orange\interfaces\InputInterface;
use peel\validate\exceptions\InvalidValue;
use peel\validate\interfaces\FilterInterface;
use peel\validate\interfaces\ValidateInterface;

class Filter implements FilterInterface
{
    private static FilterInterface $instance;

    protected ValidateInterface $validate;
    protected InputInterface $input;

    protected array $validInputMethods = ['post', 'get', 'request', 'server', 'file', 'cookie'];
    protected string $filterSeparator = '|';

    public function __construct(ValidateInterface $validate, InputInterface $input)
    {
        $this->validate = $validate;
        $this->input = $input;
    }

    public static function getInstance(ValidateInterface $validate, InputInterface $input): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($validate, $input);
        }

        return self::$instance;
    }

    public function post(string $name = null, string $filters = '', $default = null): mixed
    {
        return $this->pickFiltered('post', $name, $filters, $default);
    }

    public function get(string $name = null, string $filters = '', $default = null): mixed
    {
        return $this->pickFiltered('get', $name, $filters, $default);
    }

    public function request(string $name = null, string $filters = '', $default = null): mixed
    {
        return $this->pickFiltered('request', $name, $filters, $default);
    }

    public function server(string $name = null, string $filters = '', $default = null): mixed
    {
        return $this->pickFiltered('server', $name, $filters, $default);
    }

    public function file(string $name = null, string $filters = '', $default = null): mixed
    {
        return $this->pickFiltered('file', $name, $filters, $default);
    }

    public function cookie(string $name = null, string $filters = '', $default = null): mixed
    {
        return $this->pickFiltered('cookie', $name, $filters, $default);
    }

    /**
     * add an rule
     */
    public function attach(string $name, string $class): self
    {
        $this->validate->attachFilter($name, $class);

        return $this;
    }

    /**
     * $filter->field($foobar,'isString');
     */
    public function field(mixed $value, string $filter): mixed
    {
        return $this->validate->filter($value, $filter);
    }

    /**
     * remap input array keys
     */
    public function remapInput(string $method, string $mapping): array
    {
        $input = $this->pickFromInput($method, null, null);

        if (!empty($mapping)) {
            $input = $this->remap($input, $mapping);

            $this->replaceInInput($method, $input);
        }

        // also send back remapped
        return $input;
    }

    /**
     * remap
     *
     * mapping fname>first_name|last_name<lname|fullname=first_name|fullname>#|new<=concat($first_name," ",$last_name)|foo<=substr($phone,0,3)
     *
     * Rename array key "A" to array key "B" : A>B
     * Rename array key "B" to array key "A" : A<B
     * Copy from array key "A" into array key "B" : A=B
     * Delete array key "A" : A>#
     *
     * Perform "calculation" (like excel)
     * functions called must be global or called statically
     *
     * A<=concat($fielda,' ',$fieldb)
     * B<=trim($fieldb)
     * =substr($fielda,0,4)>A
     *
     * the variables are the "extracted" keys from the $input
     *
     * so if your input is $input = ['foo'=>1,'bar'=>2];
     * then in your formula $foo and $bar are available
     *
     *
     */
    public function remap(array $input, string $mapping): array
    {
        $re = ';(?<section1>^[=]?[^<=>]+)(?<operator>[<=>]{1})(?<section2>.+);';
        $matches = [];

        foreach (explode('|', $mapping) as $seg) {
            preg_match($re, $seg, $matches, 0, 0);

            if (count($matches) != 7) {
                throw new InvalidValue('Remap input error "' . $seg . '".');
            }

            $section1 = $matches['section1'];
            $section2 = $matches['section2'];

            $section1Value = $input[$section1] ?? '';
            $section2Value = $input[$section2] ?? '';

            // handle formulas
            if (substr($section1, 0, 1) == '=') {
                $section1Value = $this->formula(substr($section1, 1), $input);
            }

            if (substr($section2, 0, 1) == '=') {
                $section2Value = $this->formula(substr($section2, 1), $input);
            }

            // handle operators
            switch ($matches['operator']) {
                    // move seg 1 to seg 2
                case '>':
                    $input[$section2] = $section1Value;

                    unset($input[$section1]);
                    break;
                    // move seg 2 to seg 1
                case '<':
                    $input[$section1] = $section2Value;

                    unset($input[$section2]);
                    break;
                    // copy seg 1 to seg 2
                case '=':
                    $input[$section1] = $section2Value;
                    break;
                default:
                    throw new InvalidValue('Unknown remap operator "' . $matches['operator'] . '" in "' . $seg . '".');
            }

            // anything sent to # is deleted
            unset($input['#']);
        }

        return $input;
    }

    /**
     * Protected
     */

    /**
     * eval inside a closure (ie. jailed)
     *
     * but still only use developer formulas
     */
    protected function formula($logic, $arguments): mixed
    {
        // create a closure in it's own jailed box
        $closure = eval('return function($arguments){extract($arguments);return(' . $logic . ');};');

        // call the closure
        return $closure($arguments);
    }

    /**
     * get from input with filter
     */
    protected function pickFiltered(string $method, ?string $name, ?string $filters = '', $default = null): mixed
    {
        $value = $this->pickFromInput($method, $name, $default);

        if (!empty($filters)) {
            foreach (\explode($this->filterSeparator, $filters) as $filter) {
                $value = $this->field($value, $filter);
            }
        }

        return $value;
    }

    /**
     * get from input
     */
    protected function pickFromInput(string $method, ?string $name, $default = null): mixed
    {
        $method = strtolower($method);

        if (!in_array($method, $this->validInputMethods)) {
            throw new InvalidValue($method);
        }

        return $this->input->$method($name, $default);
    }

    /**
     * replace content in input
     */
    protected function replaceInInput(string $method, $name, $value = null): void
    {
        $method = strtolower($method);

        if (is_array($name)) {
            $inputArray = $name;
        } else {
            $inputArray = $this->pickFromInput($method, null, null);

            $inputArray[$name] = $value;
        }

        $this->input->replace([$method => $inputArray]);
    }
}
