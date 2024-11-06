<?php

namespace iutnc\deefy\action;


use iutnc\deefy\audio\lists as lst;
use iutnc\deefy\auth as auth;
use iutnc\deefy\exception as exception;

//Classe pour gerer la connection
class SignInAction extends Action
{

    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $html = <<<END
            <form method = "post" action = "?action=signin">
                <label>Email <input type="text" name="email" placeholder="email"></label>
                <label>Mot de passe <input type="text" name="mdp" placeholder="mot de passe"></label>
                <button type="submit">connexion</button>
            </form>
            END;

        }else{
            try {
                auth\AuthnProvider::signin($_POST['email'],$_POST['mdp']);
                $html = "<div>vous êtes connecté, bienvenue ".$_SESSION['user']."</div>";
            } catch(exception\AuthnException $e){
                $html = "erreur lors de la connexion";
            }


        }
         return $html;
        
    }
}