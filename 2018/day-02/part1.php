<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$twoLetter = 0;
$threeLetter = 0;
foreach ($input as $line) {
    $twoLetterAdd = 0;
    $threeLetterAdd = 0;

    $letters = [];
    for ($i = 0, $l = strlen($line); $i < $l; ++$i) {
        $letters[$line[$i]] = ($letters[$line[$i]] ?? 0) + 1;
    }

    foreach ($letters as $letter => $amount) {
        if ($amount === 2) {
            $twoLetterAdd = 1;
        }
        if ($amount === 3) {
            $threeLetterAdd = 1;
        }
    }

    $twoLetter += $twoLetterAdd;
    $threeLetter += $threeLetterAdd;
}

echo $twoLetter * $threeLetter, PHP_EOL;
