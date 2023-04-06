<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
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
}
