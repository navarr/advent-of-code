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

function calculate(array $input)
{
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

    $oxygenCandidates = $co2Candidates = $input;
    $oxygenRating = $co2Rating = '';
    $length = strlen($input[0]);

    echo "String Length is {$length}",PHP_EOL;

    for($place = 0;$place < $length;$place++) {
        if (count($oxygenCandidates) === 1) {
            $oxygenRating = bindec(reset($oxygenCandidates));
            break;
        }
        $number = calculatePlaceBit($oxygenCandidates, $place) ? '1' : '0';
        $oxygenCandidates = array_filter(
            $oxygenCandidates,
            static function ($candidate) use ($place, $number) {
                return $candidate[$place] === $number;
            }
        );
    }

    for($place = 0;$place < $length;++$place) {
        if (count($co2Candidates) === 1) {
            $co2Rating = bindec(reset($co2Candidates));
            break;
        }
        $number = calculatePlaceBit($co2Candidates, $place) ? '0' : '1';
        $co2Candidates = array_filter(
            $co2Candidates,
            static function ($candidate) use ($place, $number) {
                return $candidate[$place] === $number;
            }
        );
    }

    echo "Oxygen Rating: {$oxygenRating}",PHP_EOL;
    echo "CO2 Rating: {$co2Rating}",PHP_EOL;

    $answer = $oxygenRating * $co2Rating;
    echo "Answer: ",$answer,PHP_EOL;

    return $answer;
}

echo "---[ Test Data ]",PHP_EOL;
$answer = calculate([
    '00100',
    '11110',
    '10110',
    '10111',
    '10101',
    '01111',
    '00111',
    '11100',
    '10000',
    '11001',
    '00010',
    '01010',
]);

assert('$answer === 230', 'Code is incorrect');

echo "---[ Real Data ]",PHP_EOL;
calculate($input);