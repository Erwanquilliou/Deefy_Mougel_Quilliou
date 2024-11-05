<?php

namespace iutnc\deefy\exception;

use Exception;

//Creation d'une exception pour les valeurs invalides 
class InvalidPropertyValueException extends Exception
{
    public function __construct($value)
    {
        parent::__construct("Invalid property value: $value");
    }

}