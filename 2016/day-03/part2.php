<?php

$triangles = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$total = count($triangles);
$possible = 0;
$impossible = 0;
foreach ($triangles as $triangle) {
    // Get the triangle parts - but some funky formatting to align the doc :(
    $pieces = explode(' ', $triangle);

    // Filter out the funky parts from the file
    $pieces = array_filter(
        $pieces,
        function ($piece) {
            if (empty(trim($piece))) {
                return false;
            } else {
                return true;
            }
        }
    );

    $pieces = array_map(function($piece) { return intval($piece, 10); }, $pieces);

    // Sort Numerically
    sort($pieces, SORT_NUMERIC);

    // Re-key the array
    $pieces = array_values($pieces);

    switch(false) {
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
