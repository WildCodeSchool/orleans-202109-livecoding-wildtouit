<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AddressService
{
    public const HTTP_OK = 200;

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getCoordinates(string $address): array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api-adresse.data.gouv.fr/search/',
            [
                'query' => [
                    'q' => $address,
                ],
            ]
        );

        $statusCode = $response->getStatusCode();
        if ($statusCode === self::HTTP_OK) {
            $content = $response->toArray();
            if (!empty($content['features'][0]['geometry']['coordinates'])) {
                return $content['features'][0]['geometry']['coordinates'];
            }
        }

        return [];
    }
}
