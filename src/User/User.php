<?php

namespace User;

// En indiquant l'utilisation de App\App, on pourra y faire référence par le nom de la classe seulement: App
use App\App;
use Phunder\Core\Messager;          // Pour indiquer des messages à l'utilisateur
use Phunder\Core\User\UserManager;  // Pour enregistrer des informations utilisateur en session

class User
{

    /**
     * Connecter l'utilisateur
     *
     * @param string $login     nom d'utilisateur ou email
     * @param string $mdp       mot de passe
     *
     * @return bool true si la connexion a réussie
     */
    public static function connexion(string $login, string $mdp) : bool
    {
        // Chercher si $login correspond à un pseudo ou un email
        $user = App::$db->prepare(
            'SELECT *
            FROM utilisateur
            WHERE
                pseudo = :login
                OR email = :login'
        );
        $user->bindParam(':login', $login);
        $user->execute();

        // Si aucun utilisateur est trouvé, on s'arrête
        if ($user->rowCount() != 1) {
            Messager::message(Messager::MSG_WARNING, 'Aucun utilisateur n\'a été trouvé');
            return false;
        }

        $user = $user->fetch(\PDO::FETCH_ASSOC);

        // Si le mot de passe est incorrect, on s'arrête
        if (!password_verify($mdp, $user['mdp'])) {
            Messager::message(Messager::MSG_WARNING, 'Mot de passe erroné');
            return false;
        }

        // Modifications des informations utilisateur
        unset($user['mdp']);
        $user['token'] = bin2hex(random_bytes(16));

        // Enregistrement en session
        $manager = new UserManager();
        $manager->logIn($user);
        return true;
    }

    // Vérifier la validité d'un jeton de formulaire
    public static function verifToken(string $jeton_formulaire) : bool
    {
        $jeton_session = (new UserManager())->get('token');
        $verification  = $jeton_formulaire === $jeton_session;

        if (!$verification) {
            Messager::message(Messager::MSG_WARNING, 'Votre jeton de sécurité est invalide');
        }
        return $verification;
    }
}
