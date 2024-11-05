<?php

namespace iutnc\deefy\action;


use iutnc\deefy\audio\lists as lst;
use iutnc\deefy\auth as auth;

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
                <button type="submit">Créer</button>
            </form>
            END;

        }else{
            
            if(auth\AuthnProvider::signin($_POST['email'],$_POST['mdp'])){
                $html = "<div>vous êtes connecté, bienvenue ".$_SESSION['user']."</div>";
            }else{
                return "<div>nous n'avons pas réussi à vous connecter</div>";
            }


        }
         return $html;
        
    }
}