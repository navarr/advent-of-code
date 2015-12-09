<?php

class DistanceMapper
{
    /** @var int[] */
    private $distanceMap;

    /** @var string */
    private $cities;

    /**
     * @param string $from
     * @param string $to
     * @param int $distance
     *
     * @return $this
     */
    public function setDistance($from, $to, $distance)
    {
        $key = $this->createKey($from, $to);
        $this->addCity($from);
        $this->addCity($to);

        $this->distanceMap[$key] = $distance;
        return $this;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return int
     * @throws Exception
     */
    public function getDistance($from, $to)
    {
        $key = $this->createKey($from, $to);
        if (!isset( $this->distanceMap[$key] )) {
            var_dump($this->distanceMap);
            throw new Exception("No Distance Available for key {$key}");
        }
        return $this->distanceMap[$key];
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function addCity($city)
    {
        $this->cities[$city] = true;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getCities()
    {
        return array_keys($this->cities);
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    private function createKey($from, $to)
    {
        $places = [$from, $to];
        sort($places);
        $key = implode('->', $places);
        return $key;
    }
}
