<?php


namespace Test\LocationsBundle\Entity;


class Location
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Coordinates
     */
    private $coordinates;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinates $coordinates
     */
    public function setCoordinates($coordinates): void
    {
        $this->coordinates = $coordinates;
    }
}