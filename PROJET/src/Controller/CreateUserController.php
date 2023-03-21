<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController extends AbstractController
{
    #[Route('/create', name: 'app_create_user')]
    public function index(Request $request): Response
    {
        $type = ['client', 'admin', 'super-admin'];
        $user_type = $request->request->get('user_type');
        $args = [];
//        Si le client n'est pas authentifié
//        if (is_null($user_type) || in_array($user_type, $type)) {
//            $args["type"] =  "unidentified";
//            return $this->render("base.html.twig", $args);
//        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $args["type"] = $user_type;
        $args["form"] = $form;

        return $this->render('user/create.html.twig', $args);
    }
}
