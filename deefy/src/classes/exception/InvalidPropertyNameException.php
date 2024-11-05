<?php

namespace iutnc\deefy\exception;

use Exception;

//creation d'une exception pour les noms de proprietes invalides
class InvalidPropertyNameException extends Exception
{
    public function __construct(string $property)
    {
        parent::__construct("Invalid property name: $property");
    }

}