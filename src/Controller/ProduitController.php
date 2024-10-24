<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $pr ,EntityManagerInterface $em): Response
    {

            $produits = $pr->findAll();
 
            $p1 = 1000;
            $p2 = 2000; 


            //DQL
            $requete = $em->createQuery("select p from App\Entity\Produit p where p.prix between $p1 and $p2 ");
            $result = $requete->getResult();
            //query builder : definir une fonction dans le Repository 
            $result_query_builder = $pr->findPriceBetween(500 , 600) ; 

        return $this->render('produit/index.html.twig', [
                "produits" =>  $produits ,
                "result"=> $result , //array
                 "result_query_builder" => $result_query_builder //array
        ]);
    }



    #[Route('/produit/add', name: 'app_produit_add')]
    public function add(  Request $request  , EntityManagerInterface $em ): Response
    {
            //création d'instance de classe
            $produit = new Produit ; 

            //  creation de formulaire
            $form = $this->createForm(ProduitType::class , $produit); 
            $form->handleRequest($request) ; 

            if ($form->isSubmitted() ) {
                $em->persist($produit);
                $em->flush() ;

                return $this->redirectToRoute('app_produit');

            }



        return $this->render('produit/add.html.twig', [
                'form'=> $form->createView()
        ]);
    }





    #[Route('/produit/edit/{id}', name: 'app_produit_edit')]
    public function edit(  Request $request , ProduitRepository $pr ,int $id ,EntityManagerInterface $em ): Response
    {
            //création d'instance de classe
            $produit = $pr->find($id)   ; 

            //  creation de formulaire
            $form = $this->createForm(ProduitType::class , $produit); 
            $form->handleRequest($request) ; 

            if ($form->isSubmitted() ) {
                $em->persist($produit);
                $em->flush() ;

                return $this->redirectToRoute('app_produit');

            }
        return $this->render('produit/add.html.twig', [
                'form'=> $form->createView()
        ]);
    }

    #[Route('/produit/delete/{id}', name: 'app_produit_delete')]
    public function delete(  Request $request , ProduitRepository $pr ,int $id ,EntityManagerInterface $em ): Response
    {
            //création d'instance de classe
            $produit = $pr->find($id)   ; 

           

        
                $em->remove($produit);
                $em->flush() ;

                return $this->redirectToRoute('app_produit');

 
     
    }

    #[Route('/produit/show/{id}', name: 'app_produit_show')]
    public function show(ProduitRepository $pr , int $id ): Response
    {

            $produit = $pr->find($id);


        return $this->render('produit/show.html.twig', [
                "produit" =>  $produit
        ]);
    }







}
