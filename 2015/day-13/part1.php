<?php

require_once('inc/_include_all.php');

$input = file('input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

$info    = parse_input($input);
$infoMap = [];
$uniques = [];

foreach ($info as $piece) {
    $uniques[$piece->getSubject()] = true;
    if (!isset($infoMap[$piece->getSubject()])) {
        $infoMap[$piece->getSubject()] = [];
    }
    $infoMap[$piece->getSubject()][$piece->getObject()] = $piece->getHappinessDelta();
}

$uniques = array_keys($uniques);

$allorders = generate_all_orders($uniques);

$maxArrangement = null;
$maxHappiness   = 0;

foreach ($allorders as $order) {
    $happiness = calculate_total_happiness($order, $infoMap);
    if ($happiness > $maxHappiness) {
        $maxHappiness   = $happiness;
        $maxArrangement = $order;
    }
}

var_dump($maxArrangement);

echo PHP_EOL,"Happiness: ",$maxHappiness,PHP_EOL;
