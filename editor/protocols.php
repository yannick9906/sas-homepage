<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 23.02.2016
 * Time: 18:53
 */
error_reporting(E_ERROR);
ini_set("display_errors", 1);

require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Protocol.php';
require_once 'classes/File.php';
require_once 'classes/Permissions.php';
require_once '../php/main.php';

$user = checkSession();
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$vID = $_GET['vID'];
$prID = $_GET['prID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_PROTOCOLS_CREATE)) {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $entries = \ICMS\File::getAllFiles();
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["files"][$i] = $entries[$i]->asArray();
        }
        $dwoo->output("tpl/protocolNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_PROTOCOLS_CREATE)) {
        $timelineCreated = \ICMS\Protocol::createEntry($user, $_POST['date'], $_POST['title'], $_POST['fileID'], $_POST['type']);
        forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($prID)) {
    if ($user->isActionAllowed(PERM_PROTOCOLS_NEW_VERSION)) {
        $protocolToEdit = \ICMS\Protocol::fromPRID($prID);
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $tml = $protocolToEdit->asArray();
        $tml["date"] = date("Y-m-d" ,$protocolToEdit->getDate());
        $pgdata["edit"] = $tml;

        $entries = \ICMS\File::getAllFiles();
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["files"][$i] = $entries[$i]->asArray();
        }
        $dwoo->output("tpl/protocolEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($prID)) {
    if ($user->isActionAllowed(PERM_PROTOCOLS_NEW_VERSION)) {
        $protocolToEdit = \ICMS\Protocol::fromPRID($prID);
        $protocolToEdit->setName($_POST["title"]);
        $protocolToEdit->setDate(strtotime($_POST["date"]));
        $protocolToEdit->setType($_POST["type"]);
        $protocolToEdit->setFileID($_POST["fileID"]);

        $protocolToEdit->saveAsNewVersion($user);
        forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }/**/
} elseif($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_OP_EDIT) || $user->isActionAllowed(PERM_PROTOCOLS_APPROVE)) {
        $entryToDelete = \ICMS\Protocol::fromVID($vID);
        $entryToDelete->approve();
        forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_OP_EDIT) || $user->isActionAllowed(PERM_PROTOCOLS_APPROVE)) {
        $entryToDelete = \ICMS\Protocol::fromVID($vID);
        $entryToDelete->deny();
        forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_OP_DELETE)) {
        $entryToDelete = \ICMS\Protocol::fromvID($vID);
        $entryToDelete->delete();
        forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "vers" and is_numeric($prID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_VIEW)) {
        $pgdata = getEditorPageDataStub("Timeline Versionen", $user);
        $entries = \ICMS\TimelineEntry::getAllVersions($prID);
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
            $pgdata["page"]["items"][$i]["permDel"] = +$user->isActionAllowed(PERM_TIMELINE_OP_DELETE);
            $pgdata["page"]["items"][$i]["permApprove"] = +$user->isActionAllowed(PERM_TIMELINE_APPROVE);
            if($i != 0 && $entries[$i - 1]->getState() == 0) {
                $pgdata["page"]["items"][$i]["stateCSS"] = "disabled";
                $pgdata["page"]["items"][$i]["stateText"] = "alt";
            }
        }
        //$pgdata["perm"] = $user->getPermAsArray();

        $dwoo->output("tpl/timelineVersions.tpl", $pgdata);
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_PROTOCOLS_VIEW)) {
    $pgdata = getEditorPageDataStub("Protokolle", $user);
    $entries = \ICMS\Protocol::getAllEntries();
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
    }

    $dwoo->output("tpl/protocolList.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("Protokolle", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}

