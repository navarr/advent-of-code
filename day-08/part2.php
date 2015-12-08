<?php

function byte_count($string)
{
    return strlen($string);
}

function new_byte_count($string)
{
    $string = str_replace('\\"', 'S', $string);
    $string = str_replace('\\', '\\\\', $string);
    $string = str_replace('"', '\\"', $string);
    $string = str_replace('S', '\\\\\\"', $string);
    $string = "\"{$string}\"";
    return strlen($string);
}

// Tests

$tests = [ // code, characters
    '""'          => [2, 6],
    '"abc"'       => [5, 9],
    '"aaa\\"aaa"' => [10, 16],
    '"\\x27"'     => [6, 11],
];

foreach ($tests as $string => $values) {
    $count = byte_count($string);
    if ($count != $values[0]) {
        throw new Exception("Assertion Failed, byte_count of '{$string}' was {$count}, expected {$values[0]}");
    }
    $count = new_byte_count($string);
    if ($count != $values[1]) {
        throw new Exception("Assertion Failed, new_byte_count of '{$string}' was {$count}, expected {$values[1]}");
    }
}

$input    = file('input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$newBytes = 0;
$oldBytes = 0;
foreach ($input as $string) {
    $oldBytes += byte_count($string);
    $newBytes += new_byte_count($string);
}

echo $newBytes - $oldBytes, PHP_EOL;
