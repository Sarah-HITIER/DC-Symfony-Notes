<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class NoteController extends AbstractController
{
    #[Route('/', name: 'app_note')]
    public function index(EntityManagerInterface $em, Request $r, TranslatorInterface $translator): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($r);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($note);
            $em->flush();
            $this->addFlash('success', $translator->trans('note.added'));
        }

        $notes = $em->getRepository(Note::class)->findAll();

        return $this->render('note/index.html.twig', [
            'controller_name' => 'NoteController',
            'notes' => $notes,
            'add' => $form->createView(),
        ]);
    }
}
