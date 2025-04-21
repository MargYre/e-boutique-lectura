<?php
namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(
        BookRepository $bookRepo,
        CategoryRepository $categoryRepo,
        Request $request
    ): Response {
        $categorySlug = $request->query->get('category');
        
        $books = $categorySlug 
            ? $bookRepo->findBy(['category' => $categoryRepo->findOneBy(['slug' => $categorySlug])])
            : $bookRepo->findAll();

        return $this->render('home/index.html.twig', [
            'books' => $books,
            'categories' => $categoryRepo->findAll(),
            'currentCategory' => $categorySlug
        ]);
    }

    #[Route('/book/{id}', name: 'book_show')]
    public function show(
        Book $book, 
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {
        return $this->render('book/show.html.twig', [
            'book' => $book,
            'categories' => $categoryRepository->findAll(),
            'currentCategory' => null,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function addToCart(
        Book $book,
        SessionInterface $session,
        Request $request
    ): Response {
        $cart = $session->get('cart', []);

        $id = $book->getId();
        if (!empty($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'book' => $book,
                'quantity' => 1
            ];
        }

        $session->set('cart', $cart);

        $this->addFlash('success', 'Le livre a été ajouté au panier');

        // Rediriger vers la page précédente ou la page du panier
        return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('homepage'));
    }

    #[Route('/cart', name: 'cart_show')]
    public function showCart(
        SessionInterface $session,
        CategoryRepository $categoryRepository
    ): Response {
        $cart = $session->get('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['book']->getPrice() * $item['quantity'];
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'categories' => $categoryRepository->findAll(),
            'currentCategory' => null,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function removeFromCart(
        Book $book,
        SessionInterface $session
    ): Response {
        $cart = $session->get('cart', []);
        $id = $book->getId();

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        $this->addFlash('success', 'Le livre a été retiré du panier');

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/update/{id}', name: 'cart_update')]
    public function updateCart(
        Book $book,
        Request $request,
        SessionInterface $session
    ): Response {
        $quantity = $request->request->getInt('quantity', 1);
        $cart = $session->get('cart', []);
        $id = $book->getId();

        if ($quantity > 0) {
            $cart[$id]['quantity'] = $quantity;
        } else {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_show');
    }
}