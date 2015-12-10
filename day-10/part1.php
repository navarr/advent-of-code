<?php

require_once('inc/look_and_say.func.php');

$tests = [
    1      => 11,
    11     => 21,
    21     => 1211,
    1211   => 111221,
    111221 => 312211,
];

foreach ($tests as $input => $output) {
    $test = look_and_say($input);
    if ($test != $output) {
        throw new Exception("Assertion Failed:  {$input} should render {$output} but rendered {$test}");
    }
}

$result = trim(file_get_contents('input.txt'));
for($i = 0;$i < 40;++$i) {
    $result = look_and_say($result);
}

$len = strlen($result);

echo "Answer: {$len} - Result: {$result}\n";
