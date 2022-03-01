<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ApiController
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
            'https://services.nvd.nist.gov/rest/json/cves/1.0/'
        );

        $content = $response->getContent();

        $content = $response->toArray();

        return new JsonResponse($content);
    }

    public function getById($id)
    {
        $response = $this->client->request(
            'GET',
            'https://services.nvd.nist.gov/rest/json/cve/1.0/' . $id
        );

        $content = $response->getContent();

        $content = $response->toArray();

        return new JsonResponse($content);
    }
}
