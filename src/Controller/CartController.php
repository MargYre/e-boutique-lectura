<?php
// src/Controller/CartController.php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_show')]
    public function show(
        SessionInterface $session,
        BookRepository $bookRepository,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {
        $cart = $session->get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $book = $bookRepository->find($id);
            if ($book) {
                $cartItems[$id] = [
                    'book' => $book,
                    'quantity' => $item['quantity']
                ];
                $subtotal += $book->getPrice() * $item['quantity'];
            }
        }
        if ($request->isMethod('POST')) {
            $deliveryOption = $request->request->get('delivery_option', 'home');
            $session->set('delivery_option', $deliveryOption);
            return $this->redirectToRoute('cart_show');
        }
        $deliveryOption = $session->get('delivery_option', 'home');
        $deliveryCost = $deliveryOption === 'relay' ? 3.50 : 5.90;
        $total = $subtotal + $deliveryCost;

        return $this->render('cart/index.html.twig', [
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'delivery_cost' => $deliveryCost,
            'delivery_option' => $deliveryOption,
            'total' => $total,
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(
        int $id,
        BookRepository $bookRepository,
        SessionInterface $session,
        Request $request
    ): Response {
        $book = $bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé');
        }

        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = ['quantity' => 1];
        }

        $session->set('cart', $cart);
        $this->addFlash('success', 'Le livre a été ajouté au panier');

        return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('homepage'));
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(
        int $id,
        SessionInterface $session
    ): Response {
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $session->set('cart', $cart);
            $this->addFlash('success', 'Le livre a été retiré du panier');
        }

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/update/{id}', name: 'cart_update')]
    public function update(
        int $id,
        Request $request,
        SessionInterface $session
    ): Response {
        $quantity = $request->request->getInt('quantity', 1);
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
            } else {
                unset($cart[$id]);
            }
            $session->set('cart', $cart);
        }

        return $this->redirectToRoute('cart_show');
    }
}