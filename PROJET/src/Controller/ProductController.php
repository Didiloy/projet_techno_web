<?php

namespace App\Controller;

use App\Entity\Cart;
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
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $args = [];
        //get all products
        $records = $em->getRepository(Product::class)->findAll();
        $args["products"] = $records;
        $args["quantitiesInCart"] = $this->howMuchProductInCart();
        //verify if a post form has been received to add the product to the cart
        if ($request->isMethod('POST') && $request->request->get("quantity") != 0) {
            $this->addProductToCart($request, $em);
        }
        return $this->render('products/productList.html.twig', $args);
    }

    public function addProductToCart(Request $r, EntityManagerInterface $em)
    {
        $product = $em->getRepository(Product::class)->find($r->request->get('id'));
        //verify if the user already have a cart with the same product to change the quantity instead of adding a new cart
        $carts = $this->getUser()->getCart();
        $modified = false;
        foreach ($carts as $c) {
            if ($c->getIdProduct()->getId() == $product->getId()) {
                $c->setQuantity($c->getQuantity() + $r->request->get('quantity'));
                $em->persist($c);
                $em->flush();
                $modified = true;
            }
        }
        if (!$modified) {
            //create a new cart and add the user and the product to the cart
            $cart = new Cart();
            $cart->setIdUser($this->getUser());
            $cart->setIdProduct($product);
            $cart->setQuantity($r->request->get('quantity'));
            $this->getUser()->addCart($cart);
            $em->persist($cart);
            $em->flush();
        }

        //update the quantity in the database
        $product->setQuantity($product->getQuantity() - $r->request->get('quantity'));
    }

    public function howMuchProductInCart(): array
    {
        //create an associative array containing the id of the products in the cart and the quantity of each product
        $carts = $this->getUser()->getCart();
        $products = [];
        foreach ($carts as $c) {
            $products[$c->getIdProduct()->getId()] = $c->getQuantity();
        }
        return $products;
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
            $this->addFlash(
                'notice',
                'Le produit a bien été ajouté!'
            );
            return $this->redirectToRoute('app_home', $args);
        }

        $args["form"] = $form;

        return $this->render('user/userForm.html.twig', $args);
    }
}
