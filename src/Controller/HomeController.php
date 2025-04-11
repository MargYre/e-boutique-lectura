<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }
}