<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[Route('/products', name: 'app_products')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {    
            // pas besoin de faire un form->getData, car $search est déjà passé à notre form
            // on peut direct utiliser $search pour query l'entity 
            // on définit une nouvelle method findWithSearch que l'on défini dans le repository
            $products = $doctrine->getRepository(Product::class)->findWithSearch($search);
        } else 
        {
            $products = $doctrine->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * show one product find by its slug get from url param slug
     */
    #[Route('/product/{slug}', name: 'app_product')]
    public function show(ManagerRegistry $doctrine, $slug): Response
    {
        // query find one product by its slug
        $product = $doctrine->getRepository(Product::class)->findOneBy(['slug' =>  $slug]);
        
        // if products isn't find send to page with all products
        if (!$product) {
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
