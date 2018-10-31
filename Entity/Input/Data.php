<?php


namespace Test\LocationsBundle\Entity\Input;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;


class Data
{
    /**
     * @var string
     * @Type("string")
     * @Assert\NotBlank(groups={"fail"})
     * @Assert\Type("string")
     */
    private $message;

    /**
     * @var string
     * @Type("string")
     * @Assert\NotBlank(groups={"fail"})
     * @Assert\Type("string")
     */
    private $code;

    /**
     * @var Location[]
     * @Type("array<Test\LocationsBundle\Entity\InputLocation>")
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Type("Test\LocationsBundle\Entity\InputLocation")
     * }, groups={"success"})
     * @Assert\NotBlank(groups={"success"})
     * @Assert\Valid
     */
    private $locations;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return Location[]
     */
    public function getLocations(): array
    {
        return $this->locations;
    }

    /**
     * @param Location[] $locations
     */
    public function setLocations(array $locations): void
    {
        $this->locations = $locations;
    }
}
