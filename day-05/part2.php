<?php

define('DEBUG', false);

function is_nice($string)
{
    if (DEBUG) {
        echo "Testing: '{$string}'", PHP_EOL;
    }
    $matchCountMap     = [
        '/([a-z]{2}).*\1/' => 1,
        '/([a-z])[a-z]{1}\1/i' => 1,
    ];
    $cantMatchCountMap = [
    ];

    foreach ($matchCountMap as $pattern => $amount) {
        if (DEBUG) {
            echo "\tTest: {$pattern}: ";
        }
        $count = preg_match_all($pattern, $string);
        if ($count < $amount) {
            if (DEBUG) {
                echo "Failed", PHP_EOL;
            }
            return false;
        }
        if (DEBUG) {
            echo "Passed", PHP_EOL;
        }
    }

    foreach ($cantMatchCountMap as $pattern) {
        if (DEBUG) {
            echo "\tTest NOT: {$pattern}: ";
        }
        $count = preg_match_all($pattern, $string);
        if ($count > 0) {
            if (DEBUG) {
                echo "Failed", PHP_EOL;
            }
            return false;
        }
        if (DEBUG) {
            echo "Passed", PHP_EOL;
        }
    }

    return true;
}

// tests
assert(is_nice('qjhvhtzxzqqjkmpb'));
assert(is_nice('xxyxx'));
assert(!is_nice('uurcxstgmygtbstg'));
assert(!is_nice('ieodomkazucvgmuy'));

$contents = [];
$contents = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$niceCount = 0;

foreach ($contents as $potential) {
    is_nice($potential) ? ++$niceCount : null;
}

echo "{$niceCount} nice strings", PHP_EOL;
