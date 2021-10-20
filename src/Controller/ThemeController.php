<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Note;
use App\Entity\Theme;
use App\Form\ThemeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    #[Route('/themes', name: 'theme_list')]
    public function listTheme(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $themes = $em->getRepository(Theme::class)->findAll();

        return $this->render('theme/list.html.twig', [
            'themes' => $themes
        ]);
    }

    #[Route('/themes/add', name: 'theme_add')]
    public function addTheme(Request $request): Response
    {
        $theme = new Theme();
        $form = $this->createForm(ThemeFormType::class, $theme);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $theme = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($theme);
            $em->flush();

            return $this->redirectToRoute('theme_list');
        }

        return $this->renderForm('theme/create.html.twig', [
            'form_theme' => $form
        ]);
    }

    #[Route('/themes/{id}', name: 'idea_list')]
    public function listIdea(string $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository(Theme::class)->findOneById($id);

        return $this->render('theme/ideas.html.twig', [
            'theme' => $theme
        ]);
    }
}
