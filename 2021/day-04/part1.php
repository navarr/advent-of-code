<?php

declare(strict_types=1);

require_once(__DIR__.'/BingoBoard.php');

$input = file(__DIR__ . '/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$marks = explode(',',current($input));

next($input); // Drive input forward to the boards

// Now, we're processing this file without empty lines - which means there are no spaces between boards
// So we don't need to process those empty lines.  Each board is 5x5, so after 5, its a new board

/** @var BingoBoard[] $boards */
$boards = [];

do { // Similar to foreach but this is the block that contains 1 board
    $boardData = [];
    for($row = 0;$row < 5;++$row) {
        $boardData[] = array_map(
            static function (string $input) {
                return (int)trim($input);
            },
            str_split(current($input), 3)
        );
        next($input);
    }
    $boards[] = new BingoBoard($boardData);
} while (next($input));

Time to play Bingo.

foreach ($marks as $mark) {
    foreach ($boards as $board) {
        $board->mark($mark);
        $score = $board->getScore();
        if ($score > 0) {
            echo "Win!  Score: {$score}",PHP_EOL;
            exit 0;
        }
    }
}