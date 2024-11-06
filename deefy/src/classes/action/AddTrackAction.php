<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks as tracks;

//Classe pour gerer l'ajout d'une Track
class AddTrackAction extends Action
{
    public function execute(): string
    {
        if($this->http_method  === 'GET'){
            $html = <<<END
            <form method = "post" action = "?action=add-track">
                <label>Nom de la piste : <input type="text" name="nom" placeholder="nom"></label></br>
                <label>chemin du fichier : <input type="text" name="chemin" placeholder="chemin fichier"></label></br>
                <label>Nom de l'artiste : <input type="text" name="artiste" placeholder="artiste"></label></br>
                <label>Nom de l'album : <input type="text" name="album" placeholder="album"></label></br>
                <label>Nombre de pistes : <input type="text" name="nbPistes" placeholder="nbPistes"></label></br>
                <label>Durée : <input type="text" name="durée" placeholder="durée"></label>
                <button type="submit">Créer</button>
            </form>
            END;

        }else{
            $nom = $_POST['nom'];
            $nomFich = $_POST["chemin"];
            $artiste = $_POST['artiste'];
            $album = $_POST['album'];
            $nbPistes = $_POST['nbPistes'];
            $duree = $_POST['durée'];
            $tr = new tracks\AlbumTrack($nom,$nomFich,$album,$nbPistes,$duree);
            $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
            $repo->addTrack($tr);
            $html = "piste $nom ajoutée";
        }
         return $html;
        
    }
}
