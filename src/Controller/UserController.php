<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Usuarios;

use Doctrine\Persistence\ManagerRegistry;


class UserController extends AbstractController{


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

   
    

    
}