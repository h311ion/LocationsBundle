<?php

namespace Test\LocationsBundle\Service;

use Test\LocationsBundle\Entity\Location;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Test\LocationsBundle\Exception\MalformedJsonException;


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
     */
    public function getLocations(string $uri): array
    {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->get($uri);
            $data = json_decode((string)$response->getBody(), true);

            $validator = new \JsonSchema\Validator();
            $schemaPath = $this->fileLocator->locate('@LocationsBundle/Resources/schema/input.json');
            $schema = json_decode(file_get_contents($schemaPath));

            $validator->validate($data, $schema);
            if (!$validator->isValid()) {
                $errors = $validator->getErrors();
                throw new MalformedJsonException($this->getValidatorErrorMessage($errors));
            }

        } catch (\Exception $e) {

        }
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