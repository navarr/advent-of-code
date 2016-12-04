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

// http://php.net/manual/en/function.str-rot13.php#107475
function str_rot($s, $n = 13) {
    static $letters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
    $n = (int)$n % 26;
    if (!$n) return $s;
    if ($n < 0) $n += 26;
    if ($n == 13) return str_rot13($s);
    $rep = substr($letters, $n * 2) . substr($letters, 0, $n * 2);
    return strtr($s, $letters, $rep);
}

foreach ($rooms as $room) {
    $pieces = explode('-', $room);
    $piece2 = array_pop($pieces);
    $pieces2 = explode('[', $piece2);

    $roomData = [
        'name'      => implode('-', $pieces),
        'checkName' => implode('', $pieces),
        'sector'    => $pieces2[0],
        'checksum'  => substr($pieces2[1], 0, -1),
    ];

    $validCheck = substr(implode('', lettersByAmount($roomData['checkName'])), 0, strlen($roomData['checksum']));

    if ($validCheck == $roomData['checksum']) {
        $roomData['name'] = str_rot($roomData['name'], $roomData['sector']);
        if ($roomData['name'] == 'northpole-object-storage') {
            echo 'North Pole Object Storage, Sector '.$roomData['sector'],PHP_EOL;
        }
    }
}
