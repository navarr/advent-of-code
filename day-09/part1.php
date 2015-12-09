<?php

require_once('inc/DistanceMapper.class.php');
require_once('inc/generate_all_orders.func.php');

$file = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$map = new DistanceMapper();

foreach ($file as $line) {
    preg_match('/(\w+) to (\w+) = (\d+)/i', $line, $parts);
    $a        = $parts[1];
    $b        = $parts[2];
    $distance = $parts[3];

    $map->setDistance($a, $b, $distance);
}

$cities = $map->getCities();

$paths = array();

$paths = generate_all_orders($cities);

$shortestDistance = INF;
$shortestDistancePath = null;

foreach ($paths as $path) {
    $distance = 0;
    for($i = 0;$i < count($path)-1;++$i) {
        $distance += $map->getDistance($path[$i], $path[$i+1]);
    }

    if ($distance < $shortestDistance) {
        $shortestDistance = $distance;
        $shortestDistancePath = implode(' -> ', $path);
    }
}

echo $shortestDistancePath.' = '.$shortestDistance;
