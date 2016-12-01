<?php

namespace Advent;

class MultiSignalWait
{
    /** @var [(string)signal => (boolean)ready] */
    private $signals;

    /** @var callable */
    private $callback;

    private $done = false;

    public function __construct(Circuit &$circuit, array $signals, callable $callback)
    {
        $this->callback = $callback;
        foreach ($signals as $signal) {
            $this->signals[$signal] = false;
        }

        foreach ($signals as $signal) {
            $circuit->getOrWaitSignal($signal, [$this, 'waitCallback']);
        }
    }

    public function waitCallback($signal, $value)
    {
        if ($this->done) {
            return;
        }

        $this->signals[$signal] = true;
        $this->checkToRun();
    }

    public function checkToRun()
    {
        foreach ($this->signals as $signal => $ready) {
            if ($ready == false) {
                return;
            }
        }

        $this->done = true;
        $this->finalCallback();
    }

    public function finalCallback()
    {
        $callback = $this->callback;
        $callback();
    }
}
