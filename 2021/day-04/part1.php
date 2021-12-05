<?php

declare(strict_types=1);

require_once(__DIR__.'/BingoBoard.php');

$input = file(__DIR__ . '/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$marks = explode(',',current($input));

next($input); // Drive input forward to the boards

// Now, we're processing this file without empty lines - which means there are no spaces between boards
// So we don't need to process those empty lines.  Each board is 5x5, so after 5, its a new board

do { // Similar to foreach but this is the block that contains 1 board
    $board = [];
    for($row = 0;$row < 5;++$row) {
        $board[] = array_map(
            static function (string $input) {
                return (int)trim($input);
            },
            str_split(current($input), 3)
        );
        next($input);
    }
    var_dump($board);
    echo PHP_EOL,PHP_EOL;
    exit; // debug
} while(next($input));