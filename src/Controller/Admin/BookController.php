<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/book')]
final class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book_index')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('admin/book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/new', name: 'app_admin_book_new')]
    #[Route('/{id}/edit', name:'app_admin_book_edit', methods:['GET', 'POST'], requirements:['id'=>"\d+"])]
    public function new(?Book $book,  Request $request, EntityManagerInterface $entityManager):Response{
        
        $book ??= new Book;
        
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_book_show', ['id'=>$book->getId()]);
        }

        return $this->render('admin/book/new.html.twig',[
            'form' =>$form
        ]);
    }

    #[Route('/{id}', name:'app_admin_book_show', requirements:['id'=>'\d+'])]
    public function show(Book $book):Response{
       return $this->render('admin/book/show.html.twig', [
        'book' => $book,
       ]);
    }
}
