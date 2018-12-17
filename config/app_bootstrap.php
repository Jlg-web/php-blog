<?php

// Fichier de configuration personnalisé
// à inclure à la fin du fichier de configuration du framework: bootstrap.php


// Connexion à la base de données
App\App::dbConnect();

// Fonction à utiliser pour afficher les messages
Phunder\Core\Messager::setOutputHandler(function ($type, $contenu) {
    return '<div class="alert alert-' . $type . '" role="alert">' . $contenu . '</div>';
});
