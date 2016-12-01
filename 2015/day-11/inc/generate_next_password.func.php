<?php
function generate_next_password($current)
{
    /* Requirements:
    * - 8 lowercase letters (each letter must be >= 97, <= 122)
    * - one increasing straight of three letters (abc, bcd, cde, ... xyz)
    * - may not contain i, o, or l
    * - two different, non-overlapping pairs of letters (aa, bb, zz)
    */
    $min       = 97;
    $max       = 122;
    $forbidden = array('i', 'l', 'o');

    $array = str_split($current);
    $ascii = array_map('ord', $array);

    $valid = false;
    do {
        // do increment, overflow
        for ($i = 0, $l = count($ascii); $i < $l; ++$i) {
            if (in_array(chr($ascii[$i]), $forbidden)) {
                $ascii[$i]++;
                for ($j = $i + 1; $j < $l; ++$j) {
                    $ascii[$j] = $min;
                }
            }
        }
        $i = count($ascii) - 1;
        while (true) {

            ++$ascii[$i];
            if (in_array(chr($ascii[$i]), $forbidden)) {
                // skip bad letters
                ++$ascii[$i];
            }
            if ($ascii[$i] <= $max) {
                break;
            }

            $ascii[$i] = $min;
            --$i;
        }

        $newArray = array_map('chr', $ascii);
        $next     = implode('', $newArray);

        if ($next == 'ghjaabcd') {
            die( 'whoops' );
        }

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

        if (preg_match_all('/([a-z])\1/', $next, $matches) < 2) {
            continue;
        }

        $valid = true;
    } while (!$valid);

    return $next;
}
