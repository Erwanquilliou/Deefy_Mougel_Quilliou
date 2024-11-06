<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render as render;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\auth as auth;
use iutnc\deefy\exception as exception;

//Classe pour gerer l'affichage d'une playlist
class DisplayPlaylistAction extends Action
{

    public function execute(): string
    {
        $connect = true;
        try{
            auth\AuthnProvider::getSignInUser();
        }catch(exception\AuthnException $e){
            $s = $e->getMEssage(); $connect = false;
        };
        if($connect){
            $playlists = auth\Authz::checkOwnerPlaylists() ;
            $s = "";
            foreach ($playlists as $pl) {
                $renderer = new render\AudioListRenderer($pl);
                $s.= $renderer->render(1);
                $s.="</br></br>";
            }
            
        }
        return $s;
    }
}