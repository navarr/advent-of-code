<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Convert lines and columns to a reasonable structure
foreach ($lines as $index => $line) {
    $columns = explode(' ', $line);
    $columns = array_filter(
        $columns,
        function ($column) {
            if (empty(trim($column))) {
                return false;
            }
            return true;
        }
    );
    $columns = array_map(
        function ($column) {
            return intval($column, 10);
        },
        $columns
    );
    $lines[$index] = array_values($columns);
}

$triangles = [];
for ($i = 0, $l = count($lines) / 3; $i < $l; ++$i) {
    $start = 3*$i;
    for ($j = 0; $j < 3; ++$j) {
        $triangles[] = [$lines[$start][$j], $lines[$start+1][$j], $lines[$start+2][$j]];
    }
}

$total = count($triangles);
$possible = 0;
$impossible = 0;

foreach ($triangles as $pieces) {

    switch (false) {
        default:
            ++$possible;
            break;
        case ($pieces[0] + $pieces[1] > $pieces[2]):
        case ($pieces[0] + $pieces[2] > $pieces[1]):
        case ($pieces[1] + $pieces[2] > $pieces[0]):
            ++$impossible;
            break;
    }
}

echo "Out of {$total} triangles, only {$possible} are possible";
