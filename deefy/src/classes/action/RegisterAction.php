<?php

namespace iutnc\deefy\action;


use iutnc\deefy\audio\lists as lst;
use iutnc\deefy\auth as auth;

class RegisterAction extends Action
{

    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $html = <<<END
            <form method = "post" action = "?action=register">
                <label>Email <input type="text" name="email" placeholder="email"></label>
                <label>Mot de passe <input type="text" name="mdp" placeholder="mot de passe"></label>
                <button type="submit">Créer</button>
            </form>
            END;

        }else{
            
            if(auth\AuthnProvider::register($_POST['email'],$_POST['mdp'])){
                $html = "votre compte à été créer </div>";
            }else{
                return "<div>nous n'avons pas pu créer votre compte</div>";
            }


        }
         return $html;
        
    }
}