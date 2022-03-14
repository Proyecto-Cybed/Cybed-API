<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Entrada;
use App\Entity\Usuarios;
use Doctrine\Persistence\ManagerRegistry;


class EntryController extends AbstractController
{

    function getAllEntries(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $entradas =  $entityManager->getRepository(Entrada::class)->findAll();

        if ($entradas == null) {
            return new JsonResponse([
                'error' => 'No entries found'
            ], 404);
        }

        $results  = new \stdClass();
        $results->count = count($entradas);
        $results->results = array();

        foreach ($entradas as $entrada) {
            $result = new \stdClass();
            $result->id = $entrada->getId();
            $result->titulo = $entrada->getTitulo();
            $result->contenido = $entrada->getContenido();
            $result->fecha = $entrada->getFecha();
            $result->usuario = $entrada->getUsuario()->getUsuario();

            $result->mensajes = new \stdClass();
            $result->mensajes->count = count($entrada->getMensajes());
            $result->mensajes->results = array();

            foreach ($entrada->getMensajes() as $mensaje) {
                $msgResult = new \stdClass();
                $msgResult->id = $mensaje->getId();
                $msgResult->contenido = $mensaje->getContenido();
                $msgResult->fecha = $mensaje->getFecha();
                $msgResult->usuario = $mensaje->getUsuario()->getUsuario();

                array_push($result->mensajes->results, $msgResult);
            }

            array_push($results->results, $result);
        }

        return new JsonResponse($results, 200);
    }

    function getEntry(ManagerRegistry $doctrine, $id)
    {
        $entityManager = $doctrine->getManager();
        $entrada =  $entityManager->getRepository(Entrada::class)->findOneBy(['id' => $id]);

        if ($entrada == null) {
            return new JsonResponse([
                'error' => 'Entry not found'
            ], 404);
        }

        $result = new \stdClass();
        $result->id = $entrada->getId();
        $result->titulo = $entrada->getTitulo();
        $result->contenido = $entrada->getContenido();
        $result->fecha = $entrada->getFecha();
        $result->usuario = $entrada->getUsuario()->getUsuario();

        $result->mensajes = new \stdClass();
        $result->mensajes->count = count($entrada->getMensajes());
        $result->mensajes->results = array();

        foreach ($entrada->getMensajes() as $mensaje) {
            $msgResult = new \stdClass();
            $msgResult->id = $mensaje->getId();
            $msgResult->contenido = $mensaje->getContenido();
            $msgResult->fecha = $mensaje->getFecha();
            $msgResult->usuario = $mensaje->getUsuario()->getUsuario();

            array_push($result->mensajes->results, $msgResult);
        }

        return new JsonResponse($result, 200);
    }

    function postEntry(ManagerRegistry $doctrine, Request $request)
    {

        $entityManager = $doctrine->getManager();
        $user =  $entityManager->getRepository(Usuarios::class)->findOneBy(['id' => $request->request->get("usuario")]);
        if ($user == null) {
            $user =  $entityManager->getRepository(Usuarios::class)->findOneBy(['usuario' => $request->request->get("usuario")]);
        }

        if ($user == null) {
            return new JsonResponse([
                'error' => 'User (to post entry) not found'
            ], 404);
        }

        $fecha = new \DateTime('now');

        $entrada = new Entrada();
        $entrada->setUsuario($user);
        $entrada->setTitulo($request->request->get("titulo"));
        $entrada->setContenido($request->request->get("contenido"));
        $entrada->setFecha($fecha->format('Y-m-d-H-i-s'));

        $entityManager->persist($entrada);
        $entityManager->flush();

        $result = new \stdClass();
        $result->titulo = $entrada->getTitulo();
        $result->contenido = $entrada->getContenido();
        $result->fecha = $entrada->getFecha();
        $result->usuario = $user->getUsuario();

        return new JsonResponse($result, 201);
    }

    function putEntry(ManagerRegistry $doctrine, Request $request, $id)
    {

        $entityManager = $doctrine->getManager();
        $entrada =  $entityManager->getRepository(Entrada::class)->findOneBy(['id' => $id]);

        if ($entrada == null) {
            return new JsonResponse([
                'error' => 'Entry not found'
            ], 404);
        }

        $fecha = new \DateTime('now');

        $entrada->setTitulo($request->request->get("titulo"));
        $entrada->setContenido($request->request->get("contenido"));
        $entrada->setFecha($fecha->format('Y-m-d-H-i-s'));

        $entityManager->flush();

        $result = new \stdClass();
        $result->titulo = $entrada->getTitulo();
        $result->contenido = $entrada->getContenido();
        $result->fecha = $entrada->getFecha();
        $result->usuario = $entrada->getUsuario()->getUsuario();

        return new JsonResponse($result, 200);
    }

    function deleteEntry(ManagerRegistry $doctrine, $id)
    {
        $entityManager = $doctrine->getManager();
        $entrada = $entityManager->getRepository(Entrada::class)->findOneBy(['id' => $id]);
        if ($entrada == null) {
            return new JsonResponse([
                'error' => 'Entry not found'
            ], 404);
        }

        $entityManager->remove($entrada);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }
}
