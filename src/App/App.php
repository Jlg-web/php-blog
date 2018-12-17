<?php

namespace App;

class App
{
    const DB_SGBD     = 'mysql';        // Système de Gestion de Base de Données
    const DB_HOST     = 'localhost';
    const DB_DATABASE = 'tp_blog';
    const DB_USER     = 'root';
    const DB_PWD      = '';
    public static $db;                  // App::$db sera notre instance de PDO

    // Méthode de connexion à la base de données
    public static function dbConnect() : void
    {
        try {
            // DSN: mysql:host=localhost;dbname=tp_blog;
            self::$db = new \PDO(
                self::DB_SGBD . ':host=' . self::DB_HOST . ';dbname=' . self::DB_DATABASE . ';',
                self::DB_USER,
                self::DB_PWD,
                [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_WARNING,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ]
            );
        } catch (\Exception $e) {
            die('Erreur de connexion à la base de données: ' . $e->getMessage());
        }

    }
}
