<?php
$input = require_once('input.php');

$i = 0;
$hash = null;
$zerostr = str_repeat('0', 5);

do {
    ++$i;
    $hash = md5($input.$i);
    $sub = substr($hash, 0, 5);
} while($sub !== $zerostr);

echo $i;
