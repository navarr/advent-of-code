<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$repetitions = [];

foreach ($input as $line) {
    $characters = str_split($line);
    for ($i = 0, $l = count($characters); $i < $l; ++$i) {
        $character = $characters[$i];
        if (!isset($repetitions[$i]) || !isset($repetitions[$i][$character])) {
            $repetitions[$i][$character] = ['character' => $character, 'count' => 0];
        }
        ++$repetitions[$i][$character]['count'];
    }
}

$message = '';
foreach ($repetitions as $repetition) {
    usort($repetition, function ($a, $b) {
        return $b['count'] <=> $a['count'];
    });

    reset($repetition);
    $common = current($repetition)['character'];
    $message .= $common;
}

echo 'Message: ',$message,PHP_EOL;
