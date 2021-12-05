<?php

declare(strict_types=1);

class BingoBoard
{
    private const ROW_COUNT = 5;
    private const COLUMN_COUNT = 5;

    private array $marks = [];

    /**
     * @param $board array[] First index is row, second index is column
     */
    public function __construct(
        private readonly array $board
    ) {}

    /**
     * @param int $number The number being called out
     * @return bool Whether or not the number was marked on the board
     */
    public function mark(int $number): void
    {
        $this->marks[] = $number;
    }

    public function hasWon(): bool
    {
        // Check Rows
        for($i =0;$i < self::ROW_COUNT;++$i) {
            if ($this->checkRowForWin($i)) {
                return true;
            }
        }

        // Check Columns
        for ($i = 0;$i < self::COLUMN_COUNT;++$i) {
            if ($this->checkColumnForWin($i)) {
                return true;
            }
        }

        // Check Diagonals
        if ($this->checkLeftDiagonalForWin()) {
            return true;
        }
        if ($this->checkRightDiagonalForWin()) {
            return true;
        }
        return false;
    }

    public function getScore(): int
    {
        if (!$this->hasWon()) {
            return 0;
        }
        
        $unmarkedSum = array_sum($this->getUnmarkedNumbers());
        $lastNumber = end($this->marks);

        return $unmarkedSum * $lastNumber;
    }

    private function isMarked(int $number): bool
    {
        return in_array($number, $this->marks);
    }

    /**
     * @return int[]
     */
    private function getUnmarkedNumbers(): array
    {
        $numbers = [];
        for ($row = 0;$row < self::ROW_COUNT;++$row) {
            for ($column = 0;$column < self::COLUMN_COUNT;++$column) {
                $number = $this->board[$row][$column];
                if (!$this->isMarked($number)) {
                    $numbers[] = $number;
                }
            }
        }
        return $numbers;
    }

    private function checkRowForWin(int $row): bool
    {
        if ($row < 0 || $row >= self::ROW_COUNT) {
            throw new \RangeException("Row must be between (inclusive) 0 and ".self::ROW_COUNT - 1);
        }
        for($i = 0;$i < self::COLUMN_COUNT;++$i) {
            if (!$this->isMarked($this->board[$row][$i])) {
                return false;
            }
        }
        return true;
    }

    private function checkColumnForWin(int $column): bool
    {
        if ($column < 0 || $column >= self::COLUMN_COUNT) {
            throw new \RangeException("Column must be between (inclusive) 0 and ".self::COLUMN_COUNT - 1);
        }
        for ($i = 0;$i < self::ROW_COUNT;++$i) {
            if (!$this->isMarked($this->board[$i][$column])) {
                return false;
            }
        }
        return true;
    }

    private function checkLeftDiagonalForWin(): bool
    {
        for($i = 0;$i < self::ROW_COUNT;++$i) {
            if (!$this->isMarked($this->board[$i][$i])) {
                return false;
            }
        }
        return true;
    }

    private function checkRightDiagonalForWin(): bool
    {
        $checkColumn = self::COLUMN_COUNT - 1;
        for($i = 0;$i < self::ROW_COUNT;++$i) {
            if (!$this->isMarked($this->board[$i][$checkColumn])) {
                return false;
            }
            $checkColumn--;
        }
        return true;
    }
}