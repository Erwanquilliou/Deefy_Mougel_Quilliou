<?php
namespace iutnc\deefy\auth;
class Authz{
    public static function checkRole(int $plId) : bool{
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        $role = $repo -> getRoleUser($_SESSION['user']);
        if ($role >1){
            return true;
        }else{
            return false;
        }
    }
}