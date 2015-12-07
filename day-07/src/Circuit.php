<?php

namespace Advent;

class Circuit
{
    private $signals = [];

    private $waits = [];

    public function writeSignal($code, $signal)
    {
        $this->signals[$code] = intval($signal, 10);
        $this->triggerWaits($code);
    }

    public function waitOnSignal($code, $callback)
    {
        if (!isset( $this->waits[$code] )) {
            $this->waits[$code] = [];
        }
        $this->waits[$code][] = $callback;
    }

    public function triggerWaits($code)
    {
        if (!isset( $this->waits[$code] )) {
            return;
        }

        $waits = $this->waits[$code];
        unset($this->waits[$code]);

        foreach ($waits as $callable) {
            $callable($code, $this->getSignal($code));
        }
    }

    public function hasSignal($code)
    {
        return isset( $this->signals[$code] );
    }

    public function getSignal($code)
    {
        if (!$this->hasSignal($code)) {
            throw new \RuntimeException('Called getSignal on not yet set signal');
        }
        return $this->signals[$code];
    }

    public function getOrWaitSignal($code, $callback)
    {
        if ($this->hasSignal($code)) {
            $callback($code, $this->getSignal($code));
        } else {
            $this->waitOnSignal($code, $callback);
        }
    }
}
