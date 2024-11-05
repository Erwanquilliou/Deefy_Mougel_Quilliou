<?php

namespace iutnc\deefy\audio\tracks;

//Classe qui gere les AlbumTrack
class AlbumTrack extends AudioTrack
{
    //Chaque AlbumTrack a un artiste, un album, une annee, un numero de piste et un genre en attribut
    protected string $artiste;
    protected string $album;
    protected int $annee;
    protected int $numero_piste;
    protected string $genre;

    //initialisation des attributs
    public function __construct(string $titre,string $chemin_fichier,string $album,int $numero_piste,int $duree)
    {
        parent::__construct($titre, $chemin_fichier, $duree);
        $this->titre = $titre;
        $this->nom_du_fichier = $chemin_fichier;
        $this->album = $album;
        $this->numero_piste = $numero_piste;
        $this->artiste = "Inconnu";
        $this->annee = 2000;
        $this->genre = "Inconnu";
    }

    //Setter d'artiste
    public function setArtiste(string $artiste): void
    {
        $this->artiste = $artiste;
    }

    //Setter d'Annee
    public function setAnnee(int $annee): void
    {
        $this->annee = $annee;
    }

    //Setter de genre
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }
}
