<?php

namespace iutnc\deefy\action;

class DefaultAction extends Action
{

    public function execute(): string
    {
        return "<h3>Bienvenue !</h3>";
    }
}