<?php

// simple object to store parse_input's value in
class ArrangementInfo
{
    private $subject;
    private $object;
    private $happinessDelta;

    private function __construct(string $subject, string $object, int $delta)
    {
        $this->subject        = $subject;
        $this->object         = $object;
        $this->happinessDelta = $delta;
    }

    public static function create(string $subject, string $object, int $delta)
    {
        return new self($subject, $object, $delta);
    }

    public function getSubject() : string
    {
        return $this->subject;
    }

    public function getObject() : string
    {
        return $this->object;
    }

    public function getHappinessDelta() : int
    {
        return $this->happinessDelta;
    }
}
