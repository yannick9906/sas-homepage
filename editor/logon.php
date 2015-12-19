<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 21.11.2015
 * Time: 01:19
 */


require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$usrname  = $_POST['usrname'];
$password = $_POST['password'];
$logout   = $_GET['logout'];

if(isset($usrname)) {
    if(\ICMS\User::doesUserNameExist($usrname)) {

        $user = \ICMS\User::fromUName($usrname);
        echo "test";
        if($user->comparePWHash(md5($password))) {
            session_start();
            $_SESSION['uID'] = $user->getUID();
            echo "<html><head><meta http-equiv='refresh' content='0, url=users.php' /></head></html>";
        } else {
            $dwoo->output("tpl/logon.tpl", ["err" => "2","usrname" => $usrname]);
        }
    } else {
        $dwoo->output("tpl/logon.tpl", ["err" => "1", "usrname" => $usrname]);
    }
} elseif($logout == 1) {
    session_destroy();
    $dwoo->output("tpl/logon.tpl");
} else {
    $dwoo->output("tpl/logon.tpl");
}