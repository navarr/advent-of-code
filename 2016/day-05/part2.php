<?php

$input = 'reyedfim';

$password = str_repeat('_', 8);

$numericIndex = 0;
$found = 0;
$numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
while ($found < 8) {
    $md5 = md5($input.$numericIndex);
    $substr = substr($md5, 0, 5);
    $search = str_repeat('0', 5);
    if (strcmp($substr, $search) == 0 && in_array(substr($md5, 5, 1), $numbers)) {
        $position = substr($md5, 5, 1);
        $position = intval($position, 10);
        $character = substr($md5, 6, 1);
        if ($position < 8 && $password{$position} == '_') {
            $password{$position} = $character;
            ++$found;
        }
        echo implode(', ', [$input, $numericIndex, $position, $character, $md5, $password]), PHP_EOL;
    }
    ++$numericIndex;
}

echo 'Password: ', $password, PHP_EOL;
