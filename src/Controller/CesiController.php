<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

class CesiController extends AbstractController
{
    /**
     * @Route("/cesi", name="cesi")
     */
    public function index()
    {
        // Chaine JSON
        $json = '[{
            "id": 1,
            "firstname": "Sarene",
            "lastname": "Haszard",
            "age": 58,
            "image": "https://robohash.org/excepturiharumcumque.png?size=50x50&set=set1",
            "biography": 4
          }, {
            "id": 2,
            "firstname": "Joshua",
            "lastname": "Meggison",
            "age": 50,
            "image": "https://robohash.org/inciduntquidemdicta.jpg?size=50x50&set=set1",
            "biography": 3
          }, {
            "id": 3,
            "firstname": "Darrel",
            "lastname": "Dendle",
            "age": 45,
            "image": "https://robohash.org/earumuttotam.bmp?size=50x50&set=set1",
            "biography": 1
          }, {
            "id": 4,
            "firstname": "Shalom",
            "lastname": "Waskett",
            "age": 33,
            "image": "https://robohash.org/quimodiet.bmp?size=50x50&set=set1",
            "biography": 1
          }, {
            "id": 5,
            "firstname": "Deeann",
            "lastname": "Rippingale",
            "age": 8,
            "image": "https://robohash.org/atexpeditaillum.bmp?size=50x50&set=set1",
            "biography": 1
          }, {
            "id": 6,
            "firstname": "Tonie",
            "lastname": "Pudner",
            "age": 69,
            "image": "https://robohash.org/numquamsuntprovident.png?size=50x50&set=set1",
            "biography": 1
          }, {
            "id": 7,
            "firstname": "Reidar",
            "lastname": "Matthewes",
            "age": 79,
            "image": "https://robohash.org/liberovoluptasquia.jpg?size=50x50&set=set1",
            "biography": 1
          }, {
            "id": 8,
            "firstname": "Kordula",
            "lastname": "Krzyzanowski",
            "age": 15,
            "image": "https://robohash.org/quoestodit.png?size=50x50&set=set1",
            "biography": 1
          }, {
            "id": 9,
            "firstname": "Starlene",
            "lastname": "Blue",
            "age": 53,
            "image": "https://robohash.org/etquiaveniam.bmp?size=50x50&set=set1",
            "biography": 1
          }, {
            "id": 10,
            "firstname": "Dave",
            "lastname": "Yukhov",
            "age": 98,
            "image": "https://robohash.org/eumsuscipitaspernatur.bmp?size=50x50&set=set1",
            "biography": 1
          }]';
        
          // Décodage de la chaine JSON        
          $json_decode = json_decode( $json, true );
        
          return $this->render(
            'cesi/index.html.twig', 
            [
                'controller_name' => 'Bienvenue au CESI',
                'nom' => "machin",
                'liste' => $json_decode
            ]
        );
    }

    /**
     * Méthode qui affichera des articles bêbêtes
     *
     * On pourra appeler cette fonction en tapant localhost/repertoire_de_cette_app/public/dummy
     * 
     * @Route("/dummy", name="dummy")
     * 
     * @return void
     */
    public function listDummyPosts()
    {
      // On utilisera pour cet exemple l'API Dummy
      // https://n161.tech/

      // Définir l'url de l'API dummy pour lister les articles
      $url = "https://n161.tech/api/dummyapi/post";

      // Appeler la méthode makeRequest définie plus bas dans le contrôleur
      $results = $this->makeRequest ( $url );
      // On appelle la méthode définie dans CETTE classe avec le mot clé THIS
      // https://www.php.net/manual/fr/language.oop5.basic.php
      

      // On renvoie une réponse
      return $this->render(
          // En appelant ce fichier twig
          'cesi/liste.html.twig',
          // Et en passant le tableau suivant en paramètre
          [
              // Cette case liste contient la case DATA du tableau de résultats $results
              'liste' => $results['data']
          ]
      );
    }

    /**
     * Fonction qui exécutera la requete en cURL
     *
     * @param string $url
     * @return array
     */
    private function makeRequest ( string $url )
    {
        // Initialisation de cURL
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Au cas où on a un souci avec le SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);

        // Execute
        $result=curl_exec($ch);

        // En cas d'erreur
        if ( $result === false )
        {
            // Affichage de l'erreur
            dump ( curl_error($ch) );
        }

        // Closing
        curl_close($ch);

        // Decodage du JSON reçu
        $data = json_decode($result, true);

        // Renvoi du tableau JSON
        return (array) $data;
    }


    // **************************

    /**
     * 
     * Route avec paramètre
     * On pourra appeler cette fonction en tapant 
     * localhost/repertoire_de_cette_app/public/getWithParam/un_parametre
     * 
     * @Route(
     *     "getWithParam/{name}",
     *     name="getWithParam"
     * )
     */
    public function getWithParamAction( $name )
    {
      dump ("Voici le paramètre reçu " . $name );
      die;
    }
}
