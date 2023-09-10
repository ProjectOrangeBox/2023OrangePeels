#!/usr/bin/env php
<?php

$filters = [];
$rules = [];

foreach (glob(__DIR__.'/../../src/rules/*.php') as $file) {
    $bn = basename($file,'.php');

    $rules[$bn] = '\peel\validate\rules\\'.$bn;
}

foreach (glob(__DIR__.'/../../src/filters/*.php') as $file) {
    $bn = basename($file,'.php');

    $filters[$bn] = '\peel\validate\filters\\'.$bn;
}

$n = chr(10);

echo $n.$n;

echo '['.$n.substr(var_export($rules,true),8,-1).$n.']';

echo $n.$n;

echo '['.$n.substr(var_export($filters,true),8,-1).$n.']';

echo $n.$n;
