<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(Request $request, Cart $cart): Response
    {
        // check first if currect user has addresse if not  redrect to page to create one
        if (!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('app_account_address_add');
        } 

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser() // send as params the current user to the form in order top filter / display only current user address
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            dd($form->getData());
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(), 
            'cart' => $cart->getCartAndProducts()
        ]);
    }
}
