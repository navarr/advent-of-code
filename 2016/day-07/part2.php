<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function abba_exists($input)
{
    $string = str_split($input);
    for ($i = 0, $l = count($string) - 3; $i < $l; ++$i) {
        switch (true) {
            case ($string[$i] == $string[$i + 1]):
            case ($string[$i + 1] != $string[$i + 2]):
            case ($string[$i] != $string[$i + 3]):
                continue;
            default:
                return true;
        }
    }
    return false;
}

global $last_has_tls_error;
function has_tls($line)
{
    global $last_has_tls_error;
    $ipParts = [];
    $hypernetParts = [];

    while (strpos($line, '[') !== false) {
        $startPos = strpos($line, '[');

        $ipPart = substr($line, 0, $startPos);
        $ipParts[] = $ipPart;

        $line = substr($line, $startPos+1);

        $endPos = strpos($line, ']');
        $hypernetPart = substr($line, 0, $endPos);
        $hypernetParts[] = $hypernetPart;

        $line = substr($line, $endPos+1);
    };
    $ipParts[] = $line;

    $ipAbba = false;
    foreach ($ipParts as $ipPart) {
        if (abba_exists($ipPart)) {
            $ipAbba = true;
            break;
        }
    }

    if (!$ipAbba) {
        $last_has_tls_error = 'No IP ABBA';
        return false;
    }

    $hypernetAbba = false;
    foreach ($hypernetParts as $hypernetPart) {
        if (abba_exists($hypernetPart)) {
            $hypernetAbba = true;
            break;
        }
    }

    if ($hypernetAbba) {
        $last_has_tls_error = 'Has Hypernet ABBA';
        return false;
    }

    return true;
}

$ipsWithTLS = 0;

// ASSERTIONS
assert(has_tls('abba[mnop]qrst')) or die('Assertion 1 Failed');
assert(!has_tls('abcd[bddb]xyyx')) or die ('Assertion 2 Failed');
assert(!has_tls('aaaa[qwer]tyui')) or die ('Assertion 3 Failed');
assert(has_tls('ioxxoj[asdfgh]zxcvbn')) or die('Assertion 4 Failed');

foreach ($input as $line) {
    if (has_tls($line)) {
        ++$ipsWithTLS;
    }
}

echo $ipsWithTLS,' IP Addresses have TLS',PHP_EOL;
