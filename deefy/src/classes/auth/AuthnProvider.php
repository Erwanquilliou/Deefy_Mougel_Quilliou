<?php
namespace iutnc\deefy\auth;
use iutnc\deefy\exception as exception;

//Classe permettant le connexion et l'enregistrement de compte. 
class AuthnProvider
{
    //Fonction permettant de se connecter. Elle prend en parametre le mail et le mot de passe de l'utilisateur
    //et renvoie true si la connection a ete effectue
    public static function signin(string $email, string $password): bool {
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
    //Fonction permettant d'enregistrer un compte. Elle prend en parametre le mail et le mot de passe de l'utilisateur
    //et renvoie true si l'enregistrement a ete effectue
    public static function register(string $email,string $password): bool{
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
    public static function getSignInUser(): string{
        if (isset($_SESSION['user'])){
            return unserialize($_SESSION['user'])->email;
        }
        throw new exception\AuthnException("pas authentifié");
    }
 }


