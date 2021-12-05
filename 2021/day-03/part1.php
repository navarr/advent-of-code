<?php

declare(strict_types=1);

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$amounts = [];

foreach($input as $line) {
    $length =strlen($line);
    for($i = 0;$i < $length;++$i) {
        $bit = $length[$i];
        if (!isset($amounts[$i][$bit])) {
            $amounts[$i][$bit] = 0;
        }
        $amounts[$i][$bit]++;
    }
}

$gammaRate = '';
$epsilonRate= '';

foreach($amounts as $place => $data) {
    $gammaBit = $data[0] > $data[1] ? 0 : 1;
    $epsilonBit = $data[0] > $data[1] ? 1 : 0;
    $gammaRate .= $gammaBit;
    $epsilonRate .= $epsilonBit;
}

echo "Gamma: ",$gammaRate,PHP_EOL;
echo "Epsilon: ",$epsilonRate,PHP_EOL;

echo "Answer: ",$gammaRate*$epsilonRate,PHP_EOL;