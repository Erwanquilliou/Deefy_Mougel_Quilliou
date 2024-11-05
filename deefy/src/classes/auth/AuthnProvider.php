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
                $_SESSION['user'] = $email;
                return true;
            }else{
                echo "mauvais mdp";
            }
        }else{
            throw new exception\AuthnException("pas réussi à se connecter");
        }
    }
    public static function register(string $email,string $password){
            if($email=== filter_var($email, FILTER_SANITIZE_SPECIAL_CHARS)){
                if($password === filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS) and strlen($password)>10){
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
                    throw new exception\AuthnException("mot de passe non valide");
                }
            }else{
                throw new exception\AuthnException("email dangereux");
            }
        }
    public static function getSignInUser(){
        if (isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        throw new \Exception();
    }
 }


