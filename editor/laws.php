<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 04.05.2016
     * Time: 20:52
     */

    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    ini_set("diplay_errors", "on");

    require_once '../classes/File.php'; //DB Anbindung
    require_once '../classes/PDO_MYSQL.php'; //DB Anbindung
    require_once '../classes/User.php';
    require_once '../classes/Permissions.php';
    require_once '../classes/Util.php';
    require_once '../classes/Law.php';
    require_once '../classes/Tag.php';
    require_once '../libs/Mobile_Detect.php'; // Mobile Detect
    require_once '../libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden

    $user = \ICMS\Util::checkSession();
    $pdo = new \ICMS\PDO_MYSQL();
    $detect = new Mobile_Detect;
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

    $action = $_GET['action'];
    $lwID    = $_GET['lwID'];

    if($action == "new") {
        if ($user->isActionAllowed(PERM_LAWS_CREATE)) {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetz erstellen", $user, false, true, "laws.php?filter=Offen&sort=descID");
            $entries = \ICMS\File::getAllFiles("ascName");
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgdata["files"][$i] = $entries[$i]->asArray();
            }
            $dwoo->output("tpl/lawsNew.tpl", $pgdata);
            exit; //To not show the list
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetz erstellen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "postNew") {
        if ($user->isActionAllowed(PERM_LAWS_CREATE)) {
            \ICMS\Law::createNew($_POST["lwNum"], $_POST["title"], $_POST["name"], str_replace("f", "",$_POST["file"]), $_POST["text"], $user, \ICMS\Tag::TagNameArrayToTagIDArray($_POST["tags"]));
            \ICMS\Util::forwardTo("laws.php?sort=descID");
            exit;
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetz erstellen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "edit" and is_numeric($lwID)) {
        if ($user->isActionAllowed(PERM_LAWS_EDIT)) {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetz bearbeiten", $user, false, true, "laws.php?filter=Offen&sort=descID");
            $entries = \ICMS\File::getAllFiles("ascName");
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgdata["files"][$i] = $entries[$i]->asArray();
            }
            $lawToEdit = \ICMS\Law::fromLWID($lwID);
            $pgdata["edit"] = $lawToEdit->asArray();
            $dwoo->output("tpl/lawsEdit.tpl", $pgdata);
            exit; //To not show the list
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetz bearbeiten", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "postEdit" and is_numeric($lwID)) {
        if ($user->isActionAllowed(PERM_LAWS_EDIT)) {
            $lawToEdit = \ICMS\Law::fromLWID($lwID);
            $lawToEdit->saveChanges($_POST["title"], str_replace("f", "", $_POST["file"]), $_POST["text"], \ICMS\Tag::TagNameArrayToTagIDArray($_POST["tags"]));
            \ICMS\Util::forwardTo("laws.php?sort=descID"); 
            exit;
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetz erstellen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "del" and is_numeric($lwID)) {
        if($user->isActionAllowed(PERM_LAWS_DELETE)) {
            $applToDelete = \ICMS\Law::fromLWID($lwID);
            $applToDelete->delete();
            \ICMS\Util::forwardTo("laws.php?sort=descID");
            exit;
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetze", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "getTags") {
        $tags = \ICMS\Tag::getAllTagsAsArray();
        echo json_encode($tags);
        exit;
    }

    if($user->isActionAllowed(PERM_LAWS_VIEW)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetze", $user);
        $laws = \ICMS\Law::getAllLaws($_GET["sort"]);
        for ($i = 0; $i < sizeof($laws); $i++) {
            $pgdata["page"]["items"][$i] = $laws[$i]->asArray();
        }

        if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "descID";

        $dwoo->output("tpl/lawsList.tpl", $pgdata);
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Gesetze", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }