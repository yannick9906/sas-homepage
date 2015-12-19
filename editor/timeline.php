<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 10.12.2015
 * Time: 22:07
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/TimelineEntry.php';
require_once 'classes/Permissions.php';
require_once '../php/main.php';

$user = checkSession();
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$vID = $_GET['vID'];

if($action == "new") {
    /*if ($user->isActionAllowed(PERM_USER_CREATE)) {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/usersNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($uID)) {
    if ($user->isActionAllowed(PERM_USER_EDIT) or $uID == $user->getUID()) {
        $userToEdit = \ICMS\User::fromUID($uID);
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $pgdata["edit"] = $userToEdit->asArray();
        $dwoo->output("tpl/usersEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_USER_CREATE)) {
        $userToEdit = \ICMS\User::createUser($_POST['usrname'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['passwd']);
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($uID)) {
    if ($user->isActionAllowed(PERM_USER_EDIT) or $uID == $user->getUID()) {
        $userToEdit = \ICMS\User::fromUID($uID);
        switch($_GET['field']) {
            case "usrname":
                $userToEdit->setUName($_POST['usrname']);
                break;
            case "firstname":
                $userToEdit->setUFirstName($_POST['firstname']);
                break;
            case "lastname":
                $userToEdit->setUlastName($_POST['lastname']);
                break;
            case "passwd":
                $userToEdit->setUPassHash($_POST['passwd']);
                break;
            case "email":
                $userToEdit->setUEmail($_POST['email']);
                break;
        }

        $userToEdit->saveChanges();
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $pgdata["edit"] = $userToEdit->asArray();
        $dwoo->output("tpl/usersEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }*/
} elseif($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_TIMELINE_OP_EDIT) || $user->isActionAllowed(PERM_TIMELINE_APPROVE)) {
        $entryToDelete = \ICMS\TimelineEntry::fromvID($vID);
        $entryToDelete->approve();
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_TIMELINE_OP_EDIT) || $user->isActionAllowed(PERM_TIMELINE_APPROVE)) {
        $entryToDelete = \ICMS\TimelineEntry::fromvID($vID);
        $entryToDelete->deny();
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_TIMELINE_OP_DELETE)) {
        $entryToDelete = \ICMS\TimelineEntry::fromvID($vID);
        $entryToDelete->delete();
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_TIMELINE_VIEW)) {
    $pgdata = getEditorPageDataStub("Timeline", $user);
    $entries = \ICMS\TimelineEntry::getAllEntries();
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
        $pgdata["page"]["items"][$i]["permDel"] = +$user->isActionAllowed(PERM_TIMELINE_OP_DELETE);
        $pgdata["page"]["items"][$i]["permApprove"] = +$user->isActionAllowed(PERM_TIMELINE_APPROVE);
    }
    var_dump($pgdata);

    $dwoo->output("tpl/timelineList.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}