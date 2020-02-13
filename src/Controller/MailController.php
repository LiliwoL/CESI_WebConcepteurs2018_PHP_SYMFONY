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

                // Récupération des paramètres
                $dest = $params['dest'];
                $message = $params['message'];

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
                                    'imdbID' => $imdbID
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
}
