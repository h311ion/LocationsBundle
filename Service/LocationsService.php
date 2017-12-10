<?php

namespace Test\LocationsBundle\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Test\LocationsBundle\Entity\Location;

class LocationsService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * Configuration constructor.
     * @param ValidatorInterface $validator
     * @param Serializer $serializer
     */
    public function __construct(ValidatorInterface $validator, Serializer $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @param string $uri
     * @return Location[]
     */
    public function getLocations(string $uri): array
    {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->get($uri);
            $data = json_decode((string)$response->getBody(), true);
            if (!isset($data['success'])) {

            }
        } catch (\Exception $e) {

        }
    }
}