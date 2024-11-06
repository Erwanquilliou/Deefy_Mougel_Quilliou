<?php

namespace iutnc\deefy\action;


use iutnc\deefy\audio\lists as lst;
use iutnc\deefy\auth as auth;

//Classe pour gerer la deconnection
class DisconnectAction extends Action
{

    public function execute(): string
    {       
        session_destroy();
        return "vous avez été déconnecté";
    }
}