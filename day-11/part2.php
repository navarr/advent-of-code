<?php

require_once('inc/generate_next_password.func.php');

$input = trim(file_get_contents('input.txt'));

$next = generate_next_password($input);
// Santa's password expired again.  What's the next one?
$next = generate_next_password($next);

echo $next, PHP_EOL;
