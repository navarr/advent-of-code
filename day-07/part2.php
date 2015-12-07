<?php

// Run `composer install`
require_once( 'vendor/autoload.php' );

$commands = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$circuit = new \Advent\Circuit();

foreach ($commands as $commandString) {
    // Part 2 - Override b!
    if ($commandString == '14146 -> b') {
        $commandString = '956 -> b';
    }
    $tokens    = explode(' ', $commandString);
    $command   = '';
    $operators = [];

    if (count($tokens) == '3' && $tokens[1] == '->') {
        $command = 'STORE';
        $writeTo = $tokens[2];
    } elseif ($tokens[0] == 'NOT') {
        $command = 'NOT';
        $writeTo = $tokens[3];
    } else {
        $writeTo = $tokens[4];
        $command = $tokens[1];
    }

    switch ($command) {
        case 'STORE':
            if (parses_as_int($tokens[0])) {
                $circuit->writeSignal($writeTo, $tokens[0]);
            } else {
                $circuit->getOrWaitSignal($tokens[0], function ($code, $value) use ($writeTo, &$circuit) {
                    $circuit->writeSignal($writeTo, $value);
                });
            }
            break;
        case 'NOT':
            if (parses_as_int($tokens[1])) {
                $circuit->writeSignal($writeTo, gate_not($tokens[1]));
            } else {
                $circuit->getOrWaitSignal($tokens[1], function ($code, $value) use ($writeTo, &$circuit) {
                    $circuit->writeSignal($writeTo, gate_not($value));
                });
            }
            break;
        case 'AND':
            $waits = 0;
            if (!parses_as_int($tokens[0])) {
                ++$waits;
            }
            if (!parses_as_int($tokens[2])) {
                ++$waits;
            }
            if ($waits == 2) {
                $a         = $tokens[0];
                $b         = $tokens[2];
                $multiWait = new \Advent\MultiSignalWait(
                    $circuit,
                    [$tokens[0], $tokens[2]],
                    function () use (&$circuit, $writeTo, $a, $b) {
                        $a = $circuit->getSignal($a);
                        $b = $circuit->getSignal($b);
                        $circuit->writeSignal($writeTo, gate_and($a, $b));
                    }
                );
            } elseif ($waits == 1) {
                if (parses_as_int($tokens[0])) {
                    $waitOn = $tokens[2];
                    $number = $tokens[0];
                } else {
                    $waitOn = $tokens[0];
                    $number = $tokens[2];
                }

                $circuit->getOrWaitSignal($waitOn, function ($code, $value) use ($writeTo, &$circuit, $number) {
                    $circuit->writeSignal($writeTo, gate_and($number, $value));
                });
            } else {
                $circuit->writeSignal($writeTo, gate_and($tokens[0], $tokens[2]));
            }
            break;
        case 'OR':
            $waits = 0;
            if (!parses_as_int($tokens[0])) {
                ++$waits;
            }
            if (!parses_as_int($tokens[2])) {
                ++$waits;
            }
            if ($waits == 2) {
                $a         = $tokens[0];
                $b         = $tokens[2];
                $multiWait = new \Advent\MultiSignalWait(
                    $circuit,
                    [$tokens[0], $tokens[2]],
                    function () use (&$circuit, $writeTo, $a, $b) {
                        $a = $circuit->getSignal($a);
                        $b = $circuit->getSignal($b);
                        $circuit->writeSignal($writeTo, gate_or($a, $b));
                    }
                );
            } elseif ($waits == 1) {
                if (parses_as_int($tokens[0])) {
                    $waitOn = $tokens[2];
                    $number = $tokens[0];
                } else {
                    $waitOn = $tokens[0];
                    $number = $tokens[2];
                }

                $circuit->getOrWaitSignal($waitOn, function ($code, $value) use ($writeTo, &$circuit, $number) {
                    $circuit->writeSignal($writeTo, gate_or($number, $value));
                });
            } else {
                $circuit->writeSignal($writeTo, gate_or($tokens[0], $tokens[2]));
            }
            break;
        case 'LSHIFT':
            if (parses_as_int($tokens[0])) {
                $circuit->writeSignal($writeTo, gate_leftshift($tokens[0], $tokens[2]));
            } else {
                $shiftVal = $tokens[2];
                $circuit->getOrWaitSignal($tokens[0], function($code, $value) use ($writeTo, &$circuit, $shiftVal) {
                    $circuit->writeSignal($writeTo, gate_leftshift($value, $shiftVal));
                });
            }
            break;
        case 'RSHIFT':
            if (parses_as_int($tokens[0])) {
                $circuit->writeSignal($writeTo, gate_rightshift($tokens[0], $tokens[2]));
            } else {
                $shiftVal = $tokens[2];
                $circuit->getOrWaitSignal($tokens[0], function($code, $value) use ($writeTo, &$circuit, $shiftVal) {
                    $circuit->writeSignal($writeTo, gate_rightshift($value, $shiftVal));
                });
            }
            break;
    }
}

echo $circuit->getSignal('a'), PHP_EOL;
