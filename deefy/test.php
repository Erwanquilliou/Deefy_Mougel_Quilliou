<?php

require_once  __DIR__ . '/vendor/autoload.php';

\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/config/deefy.db.ini');

$repo = \iutnc\deefy\repository\DeefyRepository::getInstance();

$playlists = $repo->findAllPlaylists();
foreach ($playlists as $pl) {
    print "playlist  : " . $pl->nom . ":". $pl->id . "</br>";
}


//$pl = new \iutnc\deefy\audio\lists\PlayList('test');
//$pl = $repo->saveEmptyPlaylist($pl);

//$track = new \iutnc\deefy\audio\tracks\PodcastTrack('test', 'test.mp3', 'auteur', '2021-01-01', 10, 'genre');
//$track = $repo->addTrack($track);

//$repo->addTrackToPlaylist($pl->id, $track->id);