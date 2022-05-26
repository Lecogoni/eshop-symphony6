<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart, ProductRepository $ProductRepository )
    {
        $cartProduct = [];

        foreach ($cart->get() as $id => $quantity)
        {
            $cartProduct[] = [
                'product' => $ProductRepository->find($id),
                'quantity' => $quantity
            ];
        }

        if (count($cartProduct) > 0)
        {
            return $this->render('cart/index.html.twig', [
                'cart' => $cartProduct
            ]);
        } else {
            return $this->redirectToRoute('app_products');
        }
    }
    
    /**
     * add to cart
     */
    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add(Cart $cart,  $id)
    {
        // pour garder notre controller light on va utiliser notre Classe/cart afin de 
        // créer nos method et alléger le code de notre controleur
        // ce fichier sert de repository - juste notre cart n'a pas de entity pas persisté mais stocker en session
        
        $cart->add($id);
        // pour que cela marche on doit injecter dans notre controller notre classe cart 
        return $this->redirectToRoute('app_cart');
    }

     /**
     * remove cart
     */
    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('app_products');
    }

     /**
     * delte one product in cart by its id
     */
    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }

}