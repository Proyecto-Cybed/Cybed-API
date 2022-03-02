<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Usuarios;

use Doctrine\Persistence\ManagerRegistry;


class UserController extends AbstractController{


    /*
    function getCybedUser(ManagerRegistry $doctrine, Request $request, $usuario) {
        
        
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
*/

    function postCybedUser(ManagerRegistry $doctrine , Request $request) {
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

   
    

    
}