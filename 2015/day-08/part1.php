<?php

function length_of_string($string)
{
    // never ever do this.  NOT EVER
    $string = eval( 'return ' . $string . ';' );
    return strlen($string);
}

function byte_count($string)
{
    return strlen($string);
}

// Tests

$tests = [ // code, characters
    '""'          => [2, 0],
    '"abc"'       => [5, 3],
    '"aaa\\"aaa"' => [10, 7],
    '"\\x27"'     => [6, 1],
];

foreach ($tests as $string => $values) {
    $count = byte_count($string);
    if ($count != $values[0]) {
        throw new Exception("Assertion Failed, byte_count of '{$string}' was {$count}, expected {$values[0]}");
    }
    $count = length_of_string($string);
    if ($count != $values[1]) {
        throw new Exception("Assertion Failed, length_of_string of '{$string}' was {$count}, expected {$values[1]}");
    }
}

$input = file('input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$chars = 0;
$bytes = 0;
foreach ($input as $string) {
    $chars += length_of_string($string);
    $bytes += byte_count($string);
}

echo $bytes - $chars,PHP_EOL;
