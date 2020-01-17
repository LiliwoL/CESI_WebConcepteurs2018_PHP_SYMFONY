<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

class DummyController extends AbstractController
{
    /**
     * Méthode qui affichera des articles bêbêtes
     *
     * On pourra appeler cette fonction en tapant localhost/repertoire_de_cette_app/public/dummy
     * 
     * @Route("/articles", name="Liste des articles bêbêtes")
     * 
     * @return void
     */
    public function listDummyPosts( )
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
          'dummy/liste.html.twig',
          // Et en passant le tableau suivant en paramètre
          [
              // Cette case liste contient la case DATA du tableau de résultats $results
              'liste' => $results['data']
          ]
      );
    }

    /**
     * Action pour afficher une fiche d'un article bêbête
     *
     * @Route(
     *  "/article/{idArticleBebete}", 
     *  name="Affiche un article bêbête"
     * )
     */
    public function displayDummyPost ( $idArticleBebete )
    {
        // On doit faire appel à cette url:
        $url = "https://n161.tech/api/dummyapi/post/" . $idArticleBebete;

        // Appeler la méthode makeRequest définie plus bas dans le contrôleur
        $results = $this->makeRequest ( $url );

       
        // On doit renvoyer un rendu de template affichant un article avec l'id donné
        return $this->render(
            // En appelant ce fichier twig
            'dummy/fiche.html.twig', // Il faut créer ce fichier dans templates/dummy!

            // Et en passant le tableau suivant en paramètre
            [
                // Cette case article contient toutes les données de l'article concerné
                'article' => $results
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
