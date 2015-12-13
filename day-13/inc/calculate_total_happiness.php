<?php

// the hardish part
function calculate_total_happiness(array $order, array $infoMap) : int
{
    $happiness = 0;
    for ($i = 0, $l = count($order); $i < $l; ++$i) {
        $before = $i - 1;
        $after  = $i + 1;
        if ($i == 0) {
            $before = $l - 1;
        }
        if ($i == $l - 1) {
            $after = 0;
        }

        $happiness += $infoMap[$order[$i]][$order[$before]];
        $happiness += $infoMap[$order[$i]][$order[$after]];
    }
    return $happiness;
}
