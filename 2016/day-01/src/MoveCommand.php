<?php

namespace AdventOfCode\Day1;

class MoveCommand
{
    public $direction;
    public $distance;

    function __construct($direction)
    {
        $this->direction = substr($direction, 0, 1);
        $this->distance = intval(substr($direction, 1), 10);
    }
}
