
Installation
------------
* composer require  composer require anton-kozlov/locations

Usage example:
----------
    class DefaultController extends Controller
    {
        /**
         * @Route("/test")
         */
        public function pushAction(
            \Test\LocationsBundle\Service\DataProviderService $dataProviderService
        )
        {
            try {
                $locations = $dataProviderService->getLocations('example.com');
            } catch (\Test\LocationsBundle\Exception\LocationsExceptionInterface $exception) {
                // Handle exceptions...
            }
        }
        