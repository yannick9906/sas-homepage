<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 07.01.2016
 * Time: 15:32
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Site.php';
require_once 'classes/Permissions.php';
require_once '../php/main.php';

$user = checkSession();
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$vID = $_GET['vID'];
$pID = $_GET['pID'];

if($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_SITE_OP_EDIT) || $user->isActionAllowed(PERM_SITE_APPROVE)) {
        $entryToDelete = \ICMS\Site::fromvID($vID);
        $entryToDelete->approve();
        forwardTo("sites.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Seiten", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_SITE_OP_EDIT) || $user->isActionAllowed(PERM_SITE_APPROVE)) {
        $entryToDelete = \ICMS\Site::fromvID($vID);
        $entryToDelete->deny();
        forwardTo("sites.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Seiten", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "vers" and is_numeric($pID)) {
    if($user->isActionAllowed(PERM_SITE_VIEW)) {
        $pgdata = getEditorPageDataStub("Seiten Versionen", $user);
        $entries = \ICMS\Site::getAllVersions($pID);
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
            if($i != 0 && $entries[$i - 1]->getState() == 0) {
                $pgdata["page"]["items"][$i]["stateCSS"] = "disabled";
                $pgdata["page"]["items"][$i]["stateText"] = "alt";
            }
        }
        //$pgdata["perm"] = $user->getPermAsArray();

        $dwoo->output("tpl/sitesVersions.tpl", $pgdata);
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Seiten Versionen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "new") {
    if ($user->isActionAllowed(PERM_SITE_CREATE)) {
        $pgdata = getEditorPageDataStub("Seite erstellen", $user);
        $dwoo->output("tpl/sitesNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Seite erstellen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_SITE_CREATE)) {

        var_dump($timelineCreated = \ICMS\Site::createNew($_POST['name'], $_POST['type'], $user));
        //forwardTo("sites.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Seite erstellen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($pID)) {
    if ($user->isActionAllowed(PERM_SITE_NEW_VERSION)) {
        $timelineToEdit = \ICMS\TimelineEntry::fromTID($pID);
        $pgdata = getEditorPageDataStub("Seite bearbeiten", $user);
        $tml = $timelineToEdit->asArray();
        $tml["text"] = $timelineToEdit->getInfo();
        $tml["date"] = str_replace("+01:00", "", date(DATE_W3C ,$timelineToEdit->getDate()));
        var_dump($tml);
        $pgdata["edit"] = $tml;
        $dwoo->output("tpl/timelineEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Seite bearbeiten", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($pID)) {
    if ($user->isActionAllowed(PERM_SITE_NEW_VERSION)) {
        var_dump($_POST);
        $timelineToEdit = \ICMS\TimelineEntry::fromTID($pID);
        $timelineToEdit->setTitle($_POST["title"]);
        $timelineToEdit->setInfo($_POST["text"]);
        $timelineToEdit->setDate(strtotime($_POST["date"]));
        if ($_POST["lnkType"] == "rdNo") $timelineToEdit->setLink("");
        elseif ($_POST["lnkType"] == "rdExt") $timelineToEdit->setLink($_POST["lnkExtern"]);
        elseif ($_POST["lnkType"] == "rdInt") $timelineToEdit->setLink(""); //TODO
        $timelineToEdit->setType($_POST["type"]);

        $timelineToEdit->saveAsNewVersion($user);
        forwardTo("timeline.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }/**/
}


    if($user->isActionAllowed(PERM_SITE_VIEW)) {
    $pgdata = getEditorPageDataStub("Seiten", $user);
    $entries = \ICMS\Site::getAllSites();
    var_dump($entries);
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
    }

    //var_dump($user->getPermAsArray());

    $dwoo->output("tpl/sitesList.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}