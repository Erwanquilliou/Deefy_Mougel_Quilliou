<?php
declare(strict_types=1);

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action as act;

//Classe dispatcher permettant de gerer les interactions avec le site
class Dispatcher
{
    //Attribut qui contient l'action qui vient d'etre realisee
    private ?string $action = null;

    //initialisation de l'action
    function __construct()
    {
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'default';
    }

    //fonction permettant d'executer l'action
    //Pour chaque action, on creer un objet de l'action correspondante et on utilise sa methode execute()
    public function run(): void
    {
        $html = '';
        switch ($this->action) {
            case 'default':
                $action = new act\DefaultAction();
                $html = $action->execute();
                break;
            case 'playlist':
                $action = new act\DisplayPlaylistAction();
                $html = $action->execute();
                break;
            case 'add-playlist':
                $action = new act\AddPlaylistAction();
                $html = $action->execute();
                break;
            case 'add-track':
                $action = new act\AddTrackAction();
                $html = $action->execute();
                break;
            case 'signin' : 
                $action = new act\SignInAction();
                $html = $action->execute();
                break;
            case 'register' : 
                $action = new act\RegisterAction();
                $html = $action->execute();
                break;
            case 'add-track-to-playlist' :
                $action = new act\AddTrackPlaylistAction();
                $html = $action->execute();
                break;
            
        }
        $this->renderPage($html);
    }

    //fonction permettant d'afficher la page web
    private function renderPage(string $html): void
    {
        echo <<<HEAD
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Deefy</title>
</head>
<body>
   <h1>Deefy</h1>
   <ul>
         <li><a href="?action=default">Accueil</a></li>
         <li><a href="?action=playlist">Afficher mes playlist</a></li>
         <li><a href="?action=add-playlist">Ajouter une playlist</a></li>
         <li><a href="?action=add-track">Ajouter une track</a></li>
         <li><a href="?action=add-track-to-playlist">Ajouter une track dans une playlist</a></li>
         <li><a href="?action=signin">se connecter</a></li>
         <li><a href="?action=register">s'enregistrer</a></li>
    </ul>
    $html
</body>
</html>
HEAD;
    }
}
