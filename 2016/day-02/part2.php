<?php

$digits = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = [
    -2 => [2 => '1'],
    -1 => [1 => '2', 2 => '3', 3 => '4'],
    0  => [0 => '5', 1 => '6', 2 => '7', 3 => '8', 4 => '9'],
    1  => [1 => 'A', 2 => 'B', 3 => 'C'],
    2  => [2 => 'D'],
];

$code = [];

foreach ($digits as $digitInstruction) {
    $x = $y = 0;
    for ($i = 0, $l = strlen($digitInstruction); $i < $l; ++$i) {
        $oldX = $x;
        $oldY = $y;
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
        if (!isset($map[$y]) || !isset($map[$y][$x])) {
            $x = $oldX;
            $y = $oldY;
        }
    }
    $code[] = $map[$y][$x];
}

echo 'Code: ', implode('', $code), PHP_EOL;
