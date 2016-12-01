<?php

$instructions = trim(file_get_contents('input.txt'));

$map = [];

$x = [0,0];
$y = [0,0];
$turn = 0;
$map['0x0'] = true;

for ($i = 0, $l = strlen($instructions); $i < $l; ++$i,++$turn) {
    $instruction = $instructions[$i];

    $santa = $turn % 2;

    switch($instruction) {
        case '^':
            ++$x[$santa];
            break;
        case 'v';
            --$x[$santa];
            break;
        case '>';
            ++$y[$santa];
            break;
        case '<';
            --$y[$santa];
            break;
    }

    $map["{$x[$santa]}x{$y[$santa]}"] = true;
}

echo count($map);
