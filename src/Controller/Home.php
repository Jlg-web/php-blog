<?php

// Indiquer l'espace de nom dans lequel on se trouve
// Cela correspond à notre structure de dossiers dans /src/
namespace Controller;

// Indiquer les classes que l'on va utiliser
use Phunder\Core\Controller\Controller as ControlleurFramework; // classe Controlleur fournie par le framework
use User\User;
use Phunder\Core\Messager;
use Phunder\Core\User\UserManager;
use Article\Article;



/**
 * Notre controlleur Home hérite de ControlleurFramework
 * -> il récupère ses propriétés et méthodes publiques et protégées
 */
class Home extends ControlleurFramework
{
    // Actions à effectuer pour toutes les routes de ce controlleur
    public static function mandatoryData() : void
    {
        // Tableau des messages
        self::set('messages', Messager::output());

        // Liens de connexion
        $manager = new UserManager();
        if ($manager->isLoggedIn()) {       // L'utilisateur est-il connecté ? Si oui ...
            self::set(
                'nav_connexion',
                '<li class="nav-item"><a class="nav-link" href="#">' . $manager->get('pseudo') . '</a></li>
                <li class="nav-item"><a class="nav-link" href="logout">Déconnexion</a></li>'
            );

            // Lien vers le back-office si l'utilisateur est admin
            if ($manager->get('type') === 'admin') {
                self::set('nav_admin', '<li class="nav-item"><a class="nav-link" href="admin/dashboard">Back-Office</a></li>');
            } else {
                self::set('nav_admin', '');
            }

        } else {                            // ... si non
            self::set(
                'nav_connexion',
                '<li class="nav-item"><a class="nav-link" href="login">Connexion</a></li>'
            );
            self::set('nav_admin', '');
        }
    }

    // méthode de la page d'accueil
    public static function index()
    {
        // Déclaration de variables à utiliser dans le template avec ::set()
        // ::set(nom_de_la_variable, valeur)
        self::set('liste', Article::liste());
        self::set('titre_HTML', 'Blog - Accueil');
        self::set('prenom', 'Aymeric');

        // Afficher un template
        // Le chemin à indiquer est relatif au dossier /templates/
        self::render('home.html');
    }

    // Page de connexion
    public static function connexion()
    {
        // Traitement du formulaire de connexion
        if (isset($_POST['connexion'])) {
            $connexion = User::connexion($_POST['login'], $_POST['mdp']);

            if ($connexion) {
                header("Location: home");
            }
        }

        self::set('titre_HTML', 'Blog - Connexion');

        self::render('login.html');
    }

    // Déconnecter l'utilisateur courant
    public static function deconnexion() : void
    {
        // On déconnecte l'utilisateur
        $manager = new UserManager();
        $manager->logOut();

        // On ajoute un message de succès
        Messager::message(Messager::MSG_SUCCESS, 'Vous avez bien été déconnecté');

        // On oublie pas le titre de la page
        self::set('titre_HTML', 'Blog - Déconnexion');

        // On affiche la page de connexion
        self::render('login.html');
    }

    // L'argument $id_article est fourni via le routeur
    // Il correspond au "groupe de capture" (\d+)
    // Le routeur envoit les groupes de capture à la méthode de controlleur associée
    public static function lireArticle(int $id_article)
    {
        try {
            $article = new Article($id_article);

            self::set('titre_HTML', $article->getTitre());
            self::set('titre', $article->getTitre());
            self::set('date', $article->dateFr());
            self::set('contenu', $article->markdownToHtml());

            self::render('article.html');

            // Le bloc catch ne s'éxécute que si une exception est lancée
        } catch (\Exception $e) {
            Messager::message(Messager::MSG_WARNING, $e->getMessage());
            self::set('titre_HTML', 'Erreur');
            self::render('erreur.html');
        }

    }

    // Page d'erreur 404
    public static function page_404()
    {
        self::render('404.html');
    }
}
