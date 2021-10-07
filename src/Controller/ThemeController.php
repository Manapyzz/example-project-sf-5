<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Note;
use App\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/themes/{id}', name: 'idea_list')]
    public function listIdea(string $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository(Theme::class)->findOneById($id);

        return $this->render('theme/ideas.html.twig', [
            'theme' => $theme
        ]);
    }

    #[Route('/themes/add', name: 'theme_add')]
    public function addTheme(): Response
    {
        $theme = new Theme();
        $theme->setName('Musique');

//        $idea1 = new Idea();
//        $idea1->setName('Ping pong sur mer');
//
//        $idea2 = new Idea();
//        $idea2->setName('foot sur l\'espace');
//
//        $today = new \DateTimeImmutable();
//
//        $note1 = new Note();
//        $note1->setContent('lkfaslfkal kafl slkklfa');
//        $note1->setAuthor('Alex');
//        $note1->setCreatedAt($today);
//
//        $note2 = new Note();
//        $note2->setContent('coucou la note 2');
//        $note2->setAuthor('Faker');
//        $note2->setCreatedAt($today);
//
//        $idea1->addNote($note1);
//        $idea2->addNote($note2);
//
//        $theme->addIdea($idea1);
//        $theme->addIdea($idea2);
//
        $em = $this->getDoctrine()->getManager();
//        $em->persist($note1);
//        $em->persist($note2);
//        $em->persist($idea1);
//        $em->persist($idea2);
        $em->persist($theme);

        $em->flush();

        return $this->json('well done');
    }
}
