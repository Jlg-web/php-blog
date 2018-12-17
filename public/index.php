<?php

// Fichier de configuration obligatoire
require_once '../config/bootstrap.php';

// Alias d'espace de nom
// Pour utiliser la classe qui nous sert de routeur
use Phunder\PPRR\PPRR as Router;

// Alias des controlleurs
// Ils se trouvent dans: src/ + l'espace de nom
use Controller\Home as PageFront;
use Controller\Admin as PageBack;

// Paramétrage du routeur
// Pour utiliser des routes simples au lieu d'expressions rationnelles (RegEx)
Router::setDefaultMode(Router::MODE_STRING);

// Routes
// Alias::class     retourne le véritable nom complet d'une classe
new Router(
    [
        'R>(?:/|/home)?'   => [PageFront::class, 'index'],        // "R>" pour utiliser une RegEx
        '/login'           => [PageFront::class, 'connexion'],
        '/logout'          => [PageFront::class, 'deconnexion'],
        'R>/article-(\d+)' => [PageFront::class, 'lireArticle'],
        '/admin'           => [
            '/dashboard'    => [PageBack::class, 'listeArticles'],
            '/add_article'  => [PageBack::class, 'ajouterArticle'],
            'R>/edit-(\d+)' => [PageBack::class, 'modifierArticle'],
            'R>/supp-(\d+)' => [PageBack::class, 'supprimerArticle']
        ]
    ],
    [PageFront::class, 'page_404']
);
