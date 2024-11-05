<?php

use iutnc\deefy\audio\tracks as tracks;
use iutnc\deefy\audio\lists as lists;
use iutnc\deefy\render as render;

require_once 'vendor/autoload.php';

print "<h1>AudioList</h1>";
//Creation de 5 pistes + 1 Podcast puis affichage avec un renderer
$podcast = new tracks\PodcastTrack("My Podcast", "", "UnAuteur","27/11/2024",555,"Culture");
$piste1 = new tracks\AlbumTrack("Mozart 7th Symphony1", "music/M7S.mp3", "Album_Mozart", 1, 148);
$piste2 = new tracks\AlbumTrack("Mozart 7th Symphony2", "music/M7S.mp3", "Album_Mozart", 1, 148);
$piste3 = new tracks\AlbumTrack("Mozart 7th Symphony3", "music/M7S.mp3", "Album_Mozart", 1, 148);
$piste4 = new tracks\AlbumTrack("Mozart 7th Symphony4", "music/M7S.mp3", "Album_Mozart", 1, 148);
$playlist = new lists\Playlist("Ma playlist");
$playlist->ajouterPiste(new tracks\AlbumTrack("Mozart 7th Symphony5", "music/M7S.mp3", "Album_Mozart", 1, 148));
$playlist->ajouterListePistes([$piste1, $piste2, $piste3, $piste4, $podcast]);
$renderer = new render\AudioListRenderer($playlist);
echo $renderer->render(1);