<?php

namespace iutnc\deefy\exception;

use Exception;

class AuthnException extends Exception
{
    public function __construct($detail)
    {
        parent::__construct("Invalid email or psw:".$detail);
    }

}