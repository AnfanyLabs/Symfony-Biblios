<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/book')]
final class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book_index')]
    public function index(): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/new', name: 'app_admin_book_new')]
    public function new(Request $request, EntityManagerInterface $entityManager):Response{
        
        $book = new Book;
        
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_book_index');
        }

        return $this->render('admin/book/new.html.twig',[
            'form' =>$form
        ]);
    }
}
