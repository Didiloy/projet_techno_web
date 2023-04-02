<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectUserType;
use App\Form\CreateUserType;
use App\Form\ModifyUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/user', name: 'app')]
class UserController extends AbstractController
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
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
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_CLIENT']);
            $userRepo = $em->getRepository(User::class);
            $userRepo->save($user);
            $em->flush();

            return $this->redirectToRoute('app_home', $args);
        }

        $args["form"] = $form;

        return $this->render('user/userForm.html.twig', $args);
    }

    #[Route('/modify', name: '_modify_user')]
    public function index2(Request $request, EntityManagerInterface $em): Response
    {
        $args = [];
        $args["titre"] = "Modify";

        $currentUser = $this->getUser();
        $user = new User();
        $form = $this->createForm(ModifyUserType::class, $currentUser);

        $form->handleRequest($request);
        //si on recoit le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $modifiedUser = $em->find(User::class, $currentUser->getId());
            $modifiedUser->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $modifiedUser->setUsername($user->getUsername());
            $modifiedUser->setBirthdate($user->getBirthdate());

            $userRepo = $em->getRepository(User::class);
            $userRepo->save($modifiedUser);
            $em->flush();

            if($currentUser->getRoles()[0] == "ROLE_CLIENT"){
                return $this->redirectToRoute('app_product', $args);
            }
            return $this->redirectToRoute('app_home', $args);
        }

        $args["form"] = $form;

        return $this->render('user/userForm.html.twig', $args);
    }
}
