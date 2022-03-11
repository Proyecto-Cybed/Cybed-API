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
                'error' => 'Entries not found'
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
            $result->usuario = $entrada->getUsuario();
            $result->mensajes = $entrada->getMensajes();

            array_push($results->results, $result);
        }

        return new JsonResponse($results, 200);
    }

    function postEntry(ManagerRegistry $doctrine, Request $request)
    {
        
        $entityManager = $doctrine->getManager();

        $entradas =  $entityManager->getRepository(Entrada::class);

        $user = $entityManager->getRepository(Usuarios::class)->find($request->request->get("usuario"));
        if ($user == null) {
            return new JsonResponse([
                'error' => 'User (to post entry) not found'
            ], 404);
        }

        $fecha = new \DateTime('now');
        

        $entradas = new Entrada();
        $entradas->setUsuario($user);
        $entradas->setTitulo($request->request->get("titulo"));
        $entradas->setContenido($request->request->get("contenido"));
        $entradas->setFecha($fecha->format('Y-m-d-H-i-s'));
        

        $entityManager->persist($entradas);
        $entityManager->flush();

        $result = new \stdClass();
        $result->titulo = $entradas->getTitulo();
        $result->contenido = $entradas->getContenido();
        $result->fecha = $entradas->getFecha();
        $result->usuario = $user->getUsuario();
       
     
        return new JsonResponse($result, 201);
    }



    /*
    function getCybedUser(ManagerRegistry $doctrine, $usuario)
    {
        $entityManager = $doctrine->getManager();

        $user =  $entityManager->getRepository(Usuarios::class)->findOneBy(['usuario' => $usuario]);

        if ($user == null) {
            return new JsonResponse([
                'error' => 'User not found'
            ], 404);
        }

        $result = new \stdClass();
        $result->usuario = $user->getUsuario();
        $result->email = $user->getEmail();
        return new JsonResponse($result, 200);
    }

    function postCybedUser(ManagerRegistry $doctrine, Request $request)
    {
        $entityManager = $doctrine->getManager();

        $user =  $entityManager->getRepository(Usuarios::class);

        $user = new Usuarios();
        $user->setUsuario($request->request->get("usuario"));
        $user->setNombre($request->request->get("nombre"));
        $user->setApellidos($request->request->get("apellidos"));
        $user->setEmail($request->request->get("email"));
        $user->setPassword(password_hash($request->request->get("password"), PASSWORD_DEFAULT));

        $entityManager->persist($user);
        $entityManager->flush();
        $result = new \stdClass();
        $result->usuario = $user->getUsuario();
        $result->email = $user->getEmail();
        return new JsonResponse($result, 201);
    }


    function postLoginCybedUser(ManagerRegistry $doctrine, Request $request)
    {
        $entityManager = $doctrine->getManager();

        $userbd =  $entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $request->request->get("email")]);
        

        if ($userbd == null) {
            return new JsonResponse([
                'error' => 'User'
            ], 404);
        }

        $user = new Usuarios();
        $user->setEmail($request->request->get("email"));
        
        

        $result = new \stdClass();
       
        if(!empty($user->getEmail()) and password_verify($request->request->get("password"),$userbd->getPassword())){
            $result->email = $user->getEmail();
            
            return new JsonResponse($result, 201);
        }else{
            return new JsonResponse([
                'error' => 'Login'
            ], 404);
        }
    
    }
    */
}