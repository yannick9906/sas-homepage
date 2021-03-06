<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 14.02.2016
 * Time: 03:10
 */

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

require_once '../classes/Site.php';
require_once '../classes/NewsEntry.php';
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
$nID = $_GET['nID'];

if($action == "new") {
    if ($user->isActionAllowed(PERM_NEWS_CREATE)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user, false, true, "news.php");
        $entries = \ICMS\Site::getAllSites();
        for ($i = 0; $i < sizeof($entries); $i++) {
            $pgdata["sites"][$i] = $entries[$i]->asArray();
        }
        $dwoo->output("tpl/newsNew.tpl", $pgdata);
        exit; //To not show the list
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postNew") {
    if ($user->isActionAllowed(PERM_NEWS_CREATE)) {
        if($_POST["lnkType"] == "rdNo") $link = "";
        elseif($_POST["lnkType"] == "rdExt") $link = $_POST["lnkExtern"];
        elseif($_POST["lnkType"] == "rdInt") $link = ""; //TODO

        $newsCreated = \ICMS\NewsEntry::createEntry($user, date("Y-m-d H:i:s"), $_POST['title'], $_POST['text'], $link);
        \ICMS\Util::forwardTo("news.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "edit" and is_numeric($nID)) {
    if ($user->isActionAllowed(PERM_NEWS_NEW_VERSION)) {
        $newsToEdit = \ICMS\NewsEntry::fromNID($nID);
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user, false, true, "news.php");

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
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "postEdit" and is_numeric($nID)) {
    if ($user->isActionAllowed(PERM_NEWS_NEW_VERSION)) {
        $newsToEdit = \ICMS\NewsEntry::fromNID($nID);
        $newsToEdit->setTitle($_POST["title"]);
        $newsToEdit->setText($_POST["text"]);
        $newsToEdit->setDate(date("Y-m-d H:i:s"));
        if($_POST["lnkType"] == "rdNo") $newsToEdit->setLink("");
        elseif($_POST["lnkType"] == "rdExt") $newsToEdit->setLink($_POST["lnkExtern"]);
        elseif($_POST["lnkType"] == "rdInt") $newsToEdit->setLink("int::".$_POST["lnkIntern"]);
        echo $newsToEdit->getLink();
        $newsToEdit->saveAsNewVersion($user);
        \ICMS\Util::forwardTo("news.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }/**/
} elseif($action == "approve" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_NEWS_OP_EDIT) || $user->isActionAllowed(PERM_NEWS_APPROVE)) {
        $entryToDelete = \ICMS\NewsEntry::fromvID($vID);
        $entryToDelete->approve();
        \ICMS\Util::forwardTo("news.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "deny" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_NEWS_OP_EDIT) || $user->isActionAllowed(PERM_NEWS_APPROVE)) {
        $entryToDelete = \ICMS\NewsEntry::fromvID($vID);
        $entryToDelete->deny();
        \ICMS\Util::forwardTo("news.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "del" and is_numeric($vID)) {
    if($user->isActionAllowed(PERM_NEWS_OP_DELETE)) {
        $entryToDelete = \ICMS\NewsEntry::fromvID($vID);
        $entryToDelete->delete();
        \ICMS\Util::forwardTo("news.php");
        exit;
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
} elseif($action == "vers" and is_numeric($nID)) {
    if($user->isActionAllowed(PERM_NEWS_VIEW)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("News Versionen", $user, true, false, "news.php");
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
        $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }
}

if($user->isActionAllowed(PERM_NEWS_VIEW)) {
    $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
    $entries = \ICMS\NewsEntry::getAllEntries($_GET["sort"], $_GET["filter"]);
    //var_dump($entries);
    for ($i = 0; $i < sizeof($entries); $i++) {
        $pgdata["page"]["items"][$i]["index"] = $i;
        $pgdata["page"]["items"][$i] = $entries[$i]->asArray();
        $pgdata["page"]["items"][$i]["permDel"] = +$user->isActionAllowed(PERM_NEWS_OP_DELETE);
        $pgdata["page"]["items"][$i]["permApprove"] = +$user->isActionAllowed(PERM_NEWS_APPROVE);
    }

    if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "ascName";
    if(isset($_GET["filter"])) $pgdata["page"]["filter"] = str_replace("+", "%2B",$_GET["filter"]); else $pgdata["page"]["filter"] = "Alle";


    $dwoo->output("tpl/newsList.tpl", $pgdata);
} else {
    $pgdata = \ICMS\Util::getEditorPageDataStub("News", $user);
    $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
}
