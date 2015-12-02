<?php

$input = file_get_contents('input.txt');

$floor = 0;

for($i = 0,$l = strlen($input);$i < $l;++$i) {
    if ($input{$i} == "(") {
        ++$floor;
    }
    if ($input{$i} == ")") {
        --$floor;
    }
}

echo $floor;
