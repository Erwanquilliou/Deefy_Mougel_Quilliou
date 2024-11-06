<?php

namespace iutnc\deefy\audio\tracks;
use iutnc\deefy\exception as exception;

//Classe abstraite qui donne les attributs et les methodes communes aux AudioTrack
abstract class AudioTrack
{
    //Chaque AudioTrack a un titre, une duree, un chemin d'acces et un identifiant
    protected string $titre;
    private int $duree;
    protected string $nom_du_fichier;
    private int $id;

    //initialisation des attributs
    public function __construct(string $titre, string $chemin_fichier,int $duree)
    {
        $this->titre = $titre;
        $this->nom_du_fichier = $chemin_fichier;
        $this->setDuree($duree);
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
    }

    //Getter pour les attributs
    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new exception\InvalidPropertyNameException($property);
        }
    }

    //Setter pour la duree
    public function setDuree(int $d): void
    {
        if($d>0){
            $this->duree = $d;
        } else {
            throw new exception\InvalidPropertyValueException("La durée doit être supérieure à 0");
        }
    }

    //Setter pour l'identifiant
    public function setId(int $i){
        $this->id = $i;
    }
}