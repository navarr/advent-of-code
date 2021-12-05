<?php

declare(strict_types=1);

$input = file(__DIR__ . '/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$amounts = [];

foreach($input as $line) {
    $length = strlen($line);
    for($i = 0;$i < $length;++$i) {
        $bit = $line[$i];
        if (!isset($amounts[$i][$bit])) {
            $amounts[$i][$bit] = 0;
        }
        $amounts[$i][$bit]++;
    }
}

$oxygenCandidates = $input;
$oxygenRating='';

foreach($amounts as $place => $data) {
    if (count($oxygenCandidates) === 1) {
        $oxygenRating = reset($oxygenCandidates);
        break;
    }
    $oxygenCandidates = array_filter(
        $oxygenCandidates,
        static function ($candidate) use ($place, $data) {
            $placeNumber = $candidate[$place];
            $bit = $data[0] > $data[1] ? '0' : '1';
            return $placeNumber === $bit;
        }
    );
}

if ($oxygenRating === '') {
    echo "Oxygen Rating not found.  Re-evaluate code.";
}