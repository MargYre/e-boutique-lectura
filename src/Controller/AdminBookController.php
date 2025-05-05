<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/book', name: 'admin_book_')]
final class AdminBookController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('admin_book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $book = new Book();
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('imageFile')->getData();
        
        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            
            // Déplacez le fichier dans le dossier public/uploads
            $imageFile->move(
                $this->getParameter('kernel.project_dir').'/public/uploads',
                $newFilename
            );
            
            // Enregistrez le nom du fichier dans l'entité
            $book->setImageName($newFilename);
        }

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('admin_book_index');
    }

    return $this->render('admin_book/new.html.twig', [
        'book' => $book,
        'form' => $form->createView(),
    ]);
}

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('imageFile')->getData();
        
        if ($imageFile) {
            // Supprimez l'ancienne image si elle existe
            if ($book->getImageName()) {
                $oldImage = $this->getParameter('kernel.project_dir').'/public/uploads/'.$book->getImageName();
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('kernel.project_dir').'/public/uploads',
                $newFilename
            );
            $book->setImageName($newFilename);
        }

        $entityManager->flush();

        return $this->redirectToRoute('admin_book_index');
    }

    return $this->render('admin_book/edit.html.twig', [
        'book' => $book,
        'form' => $form->createView(),
    ]);
}

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request, 
        Book $book, 
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('success', 'Le livre a été supprimé.');
        }

        return $this->redirectToRoute('admin_book_index');
    }
}