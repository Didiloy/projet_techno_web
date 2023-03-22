<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        //$user = $this->getUser()  ;
        //if ($user !== null)
        $id = $this->getParameter('monid');
        $userRepo = $em->getRepository(User::class);
        $user = $userRepo->find($id);
        //if ($user !== null)



        $type = ['client', 'admin', 'super-admin'];
        $user_type = $request->request->get('user_type');
        $args = [];
//        Si le client n'est pas authentifié
        if (is_null($user_type) || in_array($user_type, $type)) {
            $args["type"] =  "unidentified";
            return $this->render("base.html.twig", $args);
        }

        $args["type"] =  $user_type;
        dump($request->request->get('user'));
        return $this->render("base.html.twig", $args);
    }

}
