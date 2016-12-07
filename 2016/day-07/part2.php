<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function get_abas($input)
{
    $abas = [];
    $string = str_split($input);
    for ($i = 0, $l = count($string) - 2; $i < $l; ++$i) {
        switch (true) {
            case ($string[$i] == $string[$i + 1]):
            case ($string[$i] != $string[$i + 2]):
                continue;
            default:
                $abas[] = implode('', [$string[$i], $string[$i+1], $string[$i+2]]);
        }
    }
    return $abas;
}

function aba_to_bab($input)
{
    $string = str_split($input);
    return implode('', [$string[1], $string[0], $string[1]]);
}

global $last_has_ssl_error;
function has_ssl($line)
{
    global $last_has_ssl_error;
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

    $ip_abas = [];
    foreach ($ipParts as $ipPart) {
        $ip_abas = array_merge($ip_abas, get_abas($ipPart));
    }

    if (empty($ip_abas)) {
        $last_has_ssl_error = 'No IP ABAs';
        return false;
    }

    $ip_babs = array_map('aba_to_bab', $ip_abas);

    $hypernet_abas = [];
    foreach ($hypernetParts as $hypernetPart) {
        $hypernet_abas = array_merge($hypernet_abas, get_abas($hypernetPart));
    }

    if (empty($hypernet_abas)) {
        $last_has_ssl_error = 'No Hypernet BABs';
        return false;
    }

    $uniques = array_intersect($ip_babs, $hypernet_abas);
    if (!count($uniques)) {
        $last_has_ssl_error = 'No Hypernet BABs corresponding to an IP ABA';
        return false;
    }
    return true;
}

$ipsWithSSL = 0;

// ASSERTIONS
assert(has_ssl('aba[bab]xyz')) or die('Assertion 1 Failed');
assert(!has_ssl('xyx[xyx]xyx')) or die('Assertion 2 Failed');
assert(has_ssl('aaa[kek]eke')) or die('Assertion 3 Failed');
assert(has_ssl('zazbz[bzb]cdb')) or die('Assertion 4 Failed');

foreach ($input as $line) {
    if (has_ssl($line)) {
        ++$ipsWithSSL;
    }
}

echo $ipsWithSSL,' IP Addresses have TLS',PHP_EOL;
