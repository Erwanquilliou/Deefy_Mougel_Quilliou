<?php

namespace iutnc\deefy\audio\lists;
use iutnc\deefy\exception as exception;

//Classe gerant les AudioList
class AudioList
{
    //Chaque audioList a comme attribut : Un nom, un nombre de piste, un array de pistes, la duree totale et un identifiant.
    protected string $nom;
    protected int $nombrePistes = 0;
    protected array $pistes = [];
    protected int $dureeTotale = 0;
    protected int $id;

    //initialisation des attributs
    public function __construct(string $nom, array $pistes = [])
    {
        $this->nom = $nom;
        $this->nombrePistes = count($pistes);
        $this->pistes = $pistes;
        $this->dureeTotale = $this->calculerDureeTotale();
    }

    //Methode pour calculer la duree totale
    private function calculerDureeTotale(): int
    {
        $duree = 0;
        foreach ($this->pistes as $piste) {
            $duree += $piste->duree;
        }
        return $duree;
    }

    //Getter des attributs
    public function __get($property): mixed
    {
        if(property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new exception\InvalidPropertyNameException($property);
        }
    }

    //Setter de l'identifiant
    public function setId(int $i): void{
        $this->id = $i;
    }
}