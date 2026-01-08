<?php

use Core\MyLogger;

$debut = microtime(true);
session_start();

require_once(__DIR__.'/vendor/autoload.php');

$logger = MyLogger::getInstance();

use Core\PageControl;

require 'config/bdd.php';

define('CHEMIN_LOGERREUR', './logs/');
define('LIGNE_PAR_PAGE', 40);

$pageControl = new PageControl(FALSE);
$pageControl->process();
$fin = microtime(true);
$logger->debug('Version php:'.phpversion());
$logger->debug("Temps d'execution: ".($fin-$debut)*1000 . 'ms');

?>
