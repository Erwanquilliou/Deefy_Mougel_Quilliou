<?php
namespace iutnc\deefy\auth;
class Authz{
    public static function checkRole() : bool{
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        $role = $repo -> getRoleUser($_SESSION['user']);
        if ($role >1){
            return true;
        }else{
            return false;
        }
    }
    public static function checkOwnerPlaylists(){
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        if(self::checkRole()){
            return $repo->findAllPlaylist();
        }else{
            return $repo->findMultyPlaylists($repo->getIdUSer($_SESSION['user']));
        }
    }
}