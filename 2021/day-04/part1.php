<?php

declare(strict_types=1);

require_once(__DIR__.'/BingoBoard.php');

$input = file(__DIR__ . '/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$marks = array_map(
    static function ($mark) {
        return (int)$mark;
    },
    explode(',',current($input))
);

next($input); // Move pointer forward

// Now, we're processing this file without empty lines - which means there are no spaces between boards
// So we don't need to process those empty lines.  Each board is 5x5, so after 5, its a new board

/** @var BingoBoard[] $boards */
$boards = [];

$i = 1;
do { // Similar to foreach but this is the block that contains 1 board
    $boardData = [];
    for($row = 0;$row < 5;++$row) {
        $currentInput = current($input);
        $split = str_split($currentInput, 3);
        $boardData[] = array_map(
            static function (string $input) {
                return (int)trim($input);
            },
            $split
        );
        next($input);
    }
    $boards[] = new BingoBoard($boardData);

    ++$i;
} while (current($input));

// Time to play Bingo.

foreach ($marks as $mark) {
    foreach ($boards as $board) {
        $board->mark($mark);
        $score = $board->getScore();
        if ($score > 0) {
            echo "Win!  Score: {$score}",PHP_EOL;
            break 2;
        }
    }
}

var_dump($marks);
var_dump($boards);