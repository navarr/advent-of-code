<?php

declare(strict_types=1);

$lines = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$increases = 0;
$previous = null;
$three = [];

foreach ($lines as $line) {
    $amt = (int)trim($line);
    if (count($three) === 3) {
        array_shift($three);
    }
    $three[] = $amt;

    if (count($three) < 3) {
        continue;
    }

    $amt = array_sum($three);
    if ($previous !== null && $amt > $previous) {
        ++$increases;
    }
    $previous = $amt;
}

echo $increases;
