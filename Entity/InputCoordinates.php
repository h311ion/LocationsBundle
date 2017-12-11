<?php


namespace Test\LocationsBundle\Entity;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class InputRequest
 * @package Test\LocationsBundle\Entity
 */
class InputCoordinates
{
    /**
     * @var float
     * @Type("float")
     */
    private $lat;

    /**
     * @var float
     * @Type("float")
     */
    private $long;

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
    public function setLong(float $long): void
    {
        $this->long = $long;
    }

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
    public function setLat(float $lat): void
    {
        $this->lat = $lat;
    }
}