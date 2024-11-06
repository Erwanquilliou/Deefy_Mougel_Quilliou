<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render as render;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\auth as auth;
use iutnc\deefy\exception as exception;
//Classe pour gerer l'affichage d'une playlist
class DisplayUnePlaylistAction extends Action
{

    public function execute(): string
    {
        if(($this->http_method  === 'GET') && (!isset($_GET['idPlaylist']))){
            $connect = true;
            try{
                auth\AuthnProvider::getSignInUser();
            }catch(exception\AuthnException $e){
                $html = $e->getMEssage(); $connect = false;
            };
            if($connect){
                $html = <<<END
                <form method="get" action="?action=une-playlist">
                    <select name="idPlaylist">
                END;
                $array =auth\Authz::checkOwnerPlaylists();
                // Boucle pour générer chaque option de la liste déroulante
                foreach ($array as $option) {
                    $text = $option->id . " ". $option->nom ;
                    $html .= "<option value=\"{$option->id}\">{$text}</option>";
                }

                $html .= <<<END
                    </select>
                    <input type="hidden" name="action" value="une-playlist">
                    <button type="submit">Afficher</button>
                    </form>
                END;
            }
        }else{
            $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
            $pl = $repo->findPlaylistById($_GET['idPlaylist']);
            $html = "<div> voici votre playlist : </div>";
            $html.="</br></br>";
            $renderer = new render\AudioListRenderer($pl);
            $html.= $renderer->render(1);
            $html.="</br></br>";
        }
        return $html;
    }
}