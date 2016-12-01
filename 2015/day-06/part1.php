<?php

//$contents = ['turn on 0,0 through 999,999'];
$contents = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$matrixWidth  = 1000;
$matrixHeight = 1000;
$matrix = new SplFixedArray($matrixWidth); // level one: x, level two: y

// Assemble Matrix
for ($x = 0; $x < $matrixWidth; ++$x) {
    $matrix[$x] = new SplFixedArray($matrixHeight);
    for ($y = 0;$y < $matrixHeight; ++$y) {
        $matrix[$x][$y] = false;
    }
}

// Parse Instructions
foreach($contents as $instruction) {
    $parts = preg_match('/([\w\s]+) (\d+),(\d+) ([\w\s]+) (\d+),(\d+)/', $instruction, $matches);

    $command = trim($matches[1]);
    $startX = $matches[2];
    $endX = $matches[5];
    $startY = $matches[3];
    $endY = $matches[6];

    for($x = $startX;$x <= $endX;++$x) {
        for ($y = $startY;$y <= $endY;++$y) {
            switch($command) {
                case 'turn on':
                    $matrix[$x][$y] = true;
                    break;
                case 'turn off':
                    $matrix[$x][$y] = false;
                    break;
                case 'toggle':
                    $matrix[$x][$y] = !$matrix[$x][$y];
                    break;
                default:
                    throw new Exception("Bad Command {$command}");
            }
        }
    }
}

$countOn = 0;
foreach($matrix as $y) {
    foreach ($y as $light) {
        $light ? ++ $countOn : null;
    }
}

echo "{$countOn} lights turned on",PHP_EOL;
