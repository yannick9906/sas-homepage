<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 19.01.2016
 * Time: 23:49
 */


error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../php/Parsedown.php'; // Parsedown
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Site.php';
require_once 'classes/TypeNormal.php';
require_once 'classes/TypeAK.php';
require_once 'classes/TypeParty.php';
require_once 'classes/Permissions.php';
require_once '../php/main.php';

$user = checkSession();
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();