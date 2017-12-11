<?php


namespace Test\LocationsBundle\Entity;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class InputRequest
 * @package Test\LocationsBundle\Entity
 */
class InputRequest
{
    /**
     * @var bool
     * @Type("bool")
     * @Assert\Type("strict_bool")
     */
    private $success;

    /**
     * @var InputData
     * @Type("Test\LocationsBundle\Entity\InputData")
     * @Assert\NotBlank
     * @Assert\Valid
     */
    private $data;

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    /**
     * @return InputData
     */
    public function getData(): InputData
    {
        return $this->data;
    }

    /**
     * @param InputData $data
     */
    public function setData(InputData $data): void
    {
        $this->data = $data;
    }
}