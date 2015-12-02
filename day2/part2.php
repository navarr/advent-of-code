<?php

$baseInput = file_get_contents('input.txt');
//$baseInput = "2x3x4\n1x1x10";

$inputs = explode("\n", $baseInput);

$runningTotal = 0;

foreach ($inputs as $inputString) {
    if (empty($inputString)) continue;

    // 0 => l, 1 => w, 2 => h
    $input = explode('x', $inputString);
    $l     = $input[0];
    $w     = $input[1];
    $h     = $input[2];

    $input = array_map('intval', $input);
    sort($input);

    $amount = 2 * $input[0] + 2 * $input[1] + ( $input[0] * $input[1] * $input[2] );

    $runningTotal += $amount;
}

echo $runningTotal;
