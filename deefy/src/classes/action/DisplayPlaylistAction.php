<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render as render;
use iutnc\deefy\audio\lists\Playlist;

//Classe pour gerer l'affichage d'une playlist
class DisplayPlaylistAction extends Action
{

    public function execute(): string
    {
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        $playlists = $repo->findAllPlaylists();
        $s = "";
        foreach ($playlists as $pl) {
            $renderer = new render\AudioListRenderer($pl);
            $s.= $renderer->render(1);
            $s.="</br></br>";
        }
        return $s;
    }
}