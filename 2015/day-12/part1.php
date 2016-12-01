<?php

/**
 * @param array|object $array_or_object
 *
 * @return int
 */
function sum_of_all_numbers($array_or_object)
{
    $sum = 0;
    if (is_array($array_or_object)) {
        foreach ($array_or_object as $value) {
            if (is_int($value)) {
                $sum += $value;
            }
            if (is_array($value) || is_object($value)) {
                $sum += sum_of_all_numbers($value);
            }
        }
    }
    if (is_object($array_or_object)) {
        $vars = get_object_vars($array_or_object);
        foreach ($vars as $key => $value) {
            if (is_int($key)) {
                $sum += $key;
            }
            if (is_int($value)) {
                $sum += $value;
            }
            if (is_array($value) || is_object($value)) {
                $sum += sum_of_all_numbers($value);
            }
        }
    }
    return $sum;
}

// tests

$asserts = [
    '[1,2,3]'              => 6,
    '{"a":2,"b":4}'        => 6,
    '[[[3]]]'              => 3,
    '{"a":{"b":4},"c":-1}' => 3,
    '{"a":[-1,1]}'         => 0,
    '[-1,{"a":1}]'         => 0,
    '[]'                   => 0,
    '{}'                   => 0,
];

foreach($asserts as $key => $value) {
    $result = sum_of_all_numbers(json_decode($key));
    if ($result !== $value) {
        die("Failed for {$key}.  Expected {$value}, Got {$result}");
    }
}

// Alright, let's do it!

echo sum_of_all_numbers(json_decode(file_get_contents('input.json')));
