<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[Route('/product', name: 'app_product')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}
