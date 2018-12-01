<?php

$frequencies = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$reachedFrequencies = [0];
$frequency = 0;

reset($frequencies);

while (true) {
    $frequencyShift = current($frequencies);
    $frequency += intval($frequencyShift, 10);
    if (in_array($frequency, $reachedFrequencies)) {
        echo "Reached Frequency {$frequency} twice", PHP_EOL;
        break;
    }
    $reachedFrequencies[] = $frequency;

    $result = next($frequencies);
    if ($result === false) {
        reset($frequencies);
    }
}
