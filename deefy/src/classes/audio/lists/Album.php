<?php

namespace iutnc\deefy\audio\lists;

//Classe gerant les Albums
class Album extends AudioList
{
    //Les attributs sont l'artiste et la date de sortie. 
    private string $artiste;
    private string $dateSortie;

    //initialisation des attributs
    public function __construct(string $nom, array $pistes)
    {
        parent::__construct($nom, $pistes);
    }

    //Setter d'artiste
    public function setArtiste(string $artiste): void
    {
        $this->artiste = $artiste;
    }

    //Setter de la date de sortie
    public function setDateSortie(string $dateSortie): void
    {
        $this->dateSortie = $dateSortie;
    }
}