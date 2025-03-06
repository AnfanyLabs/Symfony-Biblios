<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin/editor')]

final class EditorController extends AbstractController
{
    #[Route(' ', name: 'app_admin_editor_index')]
    public function index(): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
        ]);
    }

    /**
     * Create a new editor
     */
    #[Route('/new', name: 'app_admin_editor_new')]
    public function new(Request $request, EntityManagerInterface $entityManager):Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($editor);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_editor_index');
        }
        return $this->render('admin/editor/new.html.twig',[
         'form' => $form    
        ]);
    }
}
