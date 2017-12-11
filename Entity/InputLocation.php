<?php


namespace Test\LocationsBundle\Entity;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class InputLocation
 * @package Test\LocationsBundle\Entity
 */
class InputLocation
{
    /**
     * @var string
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\NotBlank(groups={"success"})
     */
    private $name;

    /**
     * @var InputCoordinates
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
     * @return InputCoordinates
     */
    public function getCoordinates(): InputCoordinates
    {
        return $this->coordinates;
    }

    /**
     * @param InputCoordinates $coordinates
     */
    public function setCoordinates(InputCoordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }
}