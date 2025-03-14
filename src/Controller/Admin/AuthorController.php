<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin/author')]

final class AuthorController extends AbstractController
{
    #[Route('', name: 'app_admin_author_index')]
    public function index(Request $request, AuthorRepository $authorRepository): Response
    {
        $dates = [];
        if($request->query->has('neLe')){
            $dates['neLe'] = $request->query->get('neLe');
        }
        if($request->query->has('mortLe')){
            $dates['mortLe'] = $request->query->get('mortLe');
        }

        $authors = $authorRepository->findByDateOfBirth($dates);


        return $this->render('admin/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }


    /**
     * Create a new author
     */
    #[Route('/new', name: 'app_admin_author_new', methods:['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager):Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->persist($author);
           $entityManager->flush();
           return $this->redirectToRoute('app_admin_author_index');
        }


        return $this->render('/admin/author/new.html.twig', [
           'form' =>$form,
        ]);
    }


    #[Route('/{id}', name: 'app_admin_author_show', methods:['GET'])]
    public function show( Author $author){
        return $this->render('/admin/author/show.html.twig',[
            'author'  => $author,
        ]);
    }

    
}
