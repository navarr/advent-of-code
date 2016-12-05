<?php

$input = 'reyedfim';

$password = '';

$numericIndex = 0;
while (strlen($password) < 8) {
    $md5 = md5($input.$numericIndex);
    $substr = substr($md5, 0, 5);
    $search = str_repeat('0', 5);
    // $substr == $search ALWAYS EQUALS TRUE WTF, guessing b/c the md5 is returning 0e and the $search is 0 so PHP goes "oh, they're numbers!  Both 0!"
    if (strcmp($substr, $search) == 0) {
        $password .= substr($md5, 5, 1);
        echo implode(', ', [$input, $numericIndex, $substr, $search, $md5, $password]), PHP_EOL;
    }
    ++$numericIndex;
}

echo 'Password: ', $password, PHP_EOL;
