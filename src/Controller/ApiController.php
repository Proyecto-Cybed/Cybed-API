<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Usuarios;
use Doctrine\ORM\EntityManagerInterface;


class ApiController extends AbstractController{

   

    function postCybedUser(EntityManagerInterface $em , Request $request) {
        
        $user =  $em->getRepository(Usuarios::class)->findOneBy(['email' => $request->request->get("email")]);
        if ($user) {
        return new JsonResponse([
            'error' => 'UserName already exists'
        ], 409);
        }
        $user = new Usuarios();
        $user->setUsuario($request->request->get("usuario"));
        $user->setNombre($request->request->get("nombre"));
        $user->setApellidos($request->request->get("apellidos"));
        $user->setEmail($request->request->get("email"));
        $user->setPassword($request->request->get("password"));

        $em->persist($user);
        $em->flush();
        $result = new \stdClass();
        $result->usuario = $user->getUsuario();
        $result->email = $user->getEmail();
        return new JsonResponse($result, 201);
    }
}