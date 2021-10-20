<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Theme;
use App\Form\IdeaFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends AbstractController
{
    #[Route('/ideas/create/{themeId}', name: 'create_idea')]
    public function createIdea(string $themeId, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository(Theme::class)->find($themeId);

        if (empty($theme)) {
            return $this->redirectToRoute('theme_list');
        }

        $idea = new Idea();
        $form = $this->createForm(IdeaFormType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $idea = $form->getData();
            $idea->addTheme($theme);

            $em->persist($idea);
            $em->flush();

            return $this->redirectToRoute('idea_list', ['id' => $theme->getId()]);
        }

        return $this->renderForm('idea/create.html.twig', [
            'theme' => $theme,
            'form_idea' => $form
        ]);
    }
}
