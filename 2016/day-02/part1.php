<?php

$digits = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = [
    -1 => [-1 => '1', 0 => '2', 1 => '3'],
    0  => [-1 => '4', 0 => '5', 1 => '6'],
    1  => [-1 => '7', 0 => '8', 1 => '9'],
];

$code = [];

function require_between($min, $max, &$num)
{
    if ($num > $max) {
        $num = $max;
    }
    if ($num < $min) {
        $num = $min;
    }
}

foreach ($digits as $digitInstruction) {
    $x = $y = 0;
    for ($i = 0, $l = strlen($digitInstruction); $i < $l; ++$i) {
        $instruction = $digitInstruction{$i};
        switch ($instruction) {
            case 'U':
                --$y;
                break;
            case 'D':
                ++$y;
                break;
            case 'L':
                --$x;
                break;
            case 'R':
                ++$x;
                break;
        }
        require_between(-1, 1, $x);
        require_between(-1, 1, $y);
    }
    $code[] = $map[$y][$x];
}

echo 'Code: ',implode('', $code),PHP_EOL;
