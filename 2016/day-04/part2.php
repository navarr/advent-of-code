<?php

$rooms = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function lettersByAmount($string)
{
    // [x => ['letter' => x, 'amount' => y], ...]
    $info = [];
    for ($i = 0, $l = strlen($string); $i < $l; ++$i) {
        $letter = $string{$i};
        if (!isset($info[$letter])) {
            $info[$letter] = ['letter' => $letter, 'amount' => 0];
        }
        $info[$letter]['amount']++;
    }

    usort(
        $info,
        function ($a, $b) {
            if ($a['amount'] > $b['amount']) {
                return -1;
            } elseif ($a['amount'] < $b['amount']) {
                return 1;
            }
            return strcmp($a['letter'], $b['letter']);
        }
    );

    return array_map(
        function ($info) {
            return $info['letter'];
        },
        $info
    );
}

$sectorSum = 0;

foreach ($rooms as $room) {
    $pieces = explode('-', $room);
    $piece2 = array_pop($pieces);
    $pieces2 = explode('[', $piece2);

    $roomData = [
        'name'     => implode('', $pieces),
        'sector'   => $pieces2[0],
        'checksum' => substr($pieces2[1], 0, -1),
    ];

    $validCheck = substr(implode('', lettersByAmount($roomData['name'])), 0, strlen($roomData['checksum']));

    if ($validCheck == $roomData['checksum']) {
        $sectorSum += $roomData['sector'];
    }
}

echo $sectorSum,PHP_EOL;
