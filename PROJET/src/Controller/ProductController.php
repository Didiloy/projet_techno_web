<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/product', name: 'app')]

class ProductController extends AbstractController
{
    #[Route('/list', name: '_product_list')]
    public function index(Request $request): Response
    {
        //Dummy datas
        $args = [];
        $args["products"] = [];
        for ($i = 0; $i < 4; $i++) {
            $product = new Product();
            $product->setPrix($i*5.5);
            $product->setName("produit " . $i);
            $product->setQuantity($i);
            array_push($args["products"], $product);
        }
        return $this->render('products/productList.html.twig', $args);
    }

    #[Route('/create', name: '_product_create')]
    public function index2(Request $request, EntityManagerInterface $em): Response
    {
        $args = [];
        $args["titre"] = "Create";

        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);
        //si on recoit le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $productRepo = $em->getRepository(Product::class);
            $productRepo->save($product);
            $em->flush();

            return $this->redirectToRoute('app_home', $args);
        }

        $args["form"] = $form;

        return $this->render('user/userForm.html.twig', $args);
    }
}
