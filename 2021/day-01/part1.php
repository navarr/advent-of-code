<?php

declare(strict_types=1);

$lines = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$increases = 0;
$previous = null;
foreach ($lines as $line) {
    $amt = (int)trim($line);
    if ($previous !== null) {
        if ($amt > $previous) {
            ++$increases;
        }
    }
    $previous = $amt;
}

echo $increases;
