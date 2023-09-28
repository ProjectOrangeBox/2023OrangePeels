<?php

return [
    'rules' => include __DIR__ . '/rules.php',

    'dotSeparator' => '.',
    'throwErrorOnFailure' => false,

    'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
    'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],

    'errorMsg' => '%s is not valid.',

    'separator' => '|',
    'optionLeftDelimiter' => '[',
    'optionRightDelimiter' => ']',
];
