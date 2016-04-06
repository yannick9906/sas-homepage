<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 23.02.2016
 * Time: 18:53
 */
error_reporting(E_ERROR);
ini_set("display_errors", 1);

require_once '../classes/Protocol.php';
require_once '../classes/File.php';
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
$vID = $_GET['vID'];
$prID = $_GET['prID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_PROTOCOLS_CREATE)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user, false, true, "protocols.php");
        $entries = \ICMS\File::getAllFiles();
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["files"][$i] = $entries[$i]->asArray();
        }
        $dwoo->output("tpl/protocolNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_PROTOCOLS_CREATE)) {
        $timelineCreated = \ICMS\Protocol::createEntry($user, $_POST['date'], $_POST['title'], $_POST['fileID'], $_POST['type']);
        \ICMS\Util::forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($prID)) {
    if ($user->isActionAllowed(PERM_PROTOCOLS_NEW_VERSION)) {
        $protocolToEdit = \ICMS\Protocol::fromPRID($prID);
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user, false, true, "protocols.php");
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
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
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
        \ICMS\Util::forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }/**/
} elseif($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_OP_EDIT) || $user->isActionAllowed(PERM_PROTOCOLS_APPROVE)) {
        $entryToDelete = \ICMS\Protocol::fromVID($vID);
        $entryToDelete->approve();
        \ICMS\Util::forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_OP_EDIT) || $user->isActionAllowed(PERM_PROTOCOLS_APPROVE)) {
        $entryToDelete = \ICMS\Protocol::fromVID($vID);
        $entryToDelete->deny();
        \ICMS\Util::forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_OP_DELETE)) {
        $entryToDelete = \ICMS\Protocol::fromvID($vID);
        $entryToDelete->delete();
        \ICMS\Util::forwardTo("protocols.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "vers" and is_numeric($prID)) {
    if($user->isActionAllowed(PERM_PROTOCOLS_VIEW)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Timeline Versionen", $user, true, false, "protocols.php");
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
        $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_PROTOCOLS_VIEW)) {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
    $entries = \ICMS\Protocol::getAllEntries($_GET["sort"], $_GET["filter"]);
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
    }

    if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "ascName";
    if(isset($_GET["filter"])) $pgdata["page"]["filter"] = str_replace("+", "%2B",$_GET["filter"]); else $pgdata["page"]["filter"] = "Alle";

    $dwoo->output("tpl/protocolList.tpl", $pgdata);
} else {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Protokolle", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}

