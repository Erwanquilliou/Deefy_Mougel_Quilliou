<?php

namespace iutnc\deefy\exception;

use Exception;

//Creation d'une exception pour les problemes de connection
class AuthnException extends Exception
{
    public function __construct($detail)
    {
        parent::__construct("Invalid email or psw:".$detail);
    }

}