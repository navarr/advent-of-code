<?php

require_once(__DIR__ . '/ArrangementInfo.php');

/**
 * @param array $lines
 *
 * @return ArrangementInfo[]
 */
function parse_input(array $lines)
{
    $infos = [];
    foreach ($lines as $line) {
        preg_match('/^(\w+) would (\w+) (\d+) happiness units by sitting next to (\w+)\./i', $line, $matches);
        $subject = $matches[1];
        $delta   = $matches[3];
        $object  = $matches[4];
        if ($matches[2] == 'lose') {
            $delta *= -1;
        }
        $infos[] = ArrangementInfo::create($subject, $object, $delta);
    }
    return $infos;
}

