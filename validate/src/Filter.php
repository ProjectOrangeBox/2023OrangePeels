<?php

declare(strict_types=1);

namespace dmyers\validate;

use dmyers\validate\exceptions\InvalidValue;
use dmyers\validate\interfaces\FilterInterface;
use dmyers\validate\interfaces\ValidateInterface;

class Filter implements FilterInterface
{
    private static FilterInterface $instance;

    protected ValidateInterface $validate;
    protected array $input = [];

    private function __construct(ValidateInterface $validate, array $input)
    {
        $this->validate = $validate;
        $this->input = $input;
    }

    public static function getInstance(ValidateInterface $validate, array $input): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($validate, $input);
        }

        return self::$instance;
    }

    public function attach(string $name, string $class): self
    {
        $this->validate->attachFilter($name, $class);

        return $this;
    }

    public function post(string $name, string $filters, $default = null): mixed
    {
        return $this->pick('post', $name, $filters, $default);
    }

    public function get(string $name, string $filters, $default = null): mixed
    {
        return $this->pick('get', $name, $filters, $default);
    }

    public function request(string $name, string $filters, $default = null): mixed
    {
        return $this->pick('request', $name, $filters, $default);
    }

    public function server(string $name, string $filters, $default = null): mixed
    {
        return $this->pick('server', $name, $filters, $default);
    }

    /**
     * $filter->field($foobar,'isString');
     */
    public function field(mixed $value, string $filter): mixed
    {
        return $this->validate->filter($value, $filter);
    }

    public function copy(): array
    {
        return $this->input;
    }

    public function replace(array $input): self
    {
        foreach ($input as $type => $values) {
            $this->input[$type] = $values;
        }

        return $this;
    }

    public function remapInput(string $type, string $mapping): array
    {
        $this->input[$type] = $this->remap($this->input[$type], $mapping);

        return $this->input[$type];
    }

    /*
     * remap
     *
     * string mapping fname>first_name|last_name<lname|fullname=first_name|fullname>/dev/null|new<@concat($first_name," ",$last_name)|foo<@substr($phone,0,3)
     * string type [get|post|request|server]
     *
     * Rename field named "A" to field named "B" A>B
     * Rename from field named "B" to field named "A" A<B
     * Copy from field named "A" into field named "B" A=B
     * "Delete" (send it to dev null) field named "A" A>/dev/null or /dev/null<A
     *
     * Perform "calculation" (like excel)
     * functions called must be global or called statically
     *
     * A<@concat($fielda,' ',$fieldb)
     * B<@trim($fieldb)
     * @substr($fielda,0,4)>A
     *
     *
     */
    public function remap(array $input, string $mapping): array
    {
        $re = '/(?<section1>[^<=>]+)(?<operator>[<=>]{1,2})(?<section2>[^<=>]+)/';
        $matches = [];

        foreach (explode('|', $mapping) as $seg) {
            preg_match($re, $seg, $matches, 0, 0);

            if (count($matches) != 7) {
                throw new InvalidValue('Remap input error "' . $seg . '".');
            }

            $section1 = strtolower($matches['section1']);
            $section2 = strtolower($matches['section2']);

            $section1Value = $input[$section1] ?? '';
            $section2Value = $input[$section2] ?? '';

            // handle formulas
            if (substr($section1, 0, 1) == '@') {
                $section1Value = $this->formula(substr($section1, 1), $input);
            }

            if (substr($section2, 0, 1) == '@') {
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

            // anything sent to /dev/null is deleted
            unset($input['/dev/null']);
        }

        return $input;
    }

    /**
     * Protected
     */
    protected function pick(string $type, string $name, string $filters, $default = null)
    {
        $value = $this->inputPick($type, $name, $default);

        foreach (\explode('|', $filters) as $filter) {
            $value = $this->field($value, $filter);
        }

        return $value;
    }

    /**
     * copy of input pick
     */
    protected function inputPick(string $type, ?string $name = null, $default = null)
    {
        if ($name === null) {
            $value = $this->input[$type];
        } elseif (isset($this->input[$type][strtolower($name)])) {
            $value = $this->input[$type][strtolower($name)];
        } else {
            $value = $default;
        }

        return $value;
    }

    protected function formula($logic, $arguments)
    {
        // create a closure in it's own jailed box
        $closure = eval('return function($arguments){extract($arguments);return(' . $logic . ');};');

        // call the closure
        return $closure($arguments);
    }
}
