<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render as render;
use iutnc\deefy\audio\lists\Playlist;

//Classe pour gerer l'affichage d'une playlist
class DisplayUnePlaylistAction extends Action
{

    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $html = <<<END
            <form method="post" action="?action=une-playlist">
                <select name="idPlaylist">
            END;
            $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
            $array = $repo->findAllPlaylists();
            // Boucle pour générer chaque option de la liste déroulante
            foreach ($array as $option) {
                $text = $option->id . " ". $option->nom ;
                $html .= "<option value=\"{$option->id}\">{$text}</option>";
            }

            $html .= <<<END
                </select>
                <button type="submit">Afficher</button>
                </form>
            END;
        }else{
            $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
            $pl = $repo->findPlaylistById($_POST['idPlaylist']);
            $html = "<div> voici votre playlist : </div>";
            $html.="</br></br>";
            $renderer = new render\AudioListRenderer($pl);
            $html.= $renderer->render(1);
            $html.="</br></br>";
        }
        return $html;
    }
}