<?php

$timeToSimulate = 2503;

$file = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
/**
 * first key is the reindeer name, it is an array that contains the keys fly_speed, fly_time, and rest_time, total_distance
 */
$reindeer = [];
foreach ($file as $line) {
    $matches = [];
    preg_match(
        '/(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds./i',
        $line,
        $matches
    );
    $name      = $matches[1];
    $fly_speed = $matches[2];
    $fly_time  = $matches[3];
    $rest_time = $matches[4];

    $reindeer[$name] = [
        'name'           => $name,
        'fly_speed'      => $fly_speed,
        'fly_time'       => $fly_time,
        'rest_time'      => $rest_time,
        'total_distance' => 0,
    ];
}

foreach ($reindeer as $name => $info) {
    $time = 0;
    while ($time < $timeToSimulate) {
        $flytime = $info['fly_time'] < ($timeToSimulate - $time) ? $info['fly_time'] : ($timeToSimulate - $time);
        $reindeer[$name]['total_distance'] += $info['fly_speed'] * $flytime;
        $time += $info['fly_time'] + $info['rest_time'];
    }
}

usort($reindeer, function ($a, $b) {
    if ($a['total_distance'] > $b['total_distance']) {
        return -1;
    } elseif ($b['total_distance'] > $a['total_distance']) {
        return 1;
    } else {
        return 0;
    }
});

var_dump($reindeer);
