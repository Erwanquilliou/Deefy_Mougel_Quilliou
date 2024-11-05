<?php

namespace iutnc\deefy\action;

//Classe abstraite donnant les attributs et les fonctions communs aux actions. 
abstract class Action {

    //Attributs
    protected ?string $http_method = null;
    protected ?string $hostname = null;
    protected ?string $script_name = null;

    //initialisation des attributs
    public function __construct(){

        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    //Methode pour executer l'action
    abstract public function execute() : string;

}
