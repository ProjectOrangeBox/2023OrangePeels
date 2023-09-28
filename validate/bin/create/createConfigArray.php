#!/usr/bin/env php
<?php

$filters = [];
$rules = [];

foreach (glob(__DIR__.'/../../src/rules/*.php') as $file) {
    $bn = basename($file,'.php');

    $rules[$bn] = '\peel\validate\rules\\'.$bn.'::class.\'>isValid\',';
}

foreach (glob(__DIR__.'/../../src/filters/*.php') as $file) {
    $bn = basename($file,'.php');

    $filters[$bn] = '\peel\validate\filters\\'.$bn.'::class.\'>filter\',';
}

$n = chr(10);

echo $n.$n;

echo '<?php'.$n.$n;

echo 'return ['.$n;

foreach ($rules as $name => $rule) {
    echo chr(9)."'".strtolower($name).'\' => '.$rule.$n;
}

echo '];'.$n;

echo $n.$n;

echo '<?php'.$n.$n;

echo 'return ['.$n;

foreach ($filters as $name => $filter) {
    echo chr(9)."'".strtolower($name).'\' => '.$filter.$n;
}

echo '];';

echo $n.$n;
