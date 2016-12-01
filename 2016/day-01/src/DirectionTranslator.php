<?php

namespace AdventOfCode\Day1;

class DirectionTranslator
{
    const DIR_NORTH = 0;
    const DIR_EAST = 1;
    const DIR_SOUTH = 2;
    const DIR_WEST = 3;

    const DIR_RIGHT = 'R';
    const DIR_LEFT = 'L';

    private static $directionTranslator = [
        self::DIR_NORTH => [
            self::DIR_LEFT => self::DIR_WEST,
            self::DIR_RIGHT => self::DIR_EAST,
        ],
        self::DIR_EAST => [
            self::DIR_LEFT => self::DIR_NORTH,
            self::DIR_RIGHT => self::DIR_SOUTH,
        ],
        self::DIR_SOUTH => [
            self::DIR_LEFT => self::DIR_EAST,
            self::DIR_RIGHT => self::DIR_WEST,
        ],
        self::DIR_WEST => [
            self::DIR_LEFT => self::DIR_SOUTH,
            self::DIR_RIGHT => self::DIR_NORTH,
        ],
    ];

    public static function translate($currentDirection, MoveCommand $command)
    {
        return static::$directionTranslator[$currentDirection][$command->direction];
    }
}
