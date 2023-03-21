<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController extends AbstractController
{
    #[Route('/create', name: 'app_create_user')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $type = ['client', 'admin', 'super-admin'];
        $user_type = $request->request->get('user_type');
        $args = [];
//        Si le client n'est pas authentifié
//        if (is_null($user_type) || in_array($user_type, $type)) {
//            $args["type"] =  "unidentified";
//            return $this->render("base.html.twig", $args);
//        }
        $args["type"] = $user_type;

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        //si on recoit le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepo = $em->getRepository(User::class);
            $userRepo->save($user);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        $args["form"] = $form;

        return $this->render('user/create.html.twig', $args);
    }
}
