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

$locationsVisited = ["0,0" => true];
$location = [];

foreach ($directions as $direction) {
    $move = new \AdventOfCode\Day1\MoveCommand($direction);
    $cardinal = DirectionTranslator::translate($cardinal, $move);
    $yDelta = 0;
    $xDelta = 0;
    $mod = 1;
    switch ($cardinal) {
        case DirectionTranslator::DIR_NORTH:
            $yDelta = $move->distance;
            $mod = 1;
            break;
        case DirectionTranslator::DIR_SOUTH:
            $yDelta = $move->distance;
            $mod = -1;
            break;
        case DirectionTranslator::DIR_EAST:
            $xDelta = $move->distance;
            $mod = 1;
            break;
        case DirectionTranslator::DIR_WEST:
            $xDelta = $move->distance;
            $mod = -1;
            break;
    }
    while ($xDelta > 0) {
        $x += $mod;
        --$xDelta;
        if (isset($locationsVisited["{$x},{$y}"])) {
            $location = [$x, $y];
            break 2;
        }
        $locationsVisited["{$x},{$y}"] = true;
    }
    while ($yDelta > 0) {
        $y += $mod;
        --$yDelta;
        if (isset($locationsVisited["{$x},{$y}"])) {
            $location = [$x, $y];
            break 2;
        }
        $locationsVisited["{$x},{$y}"] = true;
    }
}

if (empty($location)) {
    die('We never visit anywhere twice...?');
}

$x = $location[0];
$y = $location[1];

echo "{$x}, {$y}", PHP_EOL;
echo "Blocks Away: " . (abs($x) + abs($y)), PHP_EOL;
