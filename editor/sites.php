<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 07.01.2016
 * Time: 15:32
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once '../classes/PDO_MYSQL.php'; //DB Anbindung
require_once '../classes/User.php';
require_once '../classes/Permissions.php';
require_once '../classes/Util.php';
require_once '../classes/User.php';
require_once '../classes/Site.php';
require_once '../classes/TypeNormal.php';
require_once '../classes/TypeAK.php';
require_once '../classes/TypeParty.php';
require_once '../libs/Mobile_Detect.php'; // Mobile Detect
require_once '../libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once '../libs/simplediff.php';

$user = \ICMS\Util::checkSession();
$pdo = new \ICMS\PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
echo $vID = $_GET['vID'];
$pID = $_GET['pID'];

if($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_SITE_OP_EDIT) || $user->isActionAllowed(PERM_SITE_APPROVE)) {
        $entryToDelete = \ICMS\Site::fromvID($vID);
        $entryToDelete->approve();
        \ICMS\Util::forwardTo("sites.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seiten", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_SITE_OP_EDIT) || $user->isActionAllowed(PERM_SITE_APPROVE)) {
        $entryToDelete = \ICMS\Site::fromvID($vID);
        $entryToDelete->deny();
        \ICMS\Util::forwardTo("sites.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seiten", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "vers" and is_numeric($pID)) {
    if($user->isActionAllowed(PERM_SITE_VIEW)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seiten Versionen", $user, true, false, "sites.php");
        $entries = \ICMS\Site::getAllVersions($pID);
        $hadlive = 0;
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
            $pgdata["page"]["items"][$i]["index"] = $i;
            $pgdata["page"]["items"][$i]["negIndex"] = sizeof($entries)-1 - $i;
            if(($i == 0 or $entries[$i - 1]->getState() != 0) && $hadlive == 0) {
                if($entries[$i]->getState() == 0) $hadlive = 1;
                $pgdata["page"]["items"][$i]["index"] = 0;
            } else {
                $pgdata["page"]["items"][$i]["stateCSS"] = "disabled";
                $pgdata["page"]["items"][$i]["stateText"] = "backup-restore";
            }
        }
        //$pgdata["perm"] = $user->getPermAsArray();

        $dwoo->output("tpl/sitesVersions.tpl", $pgdata);
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seiten Versionen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "diff" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_SITE_VIEW)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seiten Versionen", $user, true, false, "sites.php");
        $page1 = \ICMS\Site::fromVID($vID)->toTypeObject();
        $page2 = \ICMS\Site::getSiteVersionBefore($vID)->toTypeObject();

        $pgdata["diff"] = $page2->makeDiff($page1);

        $pgdata["diff"]["v1"] = $page1->getVersion();
        $pgdata["diff"]["v2"] = $page2->getVersion();

        $dwoo->output($page1->getTplLinkV(), $pgdata);
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seiten Versionen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_SITE_OP_DELETE)) {
        $entryToDelete = \ICMS\Site::fromvID($vID);
        $entryToDelete->delete();
        \ICMS\Util::forwardTo("sites.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("Seite löschen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "new") {
    if ($user->isActionAllowed(PERM_SITE_CREATE)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seite erstellen", $user, false, true, "sites.php");
        $pgdata["page"]["type"] = $_GET["type"];
        $dwoo->output("tpl/sitesNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seite erstellen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_SITE_CREATE)) {

        $timelineCreated = \ICMS\Site::createNew($_POST['name'], $_POST['type'], $user);
        \ICMS\Util::forwardTo("sites.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seite erstellen", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($pID)) {
    if ($user->isActionAllowed(PERM_SITE_NEW_VERSION_ALL) or ($user->isActionAllowed(PERM_SITE_NEW_VERSION_OWN) and \ICMS\Site::fromPID($pID)->getAuthor() == $user->getUID())) {
        $siteToEdit = \ICMS\Site::fromPID($pID)->toTypeObject();
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seite bearbeiten", $user, false, true, "sites.php");
        $site = $siteToEdit->asArray();
        $pgdata["edit"] = $site;
        $dwoo->output($siteToEdit->getTplLink(), $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seite bearbeiten", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($pID)) {
    if ($user->isActionAllowed(PERM_SITE_NEW_VERSION_ALL) or ($user->isActionAllowed(PERM_SITE_NEW_VERSION_OWN) and \ICMS\Site::fromPID($pID)->getAuthor() == $user->getUID())) {
        var_dump($_POST);
        $siteToEdit = \ICMS\Site::fromPID($pID)->toTypeObject();
        switch($siteToEdit->getType()) {
            case 0:
                $siteToEdit->setTitle($_POST["title"]);
                $siteToEdit->setName($_POST["name"]);
                $siteToEdit->setText($_POST["text"]);
                break;
            case 1:
                $siteToEdit->setName($_POST["name"]);
                $siteToEdit->setImg($_POST["image"]);
                $siteToEdit->setIcon($_POST["icon"]);
                $siteToEdit->setShort($_POST["short"]);
                $siteToEdit->setText($_POST["text"]);
                break;
            case 2:
                $siteToEdit->setName($_POST["name"]);
                $siteToEdit->setImg($_POST["image"]);
                $siteToEdit->setIcon($_POST["icon"]);
                $siteToEdit->setShort($_POST["short"]);
                $siteToEdit->setText($_POST["text"]);
                break;
        }

        $siteToEdit->saveAsNewVersion($user);
        \ICMS\Util::forwardTo("sites.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Seite bearbeiten", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }/**/
}

if($user->isActionAllowed(PERM_SITE_VIEW)) {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Seiten", $user);
    $entries = \ICMS\Site::getAllSites($_GET["sort"], $_GET["filter"]);
    //var_dump($entries);
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
    }

    if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "ascName";
    if(isset($_GET["filter"])) $pgdata["page"]["filter"] = str_replace("+", "%2B",$_GET["filter"]); else $pgdata["page"]["filter"] = "Alle";

    $dwoo->output("tpl/sitesList.tpl", $pgdata);
} else {
    $pgdata = \ICMS\Util::getEditorPageDataStub("Benutzer", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}