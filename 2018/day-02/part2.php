<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Screw it, bruteforce

foreach ($input as $line1) {
    foreach ($input as $line2) {
        $changes = 0;
        for ($i = 0, $l = strlen($line2); $i < $l; ++$i) {
            if ($line1[$i] !== $line2[$i]) {
                ++$changes;
            }
            if ($changes >= 2) {
                continue;
            }
        }
        if ($changes === 1) {
            $answer = [$line1, $line2];
            break 2;
        }
    }
}

$result = '';

for ($i = 0, $l = strlen($answer[0]); $i < $l; ++$i) {
    if ($answer[0][$i] === $answer[1][$i]) {
        $result .= $answer[0][$i];
    }
}

echo $result, PHP_EOL;
