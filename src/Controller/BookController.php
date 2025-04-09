<?php
namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository; // <-- N'oubliez pas ce use !
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(
        BookRepository $bookRepo,
        CategoryRepository $categoryRepo // <-- Injection correcte
    ): Response {
        return $this->render('home/index.html.twig', [
            'books' => $bookRepo->findAll(),
            'categories' => $categoryRepo->findAll(),
        ]);
    }
}