#!/usr/bin/env php
<?php

$filters = [];
$rules = [];

foreach (glob(__DIR__ . '/../../src/rules/*.php') as $file) {
    $bn = basename($file, '.php');

    $rules[$bn] = '\peel\validate\rules\\' . $bn;
}

foreach (glob(__DIR__ . '/../../src/filters/*.php') as $file) {
    $bn = basename($file, '.php');

    $filters[$bn] = '\peel\validate\filters\\' . $bn;
}

$testValues = [
    'empty' => '',
    'string' => 'abc',
    'integer' => '123',
    'integer100' => '100',
    'integer200' => '200',
    'hex' => 'abc123',
    'decimal' => '123.45',
    'stdClass' => ['new \StdClass()', 'raw1' => true],
    'array' => ['[]', 'raw1' => true],
    'assocArray' => ["['foo'=>'bar']", 'raw1' => true],
    'true' => ['true', 'raw1' => true],
    'false' => ['false', 'raw1' => true],
    'zero' => 0,
    'one' => 1,
    'null' => ['null', 'raw1' => true],
    'letters' => 'abcdefghijklmnopqrstuvwxyz',
    'uppercase' => 'ABCDEFG',
    'lowercase' => 'abcdefg',
    'uuid' => '50e03466-4810-11ee-be56-0242ac120002',
    'email' => 'johnny@appleseed.com',
    'emails' => 'johnny@appleseed.com,jenny@appleseed.com',
    'base64' => 'dGVzdA==',
    'ip' => '192.168.1.2',
    'url' => 'http://www.example.com',
    'oneof' => ['a', 'a,b,c'],
];

$n = chr(10);
$data = [];

$singleTemplate = file_get_contents(__DIR__ . '/support/rule.single.tmpl.php');
$fileTemplate = file_get_contents(__DIR__ . '/support/rule.body.tmpl.php');

foreach ($rules as $basename => $namespace) {
    $body = '';

    foreach ($testValues as $key => $value) {
        $value1 = $value;
        $value2 = "''";

        if (!is_array($value)) {
            $value1 = escape($value);
        } else {
            if (isset($value['raw1'])) {
                $value1 = $value[0];
            } else {
                $value1 = escape($value[0]);
            }

            if (isset($value['raw2'])) {
                $value2 = $value[1];
            } elseif (isset($value[1])) {
                $value2 = escape($value[1]);
            }
        }

        $data['basename'] = ucfirst($basename);
        $data['lbasename'] = $basename;
        $data['namespace'] = $namespace;
        $data['value1'] = $value1;
        $data['value2'] = $value2;
        $data['key'] = ucfirst($key);

        $body .= merge($data, $singleTemplate);
    }

    $data['body'] = $body;

    $outputFilename = 'rule' . ucfirst($basename) . 'Test.php';

    file_put_contents(__DIR__ . '/output/' . $outputFilename, merge($data, $fileTemplate));

    echo $outputFilename . $n;
}

function merge(array $data, string $template): string
{
    foreach ($data as $key => $value) {
        $template = str_replace('%%' . strtoupper($key) . '%%', $value, $template);
    }

    return $template;
}

function escape($value): string
{
    if (!is_numeric($value)) {
        $value = "'" . $value . "'";
    }

    return $value;
}
