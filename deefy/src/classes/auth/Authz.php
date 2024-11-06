<?php
namespace iutnc\deefy\auth;
//Classe gerant les droits.
class Authz{
    //Fonction qui verifie le role de l'utilisateur
    public static function checkRole() : bool{
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        $role = $repo -> getRoleUser($_SESSION['user']);
        if ($role >1){
            return true;
        }else{
            return false;
        }
    }
    //Fonction qui vérifie les droits de l'utilisateur.
    //Elle dirige vers une fonction pour voir toutes les playlist et une fonction pour voir seulement les siennes
    public static function checkOwnerPlaylists(): array{
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        if(self::checkRole()){
            return $repo->findAllPlaylists();
        }else{
            return $repo->findMultyPlaylists($repo->getIdUSer($_SESSION['user']));
        }
    }
}