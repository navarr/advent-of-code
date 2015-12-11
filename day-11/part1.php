<?php

function generate_next_password($current)
{
    /* Requirements:
     * - 8 lowercase letters (each letter must be >= 97, <= 122)
     * - one increasing straight of three letters (abc, bcd, cde, ... xyz)
     * - may not contain i, o, or l
     * - two different, non-overlapping pairs of letters (aa, bb, zz)
     */

    $array = str_split($current);
    $ascii = array_map('ord', $array);

    $valid = false;
    do {
        // do increment, overflow
        $i = count($ascii) - 1;
        while (true) {

            ++$ascii[$i];
            if (in_array(chr($ascii[$i]), ['i','l','o'])) {
                // skip bad letters
                ++$ascii[$i];
            }
            if ($ascii[$i] <= 122) {
                break;
            }

            $ascii[$i] = 97;
            --$i;
        }

        $newArray = array_map('chr', $ascii);
        $next     = implode('', $newArray);

        if ($next == 'ghjaabcd') die('whoops');

        // 8 lowercase handled by increment/overflow
        // one increasing straight of three
        $strait      = 0;
        $lastOrd     = null;
        $foundStrait = false;
        foreach ($ascii as $ord) {
            if ($ord == $lastOrd + 1) {
                ++$strait;
                $lastOrd = $ord;
            } else {
                $lastOrd = $ord;
                $strait  = 1;
            }
            if ($strait >= 3) {
                $foundStrait = true;
                break;
            }
        }
        if (!$foundStrait) {
            continue;
        } // next increment

        // may not contain i/o/l
        if (strpos($next, 'i') !== false) {
            continue;
        }
        if (strpos($next, 'l') !== false) {
            continue;
        }
        if (strpos($next, 'o') !== false) {
            continue;
        }

        if (preg_match_all('/([a-z])\1/', $next, $matches) < 2) {
            continue;
        }

        $valid = true;
    } while (!$valid);

    return $next;
}

$input = trim(file_get_contents('input.txt'));

$next = generate_next_password('ghijklmn');

echo $next, PHP_EOL;
