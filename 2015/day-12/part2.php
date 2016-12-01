<?php

/**
 * @param array|object $array_or_object
 *
 * @return int
 */
function sum_of_all_not_red_numbers($array_or_object)
{
    $sum = 0;
    if (is_array($array_or_object)) {
        foreach ($array_or_object as $value) {
            if (is_int($value)) {
                $sum += $value;
            }
            if (is_array($value) || is_object($value)) {
                $sum += sum_of_all_not_red_numbers($value);
            }
        }
    }
    if (is_object($array_or_object)) {
        $vars = get_object_vars($array_or_object);
        $objsum = 0;
        foreach ($vars as $key => $value) {
            if ($value === "red") {
                return 0;
            }
            if (is_int($key)) {
                $objsum += $key;
            }
            if (is_int($value)) {
                $objsum += $value;
            }
            if (is_array($value) || is_object($value)) {
                $objsum += sum_of_all_not_red_numbers($value);
            }
        }
        $sum += $objsum;
    }
    return $sum;
}

// tests

$asserts = [
    '[1,2,3]'                         => 6,
    '[1,{"c":"red","b":2},3]'         => 4,
    '{"d":"red","e":[1,2,3,4],"f":5}' => 0,
    '[1,"red",5]'                     => 6,
];

foreach ($asserts as $key => $value) {
    $result = sum_of_all_not_red_numbers(json_decode($key));
    if ($result !== $value) {
        die("Failed for {$key}.  Expected {$value}, Got {$result}");
    }
}

// Alright, let's do it!

echo sum_of_all_not_red_numbers(json_decode(file_get_contents('input.json')));
