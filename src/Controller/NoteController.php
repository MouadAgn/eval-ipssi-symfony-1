<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Form\NotePageType;
use App\Entity\Matieres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\src\ServiceMoyenne;

class NoteController extends AbstractController
{
    #[Route('/note', name: 'app_notes')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        
        $notes = $em->getRepository(Notes::class)->findAll();
        $matieres = $em->getRepository(Matieres::class)->findAll();
        $note = new Notes();
        $form = $this->createForm(NotePageType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note->setDates(new \DateTimeImmutable());

            $em->persist($note);
            $em->flush();

            $this->addFlash('success', 'Note ajoutée avec succès.');

            return $this->redirectToRoute('app_notes');
        }

        $moy = $this->moyenne($notes);

        return $this->render('note/index.html.twig', [
            'controller_name' => 'NoteController',
            'notes' => $notes,
            'moy' => $moy,
            'matieres' => $matieres,
            'form' => $form->createView(),
        ]);
    }

    public function moyenne(array $notes): float
    {
        if (empty($notes)) {
            return 0.0;
        }

        $total = 0;
        $count = count($notes);

        foreach ($notes as $note) {
            $total += $note->getNote();
        }

        return $total/$count;
    }
}