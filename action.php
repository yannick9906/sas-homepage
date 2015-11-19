<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 02.11.2015
 * Time: 19:20
 */

$pg = $_GET['p']; // ID der Seite
if(!is_numeric($pg)) $pg = 0; // Prüfe ob es eine Zahl ist

require_once 'php/PDO_MYSQL.class.php'; //DB Anbindung
require_once 'php/Mobile_Detect.php'; // Mobile Detect
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;

switch($pg) {
    case 1: //FAQ Email
        $emailadrr = "Yannick Felix <yannick.felix1999@gmail.com>";
        $emailfrom = $_POST["email"];
        $betreff   = $_POST["subject"];
        $text      = $_POST["text"];
        $header = "From: $emailfrom" . "\r\n" .
            "Reply-To: $emailfrom" . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $message = <<<EMAIL
Neue Nachricht von $emailfrom.

Nachricht:

$text

==============================
EMAIL;


        mail($emailadrr, "SAS FAQ Neue Frage: ".$betreff, $message, $header);
        echo "<html><head><meta http-equiv='refresh' content='0, url=index.php#p=7&i=1'/></head></html>";
    break;

}