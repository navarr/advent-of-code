<?php

$baseInput = file_get_contents('input.txt');

$inputs = explode("\n", $baseInput);

$runningTotal = 0;

foreach($inputs as $inputString) {
    if (empty($inputString)) continue;

    // 0 => l, 1 => w, 2 => h
    $input = explode('x', $inputString);
    $l = $input[0];
    $w = $input[1];
    $h = $input[2];

    $most = (2*$l*$w) + (2*$w*$h) + (2*$h*$l);
    $slack = 0;

    $wh = $w*$h;
    $hl = $h*$l;
    $lw = $l*$w;

    if ($wh <= $hl && $wh <= $lw) {
        $slack = $wh;
    } elseif ($hl <= $wh && $hl <= $lw) {
        $slack = $hl;
    } elseif ($lw <= $hl && $lw <= $wh) {
        $slack = $lw;
    } else {
        throw new Exception("{$inputString}: none of the ifs");
    }

    echo $inputString,'=',$most,'+',$slack,'=',($most+$slack),PHP_EOL;

    $runningTotal += $most + $slack;
}

echo $runningTotal;
