<?php

namespace iutnc\deefy\action;


use iutnc\deefy\audio\lists as lst;
use iutnc\deefy\auth as auth;
use iutnc\deefy\exception as exception;

//Classe pour gerer l'ajout d'une playlist
class AddPlaylistAction extends Action
{

    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $connect = true;
            try{
                auth\AuthnProvider::getSignInUser();
            }catch(exception\AuthnException $e){
                $html = $e->getMEssage(); $connect = false;
            };
            if($connect){
                $html = <<<END
                <form method = "post" action = "?action=add-playlist">
                    <label>Nom de la playlist : <input type="text" name="nom" placeholder="nom"></label>
                    <button type="submit">Créer</button>
                </form>
                END;
            }

        }else{
            if($_POST['nom'] === filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS)){
                $nom = $_POST['nom'];
                $html = "<div>playlist $nom créé</div>";
            }else{
                return "<div>nom de playlist invalide</div>";
            }
            $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
            $repo->saveEmptyPlaylist(new lst\Playlist($nom));
        }
         return $html;
        
    }
}