<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectUserType;
use App\Form\CreateUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'app')]
class UserController extends AbstractController
{
    #[Route('/create', name: '_create_user')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $args = [];
        $args["titre"] = "Create";

        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);

        $form->handleRequest($request);
        //si on recoit le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepo = $em->getRepository(User::class);
            $userRepo->save($user);
            $em->flush();

            return $this->redirectToRoute('app_home', $args);
        }

        $args["form"] = $form;

        return $this->render('user/userForm.html.twig', $args);
    }

    #[Route('/connect', name: '_connect_user')]
    public function index2(Request $request, EntityManagerInterface $em): Response
    {
        $args = [];
        $args["titre"] = "Connect";
//        Si le client n'est pas authentifié
        $userForm = new User();
        $form = $this->createForm(ConnectUserType::class, $userForm);

        $form->handleRequest($request);
        //si on recoit le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $userForm = $form->getData();
            $userRepo = $em->getRepository(User::class);
            $user = $userRepo->findBy(['name'=> $userForm->getName()]);
            if(is_null($user)){
                //gerer l'erreur
            }

            return $this->redirectToRoute('app_home', $args);
        }

        $args["form"] = $form;
        return $this->render('user/userForm.html.twig', $args);
    }
}
