<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route(
     *  "/product/{category}/{id}/",
     *  name="Display product"
     * )
     */
    public function afficher ( $category, $id )
    {
        // Renvoyer un rendu de template auquel on aura passé les paramètres récupérés dans l'url
        return $this->render(
            'product/product.html.twig', // il faut crééer ce fichier!!
            [
                'category' => $category,
                'id' => $id
            ]
        );




        // Renvoi d'un objet Réponse avec le paramètre passé dans la route
        //return new Response( "Voici l'id du produit: " . $id );
    }

    
}
