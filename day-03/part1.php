<?php

$instructions = trim(file_get_contents('input.txt'));

$map = [];

$x = 0;
$y = 0;
$map['0x0'] = true;

for ($i = 0, $l = strlen($instructions); $i < $l; ++$i) {
    $instruction = $instructions[$i];
    switch($instruction) {
        case '^':
            ++$x;
            break;
        case 'v';
            --$x;
            break;
        case '>';
            ++$y;
            break;
        case '<';
            --$y;
            break;
    }

    $map["{$x}x{$y}"] = true;
}

echo count($map);
