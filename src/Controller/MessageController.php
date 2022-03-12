<?php

namespace App\Controller;

use App\Entity\Entrada;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\Mensaje;
use App\Entity\Usuarios;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mime\Message;

class MessageController extends AbstractController
{
    function getAllMessages(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $mensajes =  $entityManager->getRepository(Mensaje::class)->findAll();

        if ($mensajes == null) {
            return new JsonResponse([
                'error' => 'No messages found'
            ], 404);
        }

        $results  = new \stdClass();
        $results->count = count($mensajes);
        $results->results = array();

        foreach ($mensajes as $mensaje) {
            $result = new \stdClass();
            $result->id = $mensaje->getId();
            $result->contenido = $mensaje->getContenido();
            $result->fecha = $mensaje->getFecha();
            $result->usuario = $mensaje->getUsuario()->getUsuario();
            $result->entrada = $this->generateUrl(
                'api_get_entrada',
                ['id' => $mensaje->getEntrada()->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            array_push($results->results, $result);
        }

        return new JsonResponse($results, 200);
    }

    function getMessage(ManagerRegistry $doctrine, $id)
    {
        $entityManager = $doctrine->getManager();
        $mensaje =  $entityManager->getRepository(Mensaje::class)->findOneBy(['id' => $id]);

        if ($mensaje == null) {
            return new JsonResponse([
                'error' => 'Message not found'
            ], 404);
        }

        $result = new \stdClass();
        $result->id = $mensaje->getId();
        $result->contenido = $mensaje->getContenido();
        $result->fecha = $mensaje->getFecha();
        $result->usuario = $mensaje->getUsuario()->getUsuario();
        $result->entrada = $this->generateUrl(
            'api_get_entrada',
            ['id' => $mensaje->getEntrada()->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($result, 200);
    }

    function postMessage(ManagerRegistry $doctrine, Request $request)
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(Usuarios::class)->find($request->request->get("usuario"));
        $entry = $entityManager->getRepository(Entrada::class)->find($request->request->get("entrada"));

        if ($user == null) {
            return new JsonResponse([
                'error' => 'User (to post message) not found'
            ], 404);
        }

        if ($entry == null) {
            return new JsonResponse([
                'error' => 'Entry (wherein to post message) not found'
            ], 404);
        }

        $fecha = new \DateTime('now');

        $mensaje = new Mensaje();
        $mensaje->setUsuario($user);
        $mensaje->setEntrada($entry);
        $mensaje->setContenido($request->request->get("contenido"));
        $mensaje->setFecha($fecha->format('Y-m-d-H-i-s'));

        $entityManager->persist($mensaje);
        $entityManager->flush();

        $result = new \stdClass();
        $result->contenido = $mensaje->getContenido();
        $result->entrada = $mensaje->getEntrada()->getTitulo();
        $result->fecha = $mensaje->getFecha();
        $result->usuario = $user->getUsuario();
        $result->entrada = $this->generateUrl(
            'api_get_entrada',
            ['id' => $mensaje->getEntrada()->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($result, 201);
    }

    function putMessage(ManagerRegistry $doctrine, Request $request, $id)
    {
        $entityManager = $doctrine->getManager();
        $mensaje =  $entityManager->getRepository(Mensaje::class)->findOneBy(['id' => $id]);

        if ($mensaje == null) {
            return new JsonResponse([
                'error' => 'Message not found'
            ], 404);
        }

        $fecha = new \DateTime('now');

        $mensaje->setContenido($request->request->get("contenido"));
        $mensaje->setFecha($fecha->format('Y-m-d-H-i-s'));

        $entityManager->flush();

        $result = new \stdClass();
        $result->contenido = $mensaje->getContenido();
        $result->fecha = $mensaje->getFecha();
        $result->usuario = $mensaje->getUsuario()->getUsuario();
        $result->entrada = $this->generateUrl(
            'api_get_entrada',
            ['id' => $mensaje->getEntrada()->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
        return new JsonResponse($result, 200);
    }

    function deleteMessage(ManagerRegistry $doctrine, $id)
    {
        $entityManager = $doctrine->getManager();
        $mensaje = $entityManager->getRepository(Mensaje::class)->findOneBy(['id' => $id]);
        if ($mensaje == null) {
            return new JsonResponse([
                'error' => 'Mesagge not found'
            ], 404);
        }

        $entityManager->remove($mensaje);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }
}
