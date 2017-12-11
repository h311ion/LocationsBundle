<?php

namespace Test\LocationsBundle\Service;

use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JustBlackBird\JmsSerializerStrictJson\StrictJsonDeserializationVisitor;
use Test\LocationsBundle\Entity\Coordinates;
use Test\LocationsBundle\Entity\InputRequest;
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
     * Configuration constructor.
     * @param FileLocator $fileLocator
     */
    public function __construct(FileLocator $fileLocator)
    {
        $this->fileLocator = $fileLocator;
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
            /** @var InputRequest $inputRequest */
            $inputRequest = $serializer->deserialize($json, InputRequest::class, 'json');
        } catch (\Exception $e) {
            throw new MalformedJsonException($e->getMessage());
        }

        // TODO Check valid

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
     * @param array $errors JsonSchema errors
     * @return string
     */
    private function getValidatorErrorMessage(array $errors): string
    {
        $message = '';

        foreach ($errors as $error) {
            $message .= $error['property'] . ': ' . $error['message'];

        }

        return $message;
    }
}