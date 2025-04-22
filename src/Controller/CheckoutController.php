<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CheckoutController extends AbstractController {
    #[Route('/checkout/confirm', name: 'app_checkout_confirm')]
    public function confirm(SessionInterface $session): Response
    {
        // Vérifier que l'utilisateur est connecté
        if (!$this->getUser()) {
            $this->addFlash('error', 'Vous devez être connecté pour passer une commande.');
            return $this->redirectToRoute('app_login');
        }
        
        // Récupérer le panier
        $cart = $session->get('cart', []);
        
        if (empty($cart)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('cart_show');
        }
        
        // À ce stade, on pourrait enregistrer des informations minimales si nécessaire
        
        // Vider le panier
        $session->set('cart', []);
        
        $this->addFlash('success', 'Votre commande a été passée avec succès!');
        
        return $this->render('checkout/index.html.twig');
    }
}
