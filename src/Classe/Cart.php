<?php
# class créer pour la mécanique de filter sur les products

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    /**
     * add to cart
     * params : product id
     */
    public function add($id)
    {
        $session = $this->requestStack->getSession();

        // stock our cart or empty array if it doens't exist
        $cart = $session->get('cart', []);

        if (!array_key_exists($id, $cart)) 
        {
            $cart[$id] = 1;
        } else {
            $cart[$id]++ ;
        }

        $session->set('cart', $cart);
    }

    /**
     * get cart
     */
    public function get()
    {
        $session = $this->requestStack->getSession();
        return $session->get('cart');
    }

    /**
     * remove cart
     */
    public function remove()
    {
        $session = $this->requestStack->getSession();
        return $session->remove('cart');
    }

    /**
     * delete one product in cart by id
     */
    public function delete($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart');
        unset($cart[$id]);
        return $session->set('cart', $cart);
    }
}