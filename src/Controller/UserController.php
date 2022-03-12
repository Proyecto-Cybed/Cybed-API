<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\Usuarios;
use Doctrine\Persistence\ManagerRegistry;


class UserController extends AbstractController
{

    function getAllCybedUsers(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $users =  $entityManager->getRepository(Usuarios::class)->findAll();

        if ($users == null) {
            return new JsonResponse([
                'error' => 'No users found'
            ], 404);
        }

        $results  = new \stdClass();
        $results->count = count($users);
        $results->results = array();

        foreach ($users as $user) {
            $result = new \stdClass();
            $result->id = $user->getId();
            $result->usuario = $user->getUsuario();
            $result->nombre = $user->getNombre();
            $result->apellidos = $user->getApellidos();
            $result->email = $user->getEmail();
            $result->entradas = array();
            $result->mensajes = array();

            foreach ($user->getEntradas() as $entrada) {
                $result->entradas[] = $this->generateUrl('api_get_entrada', [
                    'id' => $entrada->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL);
            }

            foreach ($user->getMensajes() as $mensaje) {
                $result->mensajes[] = $this->generateUrl('api_get_mensaje', [
                    'id' => $mensaje->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL);
            }

            array_push($results->results, $result);
        }

        return new JsonResponse($results, 200);
    }

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
        $result->id = $user->getId();
        $result->usuario = $user->getUsuario();
        $result->nombre = $user->getNombre();
        $result->apellidos = $user->getApellidos();
        $result->email = $user->getEmail();
        $result->entradas = array();
        $result->mensajes = array();

        foreach ($user->getEntradas() as $entrada) {
            $result->entradas[] = $this->generateUrl('api_get_entradas', [
                'id' => $entrada->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        foreach ($user->getMensajes() as $mensaje) {
            $result->mensajes[] = $this->generateUrl('api_get_mensaje', [
                'id' => $mensaje->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return new JsonResponse($result, 200);
    }

    function postCybedUser(ManagerRegistry $doctrine, Request $request)
    {
        $entityManager = $doctrine->getManager();
        $userByUser = $entityManager->getRepository(Usuarios::class)->findOneBy(['usuario' => $request->request->get("usuario")]);
        $userByEmail = $entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $request->request->get("email")]);

        if ($userByUser || $userByEmail) {
            return new JsonResponse([
                'error' => 'There is already a user with that email or username'
            ], 409);
        }

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
        $result->nombre = $user->getNombre();
        $result->apellidos = $user->getApellidos();
        $result->email = $user->getEmail();
        return new JsonResponse($result, 201);
    }

    function putCybedUser(ManagerRegistry $doctrine, Request $request, $usuario)
    {

        $entityManager = $doctrine->getManager();
        $user =  $entityManager->getRepository(Usuarios::class)->findOneBy(['usuario' => $usuario]);
        $userToPutByUser = $entityManager->getRepository(Usuarios::class)->findOneBy(['usuario' => $request->request->get("usuario")]);
        $userToPutByUser = $entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $request->request->get("email")]);

        if ($user == null) {
            return new JsonResponse([
                'error' => 'User not found'
            ], 404);
        }
        if ($userToPutByUser || $userToPutByUser) {
            return new JsonResponse([
                'error' => 'There is already a user with that email or username'
            ], 409);
        }

        $user->setUsuario($request->request->get("usuario"));
        $user->setNombre($request->request->get("nombre"));
        $user->setApellidos($request->request->get("apellidos"));
        $user->setEmail($request->request->get("email"));
        $user->setPassword(password_hash($request->request->get("password"), PASSWORD_DEFAULT));

        $entityManager->flush();

        $result = new \stdClass();
        $result->usuario = $user->getUsuario();
        $result->nombre = $user->getNombre();
        $result->apellidos = $user->getApellidos();
        $result->email = $user->getEmail();
        return new JsonResponse($result, 200);
    }

    function deleteCybedUser(ManagerRegistry $doctrine, $usuario)
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(Usuarios::class)->findOneBy(['usuario' => $usuario]);
        
        if ($user == null) {
            return new JsonResponse([
                'error' => 'User not found'
            ], 404);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(null, 204);
    }



    /*
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
