<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 14.02.2016
 * Time: 03:10
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once '../php/PDO_MYSQL.class.php'; //DB Anbindung
require_once '../php/Mobile_Detect.php'; // Mobile Detect
require_once '../dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
require_once 'classes/User.php';
require_once 'classes/Site.php';
require_once 'classes/NewsEntry.php';
require_once 'classes/Permissions.php';
require_once '../php/main.php';

$user = checkSession();
$pdo = new PDO_MYSQL();
$detect = new Mobile_Detect;
Dwoo\Autoloader::register();
$dwoo = new Dwoo\Core();

$action = $_GET['action'];
$vID = $_GET['vID'];
$nID = $_GET['nID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_NEWS_CREATE)) {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/newsNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_NEWS_CREATE)) {
        if($_POST["lnkType"] == "rdNo") $link = "";
        elseif($_POST["lnkType"] == "rdExt") $link = $_POST["lnkExtern"];
        elseif($_POST["lnkType"] == "rdInt") $link = ""; //TODO

        $newsCreated = \ICMS\NewsEntry::createEntry($user, date("Y-m-d H:i:s"), $_POST['title'], $_POST['text'], $link);
        forwardTo("news.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($nID)) {
    if ($user->isActionAllowed(PERM_NEWS_NEW_VERSION)) {
        $newsToEdit = \ICMS\NewsEntry::fromNID($nID);
        $pgdata = getEditorPageDataStub("News", $user);

        $tml = $newsToEdit->asArray();
        $tml["text"] = $newsToEdit->getText();
        $pgdata["edit"] = $tml;

        if($newsToEdit->getLink() == null or "") {
            $pgdata["edit"]["linkType"] = "lnkNo";
        } else {
            if(substr($newsToEdit->getLink(), 0, 5 ) === "int::") {
                $pgdata["edit"]["linkType"] = "lnkInt";
                $pgdata["edit"]["lnkVal"] = str_replace("int::", "", $newsToEdit->getLink());
            } else {
                $pgdata["edit"]["linkType"] = "lnkExt";
                $pgdata["edit"]["linkTo"] = $newsToEdit->getLink();
            }
        }

        $entries = \ICMS\Site::getAllSites();
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["sites"][$i] = $entries[$i]->asArray();
        }
        $dwoo->output("tpl/newsEdit.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($nID)) {
    if ($user->isActionAllowed(PERM_NEWS_NEW_VERSION)) {
        $newsToEdit = \ICMS\NewsEntry::fromNID($nID);
        var_dump($_POST);
        $newsToEdit->setTitle($_POST["title"]);
        $newsToEdit->setText($_POST["text"]);
        $newsToEdit->setDate(date("Y-m-d H:i:s"));
        if($_POST["lnkType"] == "rdNo") $newsToEdit->setLink("");
        elseif($_POST["lnkType"] == "rdExt") $newsToEdit->setLink($_POST["lnkExtern"]);
        elseif($_POST["lnkType"] == "rdInt") $newsToEdit->setLink("int::".$_POST["lnkIntern"]);
        echo $newsToEdit->getLink();
        $newsToEdit->saveAsNewVersion($user);
        //forwardTo("news.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }/**/
} elseif($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_NEWS_OP_EDIT) || $user->isActionAllowed(PERM_NEWS_APPROVE)) {
        $entryToDelete = \ICMS\NewsEntry::fromvID($vID);
        $entryToDelete->approve();
        forwardTo("news.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_NEWS_OP_EDIT) || $user->isActionAllowed(PERM_NEWS_APPROVE)) {
        $entryToDelete = \ICMS\NewsEntry::fromvID($vID);
        $entryToDelete->deny();
        forwardTo("news.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_NEWS_OP_DELETE)) {
        $entryToDelete = \ICMS\NewsEntry::fromvID($vID);
        $entryToDelete->delete();
        forwardTo("news.php");
        exit;
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "vers" and is_numeric($nID)) {
    if($user->isActionAllowed(PERM_NEWS_VIEW)) {
        $pgdata = getEditorPageDataStub("News Versionen", $user);
        $entries = \ICMS\NewsEntry::getAllVersions($nID);
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
            $pgdata["page"]["items"][$i]["permDel"] = +$user->isActionAllowed(PERM_NEWS_OP_DELETE);
            $pgdata["page"]["items"][$i]["permApprove"] = +$user->isActionAllowed(PERM_NEWS_APPROVE);
            if($i != 0 && $entries[$i - 1]->getState() == 0) {
                $pgdata["page"]["items"][$i]["stateCSS"] = "disabled";
                $pgdata["page"]["items"][$i]["stateText"] = "alt";
            }
        }
        //$pgdata["perm"] = $user->getPermAsArray();

        $dwoo->output("tpl/newsVersions.tpl", $pgdata);
        exit;
    } else {
        $pgdata = getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_NEWS_VIEW)) {
    $pgdata = getEditorPageDataStub("News", $user);
    $entries = \ICMS\NewsEntry::getAllEntries();
    //var_dump($entries);
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
        $pgdata["page"]["items"][$i]["permDel"] = +$user->isActionAllowed(PERM_NEWS_OP_DELETE);
        $pgdata["page"]["items"][$i]["permApprove"] = +$user->isActionAllowed(PERM_NEWS_APPROVE);
    }

    $dwoo->output("tpl/newsList.tpl", $pgdata);
} else {
    $pgdata = getEditorPageDataStub("News", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}
