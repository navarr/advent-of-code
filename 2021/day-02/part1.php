<?php

declare(strict_types=1);

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$depth = 0;
$length = 0;

foreach ($input as $command) {
    $tokens = explode(' ', $command);
    $action = $tokens[0];
    $amount = (int) $tokens[1];

    $adjustVariable = in_array($action, ['up', 'down']) ? 'depth' : 'length';
    $posNegMultiplier = $action === 'up' ? -1 : 1;

    ${$adjustVariable} += $amount * $posNegMultiplier;
}

echo $length * $depth;
