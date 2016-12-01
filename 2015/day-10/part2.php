<?php

require_once('inc/look_and_say.func.php');

// ridiculously high.
ini_set('memory_limit', '1G');

$result = trim(file_get_contents('input.txt'));
for($i = 0;$i < 50;++$i) {
    $result = look_and_say($result);
}

$len = strlen($result);

echo "Answer: {$len}\n";
