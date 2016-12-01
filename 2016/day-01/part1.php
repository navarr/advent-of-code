<?php

require_once('vendor/autoload.php');

use AdventOfCode\Day1\DirectionTranslator;

$directions = file_get_contents('input.txt');
$directions = explode(',', $directions);
$directions = array_map(
    function ($direction) {
        return trim($direction);
    },
    $directions
);

$cardinal = DirectionTranslator::DIR_NORTH;
$x = 0;
$y = 0;

foreach ($directions as $direction) {
    $move = new \AdventOfCode\Day1\MoveCommand($direction);
    $cardinal = DirectionTranslator::translate($cardinal, $move);
    switch ($cardinal) {
        case DirectionTranslator::DIR_NORTH:
            $y += $move->distance;
            break;
        case DirectionTranslator::DIR_SOUTH:
            $y -= $move->distance;
            break;
        case DirectionTranslator::DIR_EAST:
            $x += $move->distance;
            break;
        case DirectionTranslator::DIR_WEST:
            $x -= $move->distance;
            break;
    }
}

echo "{$x}, {$y}",PHP_EOL;
echo "Blocks Away: ".(abs($x) + abs($y)),PHP_EOL;
