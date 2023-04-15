<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(Request $r, EntityManagerInterface $em): Response
    {
        $args = [];
        //get all the carts of the user
        $carts = $this->getUser()->getCart();

        //get all the products of all the carts of the user
        $productsInCart = [];
        foreach ($carts as $c) {
            $product = $em->getRepository(Product::class)->find($c->getIdProduct());
            $productsInCart[] = array("product" =>$product, "quantity" => $c->getQuantity());
        }
        $args["productsInCart"] = $productsInCart;

        return $this->render('cart/cart.html.twig', $args);
    }
}
