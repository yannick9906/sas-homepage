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
$tID = $_GET['tID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_TIMELINE_CREATE)) {
        $pgdata = getEditorPageDataStub("Timeline", $user, false, true, "timeline.php");
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["sites"][$i] = $entries[$i]->asArray();
        }
        $dwoo->output("tpl/timelineNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_TIMELINE_CREATE)) {
        if($_POST["lnkType"] == "rdNo") $link = "";
        elseif($_POST["lnkType"] == "rdExt") $link = $_POST["inExt"];
        elseif($_POST["lnkType"] == "rdInt") $link = ""; //TODO

        $timelineCreated = \ICMS\TimelineEntry::createEntry($user, $_POST['date'], $_POST['title'], $_POST['text'], $link, $_POST['type']);
        forwardTo("timeline.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($tID)) {
    if ($user->isActionAllowed(PERM_TIMELINE_NEW_VERSION)) {
        $timelineToEdit = \ICMS\TimelineEntry::fromTID($tID);
        $pgdata = getEditorPageDataStub("Timeline", $user, false, true, "timeline.php");
        $tml = $timelineToEdit->asArray();
        $tml["text"] = $timelineToEdit->getInfo();
        $tml["date"] = str_replace("+02:00","",str_replace("+01:00", "", date(DATE_W3C ,$timelineToEdit->getDate())));
        $pgdata["edit"] = $tml;

        if($timelineToEdit->getLink() == null or "") {
            $pgdata["edit"]["linkType"] = "lnkNo";
        } else {
            if(substr($timelineToEdit->getLink(), 0, 5 ) === "int::") {
                $pgdata["edit"]["linkType"] = "lnkInt";
                $pgdata["edit"]["lnkVal"] = str_replace("int::", "", $timelineToEdit->getLink());
            } else {
                $pgdata["edit"]["linkType"] = "lnkExt";
                $pgdata["edit"]["linkTo"] = $timelineToEdit->getLink();
            }
        }


        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["sites"][$i] = $entries[$i]->asArray();
        }
        $dwoo->output("tpl/timelineEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($tID)) {
    if ($user->isActionAllowed(PERM_TIMELINE_NEW_VERSION)) {
        //var_dump($_POST);
        $timelineToEdit = \ICMS\TimelineEntry::fromTID($tID);
        $timelineToEdit->setTitle($_POST["title"]);
        $timelineToEdit->setInfo($_POST["text"]);
        $timelineToEdit->setDate(strtotime($_POST["date"]));
        if($_POST["lnkType"] == "rdNo") $timelineToEdit->setLink("");
        elseif($_POST["lnkType"] == "rdExt") $timelineToEdit->setLink($_POST["lnkExtern"]);
        elseif($_POST["lnkType"] == "rdInt") $timelineToEdit->setLink(""); //TODO
        $timelineToEdit->setType($_POST["type"]);

        $timelineToEdit->saveAsNewVersion($user);
        forwardTo("timeline.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }/**/
} elseif($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_TIMELINE_OP_EDIT) || $user->isActionAllowed(PERM_TIMELINE_APPROVE)) {
        $entryToDelete = \ICMS\TimelineEntry::fromvID($vID);
        $entryToDelete->approve();
        forwardTo("timeline.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_TIMELINE_OP_EDIT) || $user->isActionAllowed(PERM_TIMELINE_APPROVE)) {
        $entryToDelete = \ICMS\TimelineEntry::fromvID($vID);
        $entryToDelete->deny();
        forwardTo("timeline.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_TIMELINE_OP_DELETE)) {
        $entryToDelete = \ICMS\TimelineEntry::fromvID($vID);
        $entryToDelete->delete();
        forwardTo("timeline.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "vers" and is_numeric($tID)) {
    if($user->isActionAllowed(PERM_TIMELINE_VIEW)) {
        $pgdata = getEditorPageDataStub("Timeline Versionen", $user, true, false, "timeline.php");
        $entries = \ICMS\TimelineEntry::getAllVersions($tID);
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
            $pgdata["page"]["items"][$i]["index"] = $i;
            $pgdata["page"]["items"][$i]["negIndex"] = sizeof($entries)-1 - $i;
            if(($i == 0 or $entries[$i - 1]->getState() != 0) && $hadlive == 0) {
                if($entries[$i]->getState() == 0) $hadlive = 1;
                $pgdata["page"]["items"][$i]["index"] = 0;
            } else {
                $pgdata["page"]["items"][$i]["stateCSS"] = "grey-text";
                $pgdata["page"]["items"][$i]["stateText"] = "history";
            }
        }
        //$pgdata["perm"] = $user->getPermAsArray();

        $dwoo->output("tpl/timelineVersions.tpl", $pgdata);
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Timeline", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_TIMELINE_VIEW)) {
    $pgdata = getEditorPageDataStub("Timeline", $user);
    $entries = \ICMS\TimelineEntry::getAllEntries();
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
        $pgdata["page"]["items"][$i]["permDel"] = +$user->isActionAllowed(PERM_TIMELINE_OP_DELETE);
        $pgdata["page"]["items"][$i]["permApprove"] = +$user->isActionAllowed(PERM_TIMELINE_APPROVE);
    }

    $dwoo->output("tpl/timelineList.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("Timeline", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}