<?php
namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function show(Book $book, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'categories' => $categories,
            'currentCategory' => null,
        ]);
    }
}