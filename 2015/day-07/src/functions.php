<?php

function gate_and($a, $b)
{
    $a = intval($a, 10);
    $b = intval($b, 10);
    return $a & $b;
}

function gate_or($a, $b)
{
    $a = intval($a, 10);
    $b = intval($b, 10);
    return $a | $b;
}

function gate_not($a)
{
    $a = intval($a, 10);
    return ~$a;
}

function gate_xor($a, $b)
{
    $a = intval($a, 10);
    $b = intval($b, 10);
    return $a ^ $b;
}

function gate_leftshift($a, $steps)
{
    $a = intval($a, 10);
    $steps = intval($steps, 10);
    return $a << $steps;
}

function gate_rightshift($a, $steps)
{
    $a = intval($a, 10);
    $steps = intval($steps, 10);
    return $a >> $steps;
}

function parses_as_int($a)
{
    return $a == (string)intval($a, 10);
}
