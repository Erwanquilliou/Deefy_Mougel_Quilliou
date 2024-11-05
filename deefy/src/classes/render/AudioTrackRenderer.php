<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists as lists;
use iutnc\deefy\audio\tracks as tracks;

//Renderer pour permettre l'affichage d'audioTrack de plusieurs maniere
abstract class AudioTrackRenderer implements Renderer
{
    protected tracks\AudioTrack $audioTrack;

    //initialisation des attributs
    public function __construct(tracks\AudioTrack $audioTrack)
    {
        $this->audioTrack = $audioTrack;
    }

    //permet de choisir la methode d'affichage
    public function render(int $type): string
    {
        switch ($type) {
            case self::COMPACT:
                return $this->renderCompact() . "\n";
            case self::LONG:
                return $this->renderLong() . "\n";
            default:
                return "Type de rendu inconnu";
        }
    }

    //affichage compacte
    abstract protected function renderCompact(): string;
    //affichage Long
    abstract protected function renderLong(): string;
}