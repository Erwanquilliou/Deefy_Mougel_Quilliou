<?php
namespace iutnc\deefy\audio\lists;

//Classe gerant les playlists
class Playlist extends AudioList
{
    //Methode pour ajouter une piste dans la playlist
    public function ajouterPiste($piste): void
    {
        $this->pistes[] = $piste;
        $this->nombrePistes++;
        $this->dureeTotale += $piste->duree ?? 0;
    }

    //Methode pour supprimer une piste
    public function supprimerPiste(int $index): void
    {
        unset($this->pistes[$index]);
    }

    //Methode pour ajouter une liste de pistes
    public function ajouterListePistes(array $pistes): void {
        $this->pistes = array_unique(array_merge($this->pistes, $pistes));
        $this->nombrePistes = count($this->pistes);
        foreach ($this->pistes as $piste) {
            $this->dureeTotale += $piste->duree;
        }
    }
}