<?php


namespace Test\LocationsBundle\Entity;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;


class InputData
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
     * @var InputLocation[]
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
     * @return InputLocation[]
     */
    public function getLocations(): array
    {
        return $this->locations;
    }

    /**
     * @param InputLocation[] $locations
     */
    public function setLocations(array $locations): void
    {
        $this->locations = $locations;
    }
}