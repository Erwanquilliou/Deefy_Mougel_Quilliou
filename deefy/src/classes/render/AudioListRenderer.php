<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists as lists;
use iutnc\deefy\audio\tracks as tracks;

//Renderer pour permettre l'affichage d'audioList
class AudioListRenderer implements Renderer
{
    private lists\AudioList $audioList;

    //initialisation des attributs
    public function __construct(lists\AudioList $audioList)
    {
        $this->audioList = $audioList;
    }


    public function render(int $type): string
    {
        return $this->afficher();
    }

    //affichage 
    private function afficher(): string
    {
        $html = "<div>";
        $html .= "<h3>{$this->audioList->nom} :</h3>";
        foreach ($this->audioList->pistes as $piste) {
            if ($piste instanceof tracks\AlbumTrack) {
                $renderer = new AlbumTrackRenderer($piste);
            } elseif ($piste instanceof tracks\PodcastTrack) {
                $renderer = new PodcastRenderer($piste);
            }
            $html .= $renderer->render(Renderer::COMPACT);
        }

        $html .= "<p><strong>Nombre de pistes :</strong> {$this->audioList->nombrePistes}</p>";
        $html .= "<p><strong>Durée totale :</strong> {$this->audioList->dureeTotale} secondes</p>";
        $html .= "</div>";
        return $html;
    }
}