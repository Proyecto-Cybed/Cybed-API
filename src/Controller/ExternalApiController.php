<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class ExternalApiController
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getAll()
    {
        $response = $this->client->request(
            'GET',
            'https://services.nvd.nist.gov/rest/json/cves/1.0/?resultsPerPage=50',
        );

        $content[] = $response->getContent();

        $content = $response->toArray();

        $result = $content["result"]["CVE_Items"];

        return new JsonResponse($result);
    }

    public function getById($id)
    {
        $response = $this->client->request(
            'GET',
            'https://services.nvd.nist.gov/rest/json/cve/1.0/' . $id
        );

        $content = $response->getContent();

        $content = $response->toArray();

        $result = $content["result"]["CVE_Items"];

        return new JsonResponse($result);
    }
}