<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 21.11.2015
 * Time: 17:52
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

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
$uID    = $_GET['uID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_USER_CREATE)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user, false, true, "users.php");
        $dwoo->output("tpl/usersNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($uID)) {
    if ($user->isActionAllowed(PERM_USER_EDIT) or $uID == $user->getUID()) {
        $userToEdit = \ICMS\User::fromUID($uID);
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user, true, false, "users.php");
        $pgdata["edit"] = $userToEdit->asArray();
        $pgdata["perm"] = $userToEdit->getPermAsArray();
        $pgdata["permU"] = $user->getPermAsArray();
        $dwoo->output("tpl/usersEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_USER_CREATE)) {
        $userToEdit = \ICMS\User::createUser($_POST['usrname'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['passwd']);
        forwardTo("users.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_EDIT) or $uID == $user->getUID()) {
        $userToEdit = \ICMS\User::fromUID($uID);
        switch($_GET['field']) {
            case "all":
                if($_POST['usrname'] != null)$userToEdit->setUName($_POST['usrname']);
                if($_POST['firstname'] != null)$userToEdit->setUFirstName($_POST['firstname']);
                if($_POST['lastname'] != null)$userToEdit->setUlastName($_POST['lastname']);
                if($_POST['email'] != null)$userToEdit->setUEmail($_POST['email']);
                $userToEdit->setUPrefix($_POST['lvl']);
                break;
            case "passwd":
                if($_POST['passwd'] == $_POST['passwd2'])
                    $userToEdit->setUPassHash($_POST['passwd']);
                else {
                    echo "Passwörter stimmen nicht überein!";
                    exit;
                }
                break;
        }

        $userToEdit->saveChanges();
        \ICMS\Util::forwardTo("users.php?action=edit&uID=".$uID);
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_DELETE)) {
        $userToDelete = \ICMS\User::fromUID($uID);
        $userToDelete->delete();
        \ICMS\Util::forwardTo("users.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "updatePerms" and is_numeric($uID)) {
    if($user->isActionAllowed(PERM_USER_EDIT_PERMISSIONS)) {
        $userToEdit = \ICMS\User::fromUID($uID);
        foreach($_POST as $key => $value) {
            $userToEdit->setPermission(str_replace("_", ".", $key), $value);
        }
        \ICMS\Util::forwardTo("users.php?action=edit&uID".$uID);
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_USER_VIEW)) {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
    $users = \ICMS\User::getAllUsers($_GET["sort"], $_GET["filter"]);
    for ($i = 0; $i < sizeof($users); $i++) {
        $pgdata["page"]["items"][$i] = $users[$i]->asArray();
    }
    if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "ascName";
    if(isset($_GET["filter"])) $pgdata["page"]["filter"] = $_GET["filter"]; else $pgdata["page"]["filter"] = "Alle";

    $dwoo->output("tpl/users.tpl", $pgdata);
} else {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}