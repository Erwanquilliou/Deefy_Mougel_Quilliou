<?php
namespace iutnc\deefy\auth;
use iutnc\deefy\exception as exception;

class AuthnProvider
{
    public static function signin(string $email, string $password) {
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        $result = $repo -> verifIdRegister($email);
        if($result[0] == false){
            if(password_verify($password,$result[1])){
                $user = new User($repo->getIdUser($email),$email,$repo->getRoleUser($email));
                $_SESSION['user'] = serialize($user);
                return true;
            }else{
                throw new exception\AuthnException("echec d'authentification");
            }
        }else{
            throw new exception\AuthnException("pas réussi à se connecter");
        }
    }
    public static function register(string $email,string $password){
            if($email=== filter_var($email, FILTER_SANITIZE_EMAIL)){
                if (strpos($email, "@") !== false and strpos($email, ".") !== false ) {
                    $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
                    if ($repo -> verifIdRegister($email)[0]){
                        $repo->register($email,password_hash($password, PASSWORD_BCRYPT));
                        return true;
                    }else{
                        throw new exception\AuthnException("déjà présent");
                    }
                }else{
                    throw new exception\AuthnException("email non valide");
               }
            }else{
                throw new exception\AuthnException("email dangereux");
            }
        }
    public static function getSignInUser(){
        if (isset($_SESSION['user'])){
            return unserialize($_SESSION['user'])->email;
        }
        throw new exception\AuthnException("pas authentifié");
    }
 }


