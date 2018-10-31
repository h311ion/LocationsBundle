<?php


namespace Test\LocationsBundle\Entity\Input;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Location
 * @package Test\LocationsBundle\Entity
 */
class Location
{
    /**
     * @var string
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\NotBlank(groups={"success"})
     */
    private $name;

    /**
     * @var Coordinates
     * @Type("Test\LocationsBundle\Entity\InputCoordinates")
     * @Assert\NotBlank(groups={"success"})
     * @Assert\Valid
     */
    private $coordinates;

    /**
     * @return string
     * @Type("string")
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
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
    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }
}
