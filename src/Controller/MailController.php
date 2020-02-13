<?php

namespace App\Controller;

use App\Form\ShareMovieMailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function index()
    {
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }




    /**
     * Action pour partager par mail une fiche d'un film
     *
     * @Route(
     *  "/shareMovie/{imdbID}",
     *  name="Partage dun film"
     * )
     */
    public function shareMovie( Request $request, \Swift_Mailer $mailer, $imdbID )
    {
        // N'oubiez pas d'ajouter ce use en haut!
        // use Symfony\Component\HttpFoundation\Request;

        // 1. Récupérer les paramètres en mode brute (analyse directe de la requête)

            // share_movie_mail est le nom du formulaire
            //dump ( $request->request->get('share_movie_mail') );
            //dump ( $request->request->all() );
            //die;


        // 1. Récupérer les paramètres du formulaire
            // Instance du formulaire ShareMovieMailType
            $formulaireMail = $this->createForm (
                // On doit bien ajouter
                // use App\Form\ShareMovieMailType;
                ShareMovieMailType::class
            );
            // On demande à cette instance de formulaire de gérer la requête
            $formulaireMail->handleRequest( $request );

            // Le formulaire est il valide et soumis?
            if ( $formulaireMail->isSubmitted() && $formulaireMail->isValid() )
            {
                // $params va récupérer les données du formulaire présentes dans la requête
                $params = $formulaireMail->getData();

                // Récupération des paramètres du formulaire
                $dest = $params['dest'];
                $message = $params['message'];
                $object = $params['object'];


                // Récupération des infos du film
                    // Création de l'url pour rechercher UN film
                    // Ici c'est le paramètre i pour rechercher avec un imdbID
                    // http://www.omdbapi.com/#parameters
                    // On va chercher la constante URLAPI dans le contrôleur OmdbController
                    $url = OmdbController::URLAPI . "i=" . $imdbID;

                    // Appeler la méthode makeRequest définie plus bas dans le contrôleur
                    $movie = $this->makeRequest ( $url );





                // 2. Créer le mail

                    // 2.1 Installation de SwiftMailer
                    // https://symfony.com/doc/current/email.html#installation
                    // composer require symfony/swiftmailer-bundle

                    // 2.2 Injection de la dépendance dans cette action de contrôleur
                    // Ajouter \Swift_Mailer $mailer dans les paramètres

                    // 2.3 Création du message
                    $message = ( new \Swift_Message('Hello Email') )
                        ->setFrom('donald.j.trump@whitehouse.gov.us')
                        ->setTo( $dest )
                        ->setBody(
                            $this->renderView(
                            // templates/emails/shareMovie.html.twig
                                'emails/shareMovie.html.twig',
                                [
                                    'message' => $message,
                                    'objet' => $object,
                                    'movie' => $movie
                                ]
                            ),
                            'text/html'
                        );

                // 3. Envoi du mail
                $mailer->send($message);

                // 4. Redirection et affichage d'un message de confirmation

            }

            // En cas de non soumission on redirige
            return $this->redirectToRoute( 'Liste des films' );
    }


    /**
     * Fonction qui exécutera la requete en cURL
     *
     * ATTENTION il faudrait plutôt la mettre dans un service!
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
