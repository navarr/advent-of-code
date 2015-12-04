<?php
$input = require_once('input.php');

$i = 0;
$hash = null;

$size = 6;

$zerostr = str_repeat('0', $size);

do {
    ++$i;
    $hash = md5($input.$i);
    $sub = substr($hash, 0, $size);
} while($sub !== $zerostr);

echo $i;
