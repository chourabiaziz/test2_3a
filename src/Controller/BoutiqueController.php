<?php

namespace App\Controller;

use App\Entity\Boutique;
use App\Form\BoutiqueType;
use App\Repository\BoutiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    public function index(BoutiqueRepository $br): Response
    {
        $boutiques = $br->findAll();
        return $this->render('boutique/index.html.twig', [
            'boutiques' => $boutiques

        ]);
    }

    #[Route('/boutique/add', name: 'app_boutique_add')]
    public function add(Request $request , EntityManagerInterface $em ): Response
    {
            //new instance
                $boutique = new Boutique ; 
            //formulaire
                $form = $this->createForm(BoutiqueType::class , $boutique) ; 
                $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $em->persist($boutique);
                $em->flush();

                return $this->redirectToRoute('app_boutique');
            }

       
        return $this->render('boutique/add.html.twig', [
             "form"=> $form->createView()
        ]);
    }




    #[Route('/boutique/edit/{id}', name: 'app_boutique_edit')]
    public function edit(Request $request , EntityManagerInterface $em , int $id ,BoutiqueRepository $br ): Response
    {
            //new instance
                $boutique = $br->find($id) ; 
            //formulaire
                $form = $this->createForm(BoutiqueType::class , $boutique) ; 
                $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $em->persist($boutique);
                $em->flush();

                return $this->redirectToRoute('app_boutique');
            }

       
        return $this->render('boutique/edit.html.twig', [
            "form"=> $form->createView()

        ]);
    }

    #[Route('/boutique/delete/{id}', name: 'app_boutique_delete')]
    public function delte( EntityManagerInterface $em , int $id ,BoutiqueRepository $br ): Response
    {
            //new instance
                $boutique = $br->find($id) ; 
           

          
                $em->remove($boutique);
                $em->flush();

                return $this->redirectToRoute('app_boutique');
            

     
    }
    #[Route('/boutique/show/{id}', name: 'app_boutique_show')]
    public function show(Request $request , EntityManagerInterface $em , int $id ,BoutiqueRepository $br ): Response
    {
                 $boutique = $br->find($id) ; 

        return $this->render('boutique/show.html.twig', [
             "boutique"=>$boutique
        ]);
    }

}
