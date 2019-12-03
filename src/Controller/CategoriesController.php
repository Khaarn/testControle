<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index()
    {
        $repository=$this->getDoctrine()->getRepository(Categorie::class);

        $categories=$repository->findAll();

        return $this->render('categories/index.html.twig', [
            "categories"=>$categories,
        ]);
    }
    /**
     * @Route("/categories/ajouter", name="ajouter_categories")
     */
    public function ajouter(Request $request)
    {
        $categorie=new Categorie();

        //mettre une valeur par défault
        //$categorie->setTitre("fo<evejvejvoen,");

        //creation du formulaire
        $formulaire=$this->createForm(CategorieType::class, $categorie);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid())
        {
            //récupérer l'entity manager (sorte de connexion à la BDD)
            $em=$this->getDoctrine()->getManager();

            //je dis au manager que je veux ajouter la catégorie dans la BDD
            $em->persist($categorie);

            $em->flush();

            return $this->redirectToRoute("categories");
        }

        return $this->render('categories/formulaire.html.twig', [
        "formulaire"=>$formulaire->createView(),
        "h1"=>"Ajouter la catégorie",

        ]);
    }
    /**
     * @Route("/categories/modifier/{id}", name="modifier_categories")
     */
    public function modifier($id, Request $request)
    {
        $repository=$this->getDoctrine()->getRepository(Categorie::class);
        $categorie = $repository->find($id);

        //creation du formulaire
        $formulaire = $this->createForm(CategorieType::class, $categorie);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            //récupérer l'entity manager (sorte de connexion à la BDD)
            $em = $this->getDoctrine()->getManager();

            //je dis au manager que je veux ajouter la catégorie dans la BDD
            $em->persist($categorie);

            $em->flush();

            return $this->redirectToRoute("categories");
        }

        return $this->render('categories/formulaire.html.twig', [
            "formulaire" => $formulaire->createView(),
            "h1"=>"Modification de la catégorie <i>".$categorie->GetTitre()."</i>"
        ]);
    }
}
