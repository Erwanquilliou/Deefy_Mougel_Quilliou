<?php

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack
{
    protected string $auteur;
    protected string $date;
    protected string $genre;

    public function __construct(string $titre,string  $chemin,string $au,string $da,int $duree = 0,string $g)
    {
        parent::__construct($titre, $chemin, $duree);
        $this->auteur = $au;
        $this->date = $da;
        $this->genre = $g;
    }
}