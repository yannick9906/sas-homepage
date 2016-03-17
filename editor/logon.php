<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 21.11.2015
 * Time: 01:19
 */


require_once '../classes/PDO_MYSQL.php'; //DB Anbindung
require_once '../classes/User.php';
require_once '../classes/Permissions.php';
require_once '../classes/Util.php';
require_once '../libs/Mobile_Detect.php'; // Mobile Detect
require_once '../libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden

$pdo = new \ICMS\PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$usrname  = $_POST['usrname'];
$password = $_POST['password'];
$logout   = $_GET['logout'];
$ses      = $_GET['badsession'];

if(isset($usrname)) {
    if(\ICMS\User::doesUserNameExist($usrname)) {

        $user = \ICMS\User::fromUName($usrname);
        if($user->comparePWHash(md5($password))) {
            session_start();
            $_SESSION['uID'] = $user->getUID();
            \ICMS\Util::forwardTo("users.php");
        } else {
            if($detect->isMobile()) $dwoo->output("tpl/logonM.tpl", ["err" => "2","usrname" => $usrname]);
            else $dwoo->output("tpl/logon.tpl", ["err" => "2","usrname" => $usrname]);
        }
    } else {
        if($detect->isMobile()) $dwoo->output("tpl/logonM.tpl", ["err" => "1", "usrname" => $usrname]);
        else $dwoo->output("tpl/logon.tpl", ["err" => "1", "usrname" => $usrname]);
    }
} elseif($logout == 1) {
    session_start();
    session_destroy();
    if($detect->isMobile()) $dwoo->output("tpl/logonM.tpl");
    else $dwoo->output("tpl/logon.tpl");
} else {
    if($detect->isMobile()) $dwoo->output("tpl/logonM.tpl", ["ses" => $ses]);
    else $dwoo->output("tpl/logon.tpl", ["ses" => $ses]);
}