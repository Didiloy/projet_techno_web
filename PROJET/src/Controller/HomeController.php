<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser()  ;
        if ($user !== null)dump($user);

        $args = [];
//        Si le client n'est pas authentifié
        if (is_null($user)) {
            $args["type"] =  "unidentified";
            return $this->render("home/home.html.twig", $args);
        }

        $args["type"] =  $user->getRoles()[0];
        return $this->render("home/home.html.twig", $args);
    }

}
