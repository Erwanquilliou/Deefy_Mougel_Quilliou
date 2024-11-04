<?php

namespace iutnc\deefy\audio\tracks;
use iutnc\deefy\exception as exception;

abstract class AudioTrack
{
    private string $titre;
    private int $duree;
    private string $nom_du_fichier;
    private int $id;

    public function __construct(string $titre, string $chemin_fichier, $duree)
    {
        $this->titre = $titre;
        $this->nom_du_fichier = $chemin_fichier;
        $this->setDuree($duree);
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
    }

    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new exception\InvalidPropertyNameException($property);
        }
    }

    public function setDuree($d): void
    {
        if($d>0){
            $this->duree = $d;
        } else {
            throw new exception\InvalidPropertyValueException("La durée doit être supérieure à 0");
        }
    }
    public function setId(int $i){
        $this->id = $i;
    }
}