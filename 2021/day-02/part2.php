<?php

declare(strict_types=1);

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$depth = 0;
$length = 0;
$aim = 0;

foreach ($input as $command) {
    $tokens = explode(' ', $command);
    $action = $tokens[0];
    $amount = (int) $tokens[1];

    switch($action) {
        case 'down':
            $aim += $amount;
            break;
        case 'up':
            $aim -= $amount;
            break;
        case 'forward':
            $length += $amount;
            $depth += $aim * $amount;
    }
}

echo $length * $depth;
