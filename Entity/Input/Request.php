<?php


namespace Test\LocationsBundle\Entity\Input;


use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class InputRequest
 * @package Test\LocationsBundle\Entity
 */
class Request
{
    /**
     * @var bool
     * @Type("bool")
     * @Assert\Type("strict_bool")
     */
    private $success;

    /**
     * @var Data
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
     * @return Data
     */
    public function getData(): Data
    {
        return $this->data;
    }

    /**
     * @param Data $data
     */
    public function setData(Data $data): void
    {
        $this->data = $data;
    }
}
