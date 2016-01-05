<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 21.11.2015
 * Time: 17:52
 */

error_reporting(E_WARNING);
ini_set("diplay_errors", "on");

require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Permissions.php';
require_once '../php/main.php';

$user = checkSession();
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$uID    = $_GET['uID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_USER_CREATE)) {
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
        $pgdata["perm"] = $userToEdit->getPermAsArray();
        $dwoo->output("tpl/usersEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_USER_CREATE)) {
        $userToEdit = \ICMS\User::createUser($_POST['usrname'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['passwd']);
        forwardTo("users.php");
        exit;
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
        forwardTo("users.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_DELETE)) {
        $userToDelete = \ICMS\User::fromUID($uID);
        $userToDelete->delete();
        forwardTo("users.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "updatePerms" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_EDIT_PERMISSIONS)) {
        $userToEdit = \ICMS\User::fromUID($uID);
        foreach($_POST as $key => $value) {
            $userToEdit->setPermission(str_replace("_", ".", $key), $value);
        }
        forwardTo("users.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_USER_VIEW)) {
    $pgdata = getEditorPageDataStub("Benutzer", $user);
    $users = \ICMS\User::getAllUsers();
    for ($i = 0; $i < sizeof($users); $i++) {
        $pgdata["page"]["items"][$i] = $users[$i]->asArray();
    }

    $dwoo->output("tpl/users.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}