<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OmdbController extends AbstractController
{
    // Définir une constante de la classe
    const QUERY = "the running man";
    
    // Clé API de OmdbAPI
    const APIKEY = "185a318e";

    // Url de l'API avec la clé API
    const URLAPI = "http://www.omdbapi.com/?apikey=" . self::APIKEY . "&"; // On n'oublie pas le & à la fin pour avoir plusieurs arguments


    /**
     * Action pour afficher la liste des films correspondant à la recherche avec la constante QUERY
     * 
     * @Route(
     *  "/movies",
     *  name="Liste des films"
     * )
     * 
     */
    public function list()
    {
        // Création de l'url pour rechercher la liste des films avec les constantes
        // BONUS:  On encode la constante QUERY pour prendre en charge les espaces
        $url = self::URLAPI . "s=" . urlencode ( self::QUERY );

        // Appeler la méthode makeRequest définie plus bas dans le contrôleur
        $results = $this->makeRequest ( $url );

        // Faites un dump et un die pour vous assurer que vous récupérez bien des résultats
            //dump ($url);
            //dump ($results);
            //die;

        // On dispose donc d'un résultat comprenant:
            // Une case Search comprenant la liste des films
            // Une case totalResults comprenant le nombre de résultats

        return $this->render(
            // On utilise le fichier twig suivant
            'omdb/liste.html.twig', // Il faut créer ce fichier dans templates/omdb

            // Paramètres passés au fichier twig
            [
                'totalResults' => $results['totalResults'],
                'list' => $results['Search'],
                'query' => self::QUERY
            ]
        );
    }

     /**
     * Action pour afficher une fiche d'un film
     * 
     * @Route(
     *  "/movie/{imdbID}", 
     *  name="Fiche dun film"
     * )
     */
    public function displayMovie ( $imdbID )
    {
        // Création de l'url pour rechercher UN film
        // Ici c'est le paramètre i pour rechercher avec un imdbID
        // http://www.omdbapi.com/#parameters
        $url = self::URLAPI . "i=" . $imdbID;

        // Appeler la méthode makeRequest définie plus bas dans le contrôleur
        $results = $this->makeRequest ( $url );

        // Faites un dump et un die pour vous assurer que vous récupérez bien des résultats
            // dump ($url);
            // dump ($results);
            // die;

        // On dispose donc d'un tableau comprenant toutes les infos du film

        return $this->render(
            // On utilise le fichier twig suivant
            'omdb/movie.html.twig', // Il faut créer ce fichier dans templates/omdb

            // Paramètres passés au fichier twig
            [
                'movie' => $results
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
}
