<?php

namespace App\Controller;

use App\Entity\Matter;
use App\Form\MatterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/matter')]
class MatterController extends AbstractController
{
    #[Route('/', name: 'app_matter')]
    public function index(EntityManagerInterface $em, Request $r, TranslatorInterface $translator): Response
    {
        $matter = new Matter();
        $form = $this->createForm(MatterType::class, $matter);
        $form->handleRequest($r);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($matter);
            $em->flush();
            $this->addFlash('success', $translator->trans('matter.added'));
            return $this->redirectToRoute('app_matter');
        }

        $matters = $em->getRepository(Matter::class)->findAll();

        return $this->render('matter/index.html.twig', [
            'controller_name' => 'MatterController',
            'matters' => $matters,
            'add' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_matter_show')]
    public function show(EntityManagerInterface $em, Request $r, Matter $matter = null): Response
    {
        if (!$matter) {
            $this->addFlash('danger', 'Matière introuvable');
            return $this->redirectToRoute('app_matter');
        }

        $form = $this->createForm(MatterType::class, $matter);
        $form->handleRequest($r);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($matter);
            $em->flush();
            $this->addFlash('success', 'Matière modifiée');
            // return $this->redirectToRoute('app_matter');
        }

        return $this->render('matter/show.html.twig', [
            'matter' => $matter,
            'edit' => $form->createView(),
        ]);
    }
}
