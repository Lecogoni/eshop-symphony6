<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);
        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
