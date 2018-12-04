<?php

$input = [
    '#123 @ 3,2: 5x4',
];

$map = [];
$inches = 0;

foreach ($input as $line) {
    preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/i', $line, $pieces);
    $id = $pieces[1];
    $x = $pieces[2];
    $y = $pieces[3];
    $w = $pieces[4];
    $h = $pieces[5];

    for ($i = $x; $i < $x + $w; ++$i) {
        for ($j = $y; $j < $y + $h; ++$j) {
            $map["{$i}x{$j}"] = ($map["{$i}x{$j}"] ?? 0) + 1;

            if ($map["{$i}x{$j}"] === 2) {
                $inches++;
            }
        }
    }
}

echo $inches, PHP_EOL;
