<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController {
    #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request): Response {
        if (empty($this->getUser()->getCart())) {
            $this->addFlash('warning', 'Votre panier est vide');
            return $this->redirectToRoute('cart_show');
        }
        
        $cart = $this->getUser()->getCart();        
        
        // Calcul du sous-total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['book']->getPrice() * $item['quantity'];
        }
        
        // Calcul du frais de livraison
        $deliveryOption = $request->request->get('delivery_option', 'home');
        $deliveryCost = $deliveryOption === 'relay' ? 3.50 : 5.90;
        $total = $subtotal + $deliveryCost;
    }
}
