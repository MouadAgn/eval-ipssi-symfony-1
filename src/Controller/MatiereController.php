<?php

namespace App\Controller;




use App\Entity\Matieres;
use App\Form\MatierePageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatiereController extends AbstractController
{
    #[Route('/matiere', name: 'app_matiere')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        
        $matieres = $em->getRepository(Matieres::class)->findAll();
        $matiere = new Matieres();
        $form = $this->createForm(MatierePageType::class, $matiere);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($matiere);
            $em->flush();
            return $this->redirectToRoute('app_matiere');
        }

        return $this->render('matiere/index.html.twig', [
            'controller_name' => 'MatiereController',
            'matieres' => $matieres,
            'form' => $form->createView()
        ]);
    }


    #[Route('/edit_matiere/{id}', name: 'app_edit')]
    public function edit(EntityManagerInterface $em, Request $request, Matieres $matiere): Response
    {
        $form = $this->createForm(MatierePageType::class, $matiere);
        $formview = $form->createView();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($matiere);
            $em->flush();

            return $this->redirectToRoute('app_matiere');
        }

        return $this->render('matiere/edit.html.twig', [
            'matieres' => $matiere,
            'form' => $formview,
        ]);
    }

    #[Route('/delete_matiere/{id}', name: 'app_delete')]
    public function delete(EntityManagerInterface $em, Request $request, Matieres $matiere): Response
    {
       
        $em->remove($matiere);
        $em->flush();
        $this->addFlash('success', 'Catégorie supprimée avec succès.');

        return $this->redirectToRoute('app_matiere');

        
    }

    
}
