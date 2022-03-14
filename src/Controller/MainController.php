<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class MainController extends AbstractController
{

    function index()
    {

        return $this->render('swagger.html.twig');
    }

    function apiIndex()
    {
        $result = array();
        $result['users'] = $this->generateUrl(
            'api_get_usuarios',
            array(),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $result['entries'] = $this->generateUrl(
            'api_get_entradas',
            array(),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $result['messages'] = $this->generateUrl(
            'api_get_mensajes',
            array(),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $result['cves'] = $this->generateUrl(
            'nvd_get_cves',
            array(),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($result);
    }
}
