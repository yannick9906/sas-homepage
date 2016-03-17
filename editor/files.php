<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 23.02.2016
 * Time: 18:52
 */

error_reporting(E_WARNING);
ini_set("diplay_errors", "on");

require_once '../classes/File.php'; //DB Anbindung
require_once '../classes/PDO_MYSQL.php'; //DB Anbindung
require_once '../classes/User.php';
require_once '../classes/Permissions.php';
require_once '../classes/Util.php';
require_once '../libs/Mobile_Detect.php'; // Mobile Detect
require_once '../libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden

$user = \ICMS\Util::checkSession();
$pdo = new \ICMS\PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$fID    = $_GET['fID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_FILE_CREATE)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Datei hochladen", $user, false, true, "files.php");
        $dwoo->output("tpl/fileNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Datei hochladen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_FILE_CREATE)) {
        $fileToCreate = \ICMS\File::createFileAndMoveUploaded($_POST['filename'], $user);
        if($fileToCreate != false) \ICMS\Util::forwardTo("files.php");
        else echo "Something went wrong...\n wasn't me :)";
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Dateien", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($fID)) {
    if($user->isActionAllowed(PERM_FILE_OP_DELETE)) {
        $fileToDelete = \ICMS\File::fromFID($fID);
        $fileToDelete->deleteFile();
        \ICMS\Util::forwardTo("files.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_FILE_VIEW)) {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Dateien", $user);
    $files = \ICMS\File::getAllFiles($_GET["sort"], $_GET["filter"]);
    for ($i = 0; $i < sizeof($files); $i++) {
        $pgdata["page"]["items"][$i] = $files[$i]->asArray();
    }

    if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "ascName";
    if(isset($_GET["filter"])) $pgdata["page"]["filter"] = str_replace("+", "%2B",$_GET["filter"]); else $pgdata["page"]["filter"] = "Alle";

    $dwoo->output("tpl/fileList.tpl", $pgdata);
} else {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Dateien", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}