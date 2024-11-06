<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render as render;
use iutnc\deefy\audio\lists\Playlist;

//Classe pour gerer l'affichage d'une playlist
class DisplayPlaylistAction extends Action
{

    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $html = <<<END
            <form method="post" action="?action=une-playlist">
                <select name="nomTrack">
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
            END;
        }else{

        }
    }
}