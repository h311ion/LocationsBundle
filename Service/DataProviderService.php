<?php

namespace Test\LocationsBundle\Service;

use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JustBlackBird\JmsSerializerStrictJson\StrictJsonDeserializationVisitor;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Test\LocationsBundle\Entity\Coordinates;
use Test\LocationsBundle\Entity\Input\Request;
use Test\LocationsBundle\Entity\Location;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Test\LocationsBundle\Exception\ErrorResponseException;
use Test\LocationsBundle\Exception\MalformedJsonException;
use Test\LocationsBundle\Exception\TransportException;


class DataProviderService
{
    /**
     * @var FileLocator
     */
    private $fileLocator;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Configuration constructor.
     * @param FileLocator $fileLocator
     * @param ValidatorInterface $validator
     */
    public function __construct(FileLocator $fileLocator, ValidatorInterface $validator)
    {
        $this->fileLocator = $fileLocator;
        $this->validator = $validator;
    }

    /**
     * @param string $uri
     * @return Location[]
     * @throws TransportException
     * @throws MalformedJsonException
     * @throws ErrorResponseException
     */
    public function getLocations(string $uri): array
    {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->get($uri);
            $json = (string)$response->getBody();
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage());
        }
        $serializer = SerializerBuilder::create()
            ->setDeserializationVisitor('json', new StrictJsonDeserializationVisitor(new CamelCaseNamingStrategy()))
            ->build();

        try {
            /** @var Request $inputRequest */
            $inputRequest = $serializer->deserialize($json, Request::class, 'json');
        } catch (\Exception $e) {
            throw new MalformedJsonException($e->getMessage());
        }

        try {
            $errors = $this->validator->validate($inputRequest, null, [$inputRequest->isSuccess() ? 'success' : 'fail']);
        } catch (\Exception $e) {
            throw new MalformedJsonException($e->getMessage());
        }
        if (count($errors) > 0) {
            throw new MalformedJsonException($this->getValidatorErrorMessage($errors));
        }

        if (!$inputRequest->isSuccess()) {
            throw new ErrorResponseException(
                sprintf(
                    "Failed to get locations data: %s -- %s",
                    $inputRequest->getData()->getCode(),
                    $inputRequest->getData()->getMessage()
                )
            );
        }
        $locations = [];
        foreach ($inputRequest->getData()->getLocations() as $location) {
            $newCoordinates = new Coordinates();
            $newCoordinates->setLat($location->getCoordinates()->getLat());
            $newCoordinates->setLong($location->getCoordinates()->getLong());

            $newLocation = new Location();
            $newLocation->setName($location->getName());
            $newLocation->setCoordinates($newCoordinates);

            $locations[] = $newLocation;
        }

        return $locations;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return string
     */
    private function getValidatorErrorMessage(ConstraintViolationListInterface $errors): string
    {
        $messages = [];

        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
        }

        return implode(PHP_EOL, $messages);
    }
}
