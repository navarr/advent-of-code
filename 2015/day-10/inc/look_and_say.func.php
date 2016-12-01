<?php

function look_and_say($number)
{
    $process   = (string) $number;
    $array     = [];
    $lastNum   = null;
    $lastCount = 0;
    for ($i = 0, $l = strlen($process); $i < $l; ++$i) {
        $num = $process{$i};
        if ($num != $lastNum) {
            if (!is_null($lastNum)) {
                $array[] = [(string)$lastCount, $lastNum];
            }
            $lastNum = $num;
            $lastCount = 0;
        }
        ++$lastCount;
    }
    $array[] = [(string)$lastCount, $lastNum];

    $newNumber = "";
    foreach($array as $item) {
        $newNumber .= $item[0].$item[1];
    }
    return $newNumber;
}
