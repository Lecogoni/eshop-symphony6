<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/account/address', name: 'app_account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }
    
    /**
     * User add a new expedition addresse
     */
    #[Route('/account/address-new', name: 'app_account_address_add')]
    public function add(Request $request): Response
    {
        // préparation du form
        $addresse = new Address();
        $form = $this->createForm(AddressType::class, $addresse);

        //gestion du form post
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $addresse->setUser($this->getUser()); // attribut le current_user, celui connecté à la nouvelle addresse

            $this->entityManager->persist($addresse); // creation de la requete pour persister le new user
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account/address-form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * update addresse
     */
    #[Route('/account/address-update/{id}', name: 'app_account_address_update')]
    public function update(Request $request, $id): Response
    {
        // on rappatrie l'adresse
        $addresse = $this->entityManager->getRepository(Address::class)->findOneById($id);

        // on vérifie si elle existe et si elle appartient bien a mon user connecté
        if (!$addresse || $addresse->getUSer() != $this->getUSer()){
            return $this->render('account/address.html.twig');
        }
        
        $form = $this->createForm(AddressType::class, $addresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account/address-form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * remove addresse
     */
    #[Route('/account/address-remove/{id}', name: 'app_account_address_remove')]
    public function remove($id): Response
    {
        // on rappatrie l'adresse
        $addresse = $this->entityManager->getRepository(Address::class)->findOneById($id);

        // on vérifie si elle existe et si elle appartient bien a mon user connecté
        if ($addresse && $addresse->getUSer() == $this->getUSer()){
            $this->entityManager->remove($addresse);
            $this->entityManager->flush();
        }
        return $this->render('account/address.html.twig');
    }
}
