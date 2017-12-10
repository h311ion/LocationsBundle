<?php


namespace Test\LocationsBundle\Entity;


class Coordinates
{
    /**
     * @var float
     */
    private $lat;

    /**
     * @var float
     */
    private $long;

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLong(): float
    {
        return $this->long;
    }

    /**
     * @param float $long
     */
    public function setLong($long): void
    {
        $this->long = $long;
    }

}