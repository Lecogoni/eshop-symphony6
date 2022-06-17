<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

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

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(), 
            'cart' => $cart->getCartAndProducts()
        ]);
    }

    #[Route('/order/summary', name: 'app_order_summary', methods: ['POST'])] // specify the method to control origin, avoid someone to access en GET
    public function add(Request $request, Cart $cart): Response
    {

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser() // send as params the current user to the form in order top filter / display only current user address
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $date = new DateTime();
            $carrier = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            if($delivery->getCompany())
            {
                $delivery_content .= '</br>'.$delivery->getCompany();
            }
            $delivery_content .= '</br>'.$delivery->getAddress();
            $delivery_content .= '</br>'.$delivery->getPostal().' '.$delivery->getCity().' '.$delivery->getCountry();
            $delivery_content .= '</br>'.$delivery->getPhone();
            
            $order = new Order(); 

            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carrier->getName());
            $order->setCarrierPrice($carrier->getPrice());
            $order->setDelivery($delivery);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            /**
             * Get info on each product in cart - each time create a new OrderDetails
             */
            foreach ($cart->getCartAndProducts() as $product)
            {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $this->entityManager->persist($orderDetails);
            }

            //persist data Order and all OrderDetails
            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getCartAndProducts(), 
                'carrier' => $carrier,
                'delivery' => $delivery_content
            ]);

        }

        return $this->redirectToRoute('app_cart');

    }

}
