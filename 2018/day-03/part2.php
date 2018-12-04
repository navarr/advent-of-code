<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$map = [];
$possibilities = [];
foreach ($input as $line) {
    preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/i', $line, $pieces);
    $id = $pieces[1];
    $x = $pieces[2];
    $y = $pieces[3];
    $w = $pieces[4];
    $h = $pieces[5];
    $possibilities[$id] = true;

    for ($i = $x; $i < $x + $w; ++$i) {
        for ($j = $y; $j < $y + $h; ++$j) {
            $map["{$i}x{$j}"] = $map["{$i}x{$j}"] ?? [];
            $map["{$i}x{$j}"][] = $id;
        }
    }
}

foreach ($map as $location => $ids) {
    if (count($ids) > 1) {
        foreach ($ids as $id) {
            $possibilities[$id] = false;
        }
    }
}

foreach ($possibilities as $id => $val) {
    if ($val) {
        echo "Possibility: {$id}", PHP_EOL;
    }
}
