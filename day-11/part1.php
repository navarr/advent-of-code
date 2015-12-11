<?php

require_once('inc/generate_next_password.func.php');

$input = trim(file_get_contents('input.txt'));

$next = generate_next_password($input);

echo $next, PHP_EOL;
