<?php

$frequencies = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$frequency = array_reduce(
    $frequencies,
    function ($frequency, $frequencyShift) {
        return $frequency + intval($frequencyShift, 10);
    },
    0
);

echo 'Resulting Frequency: ', $frequency, PHP_EOL;
