<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
session_start();
\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/config/deefy.db.ini');

$d = new \iutnc\deefy\dispatch\Dispatcher();
$d->run();
