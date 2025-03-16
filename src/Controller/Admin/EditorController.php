<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin/editor')]

final class EditorController extends AbstractController
{
    #[Route(' ', name: 'app_admin_editor_index')]
    public function index(EditorRepository $editorRepository): Response
    {
        $editors = $editorRepository->findAll();
        return $this->render('admin/editor/index.html.twig', [
            'editors' => $editors,
        ]);
    }

    /**
     * Create a new editor
     */
    #[Route('/new', name: 'app_admin_editor_new')]
    #[Route('/{id}/edit', name:'app_admin_editor_edit',  methods: ['GET', 'POST'],  requirements:['is'=>"\d+"])]

    public function new(? Editor $editor,  Request $request, EntityManagerInterface $entityManager):Response
    {
        $editor ??= new Editor();
        $form = $this->createForm(EditorType::class, $editor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($editor);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_editor_show',['id' => $editor->getId()]);
        }
        return $this->render('admin/editor/new.html.twig',[
         'form' => $form    
        ]);
    }

    #[Route('/{id}', name: 'app_admin_editor_show', requirements:['id'=>'\d+'])]
    public function show( Editor $editor){
        return $this->render('admin/editor/show.html.twig', [
            'editor' => $editor,
        ]);
    }
}
