<?php

namespace iutnc\deefy\action;


use iutnc\deefy\audio\lists as lst;
use iutnc\deefy\auth as auth;
use iutnc\deefy\exception as exception;

//Classe pour gerer l'ajout d'une track dans une playlist
class AddTrackPlaylistAction extends Action
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
                <form method="post" action="?action=add-track-to-playlist">
                    <select name="nomTrack">
                END;
                $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
                $array = $repo->findAllTracks();
                // Boucle pour générer chaque option de la liste déroulante
                foreach ($array as $option) {
                    $text = $option->id . " ". $option->titre ;
                    $html .= "<option value=\"{$option->id}\">{$text}</option>";
                }

                $html .= <<<END
                    </select>
                    <select name="nomPlaylist">
                END;
                $array = $repo->findAllPlaylists();
                // Boucle pour générer chaque option de la liste déroulante
                foreach ($array as $option) {
                    $text = $option->id . " ". $option->nom ;
                    $html .= "<option value=\"{$option->id}\">{$text}</option>";
                }

                $html .= <<<END
                </select>
                <button type="submit">Créer</button>
                </form>
                END;
            }

        }else{
            
            $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
            $repo->addTrackToPlaylist($_POST['nomPlaylist'],$_POST['nomTrack']);
            $html ="<div> votre track a bien été ajouté à votre playlist <div>";


        }
         return $html;
        
    }
}