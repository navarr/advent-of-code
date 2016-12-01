<?php

class Reindeer
{
    const STATE_RESTING = 0;
    const STATE_FLYING = 1;

    private $name;
    private $speedInKms;
    private $flyTime;
    private $restTime;
    private $state = self::STATE_FLYING;

    private $secondsInState = 0;

    private $totalDistance = 0;

    private $points = 0;

    public function __construct($name, $speed, $flyTime, $restTime)
    {
        $this->name       = $name;
        $this->speedInKms = $speed;
        $this->flyTime    = $flyTime;
        $this->restTime   = $restTime;
    }

    public function doTick()
    {
        if ($this->secondsInState >= $this->getTotalTimeForState()) {
            $this->state = $this->getNextState();
            $this->secondsInState = 0;
        }
        ++$this->secondsInState;
        if ($this->state == static::STATE_FLYING) {
            $this->totalDistance += $this->speedInKms;
        }
    }

    private function getTotalTimeForState()
    {
        switch ($this->state) {
            case static::STATE_FLYING:
                return $this->flyTime;
            case static::STATE_RESTING:
                return $this->restTime;
            default:
                return 0;
        }
    }

    private function getNextState()
    {
        switch ($this->state) {
            case static::STATE_FLYING:
            default:
                return static::STATE_RESTING;
            case static::STATE_RESTING:
                return static::STATE_FLYING;
        }
    }

    public function getDistance()
    {
        return $this->totalDistance;
    }

    public function rewardPoint()
    {
        ++$this->points;
    }

    public function getPoints()
    {
        return $this->points;
    }
}

$timeToSimulate = 2503;

$file = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

/** @var Reindeer[] $reindeer */
$reindeer = [];
foreach ($file as $line) {
    $matches = [];
    preg_match(
        '/(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds./i',
        $line,
        $matches
    );
    $name      = $matches[1];
    $fly_speed = $matches[2];
    $fly_time  = $matches[3];
    $rest_time = $matches[4];

    $reindeer[$name] = new Reindeer($name, $fly_speed, $fly_time, $rest_time);
}

for ($time = 0; $time < $timeToSimulate; ++$time) {
    /** @var Reindeer[] $roundWinners */
    $roundWinners = [];
    foreach ($reindeer as $singleReindeer) {
        $singleReindeer->doTick();
        if (empty( $roundWinners ) || $roundWinners[0]->getDistance() < $singleReindeer->getDistance()) {
            $roundWinners = [$singleReindeer];
        } elseif ($roundWinners[0]->getDistance() == $singleReindeer->getDistance()) {
            $roundWinners[] = $singleReindeer;
        }
    }
    foreach ($roundWinners as $roundWinner) {
        $roundWinner->rewardPoint();
    }
}

usort($reindeer, function (Reindeer $a, Reindeer $b) {
    if ($a->getPoints() > $b->getPoints()) {
        return -1;
    } elseif ($b->getPoints() > $a->getPoints()) {
        return 1;
    } else {
        return 0;
    }
});

var_dump($reindeer);
