<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Usuarios;

use Doctrine\Persistence\ManagerRegistry;


class ApiController extends AbstractController{


    function postCybedUser(ManagerRegistry $doctrine , Request $request) {
        $entityManager = $doctrine->getManager();

        $user =  $entityManager->getRepository(Usuarios::class);
       
        $user = new Usuarios();
        $user->setUsuario($request->query->get("usuario"));
        $user->setNombre($request->query->get("nombre"));
        $user->setApellidos($request->query->get("apellidos"));
        $user->setEmail($request->query->get("email"));
        $user->setPassword(password_hash($request->query->get("password"), PASSWORD_DEFAULT));

        $entityManager->persist($user);
        $entityManager->flush();
        $result = new \stdClass();
        $result->usuario = $user->getUsuario();
        $result->email = $user->getEmail();
        return new JsonResponse($result, 201);
    }

    function postCybedLogin(ManagerRegistry $doctrine , Request $request) {
        $entityManager = $doctrine->getManager();

        $user =  $entityManager->getRepository(Usuarios::class)->findBy(['usuario' => $request->request->get("usuario")]);
        if ($user) {
            return new JsonResponse([
                'ok' => 'ok'
            ], 201);
            }
        
        $result = "prueba";
       
        return new JsonResponse($result, 201);
    }
    

    
}