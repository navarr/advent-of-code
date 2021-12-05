<?php

declare(strict_types=1);

$input = file(__DIR__ . '/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

/**
 * @return bool True or False for whether or not the most common bit in the place is 1
 */
function calculatePlaceBit(array $input, int $place): bool
{
    $result = array_reduce(
        $input,
        static function (array $carry, string $number) use ($place): array {
            $bit = (int)$number[$place];
            $carry[$bit] = 0;
            return $carry;
        },
        [0 => 0, 1 => 0]
    );
    return $result[0] > $result[1] ? false : true;
}

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
$length = strlen($input[0]);

for($place = 0;$place < $length;++$place) {
    if (count($oxygenCandidates) === 1) {
        $oxygenRating = reset($oxygenCandidates);
        break;
    }
    $number = calculatePlaceBit($oxygenCandidates, $i) ? '1' : '0';
    $oxygenCandidates = array_filter(
        $oxygenCandidates,
        static function ($candidate) use ($place, $number) {
            return $candidate[$place] === $number;
        }
    );
}

if ($oxygenRating === '') {
    echo "Oxygen Rating not found.  Re-evaluate code.",PHP_EOL;
} else {
    echo "Oxygen Rating: ",bindec($oxygenRating),PHP_EOL;
}