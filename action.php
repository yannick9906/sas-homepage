<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 02.11.2015
 * Time: 19:20
 */
error_reporting(E_ALL);
ini_set("diplay_errors", "on");


$pg = $_GET['p']; // ID der Seite
if(!is_numeric($pg)) $pg = 0; // Prüfe ob es eine Zahl ist
$token = $_GET['token'];

require_once 'classes/PDO_MYSQL.php'; //DB Anbindung
require_once 'classes/Util.php'; //DB Anbindung
require_once 'libs/Mobile_Detect.php'; // Mobile Detect
require_once 'classes/Token.php'; // Mobile Detect
$pdo = new \ICMS\PDO_MYSQL();
$detect = new Mobile_Detect;
$token = \ICMS\Token::fromToken($token);

if($token->checkIfValid() and $_POST["email"] != null and $_POST["subject"] != null and $_POST["text"] != null) {
    switch($pg) {
        case 1: //FAQ Email
            $emailadrr = "Yannick Felix <yannick.felix1999@gmail.com>";
            $emailfrom = $_POST["email"];
            $ip = $_SERVER['REMOTE_ADDR'];
            $betreff = $_POST["subject"];
            $text = $_POST["text"];
            $header = "From: $emailfrom<$ip>" . "\r\n" .
                "Reply-To: $emailfrom" . "\r\n" .
                'X-Mailer: PHP/' . phpversion();


            $message = <<<EMAIL
Neue Nachricht von $emailfrom<$ip>.

Nachricht:

$text

==============================
EMAIL;


            mail($emailadrr, "SAS FAQ Neue Frage: " . $betreff, $message, $header);
            \ICMS\Util::forwardTo("index.php?i=1#p=7");
            $token->useIt();
            break;
    }
} else {
    \ICMS\Util::forwardTo("index.php?i=2#p=7");
}