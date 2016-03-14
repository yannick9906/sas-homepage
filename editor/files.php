<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 23.02.2016
 * Time: 18:52
 */

error_reporting(E_WARNING);
ini_set("diplay_errors", "on");

require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/File.php';
require_once 'classes/Permissions.php';
require_once '../php/main.php';

$user = checkSession();
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$fID    = $_GET['fID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_FILE_CREATE)) {
        $pgdata = getEditorPageDataStub("Datei hochladen", $user, false, true, "files.php");
        $dwoo->output("tpl/fileNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Datei hochladen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_FILE_CREATE)) {
        $fileToCreate = \ICMS\File::createFileAndMoveUploaded($_POST['filename'], $user);
        if($fileToCreate != false) forwardTo("files.php");
        else echo "Something went wrong...\n wasn't me :)";
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Dateien", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($fID)) {
    if($user->isActionAllowed(PERM_FILE_OP_DELETE)) {
        $fileToDelete = \ICMS\File::fromFID($fID);
        $fileToDelete->deleteFile();
        forwardTo("files.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_FILE_VIEW)) {
    $pgdata = getEditorPageDataStub("Dateien", $user);
    $files = \ICMS\File::getAllFiles();
    for ($i = 0; $i < sizeof($files); $i++) {
        $pgdata["page"]["items"][$i] = $files[$i]->asArray();
    }

    $dwoo->output("tpl/fileList.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("Dateien", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}