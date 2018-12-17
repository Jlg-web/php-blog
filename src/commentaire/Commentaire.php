<?php

namespace Commentaire;

use App\App;
use Phunder\Core\User\UserManager;




class Commentaire 
{

    public static function ajouter($id_utilisateur, $publication, $id_article, $contenu) : bool
    {
        // Validation de données
        if (!self::validation($id_utilisateur, $publication, $id_article, $contenu)) {
            return false;
        }
        // Insertion en base de données
        $insert = App::$db->prepare(
            'INSERT INTO commentaire (
                publication,
                contenu,
                id_article
            ) VALUES (
                :id_article
                NOW(),
                :contenu
            )'
        );
        // execution
        $resultat = $insert->execute([
            'id_utilisateur'   => $id_utilisateur,
            'publication' => $publication,
            'id_article' => $id_article,
            'contenu' => $contenu,

        ]);
        if (!$resultat) {
            Messager::message(Messager::MSG_WARNING, 'Le\'commentaire n\'a pas pu être enregistré');
            return false;
        }
        Messager::message(Messager::MSG_SUCCESS, 'commentaire ajouté');
        return true;
    }










    //getlist
    public static function getList(News $news){
        $collection = array();
        $sql = "SELECT * FROM news
                LEFT JOIN commentaire
                ON news.id=  commentaire.news_id
                WHERE commentaires.news_id = :id_news
                ORDER BY commentaires.id DESC";
        $connexion = PDO2::getInstance();
        $req = $connexion->prepare($sql);
        $req->bindValue(':id_news',     $news->getId());
        if($req->execute())
        {
            $result = $req->fetchAll(PDO::FETCH_OBJ);
            foreach($result as $collect)
            {
                $collection[] = new Commentaires($collect->id,$collect->pseudo,$collect->contenu,$collect->date,$collect->ip,$collect->news_id);
                $req->closeCursor();
            }
            return $collection;
        }
    }


    //count
    public static function count(News $news){
        $sql = "SELECT COUNT(*) FROM commentaire WHERE news_id = :news_id";
        $connexion = PDO2::getInstance();
        $req = $connexion->prepare($sql);
        $req->bindValue(':news_id',      $news->getId());
        if($req->execute())
        {
            $result = $req->fetchColumn();
            $req->closeCursor();
            return $result;
        }
    }

    //SUPPRIMER commentaire
    public static function delete($id){
        $sql = "DELETE FROM commentaire WHERE id = :id";
        $req = $connexion->prepare($sql);
        $req->bindValue(':id', $id);
        if($req->execute())
        {
            $req->closeCursor();
            return true;
        }
        else return false;
    }



}//END CLASS COMMENTAIRE






?>