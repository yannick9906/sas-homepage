<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 23.02.2016
     * Time: 18:52
     */

    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    ini_set("diplay_errors", "on");

    require_once '../classes/File.php'; //DB Anbindung
    require_once '../classes/PDO_MYSQL.php'; //DB Anbindung
    require_once '../classes/User.php';
    require_once '../classes/Permissions.php';
    require_once '../classes/Util.php';
    require_once '../classes/ApplicationEntry.php';
    require_once '../classes/Tag.php';
    require_once '../libs/Mobile_Detect.php'; // Mobile Detect
    require_once '../libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden

    $user = \ICMS\Util::checkSession();
    $pdo = new \ICMS\PDO_MYSQL();
    $detect = new Mobile_Detect;
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

    $action = $_GET['action'];
    $aID    = $_GET['aID'];

    if($action == "new") {
        if ($user->isActionAllowed(PERM_APPLICATION_CREATE)) {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Antrag erstellen", $user, false, true, "applications.php?filter=Offen&sort=descID");
            $entries = \ICMS\File::getAllFiles("ascName");
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgdata["files"][$i] = $entries[$i]->asArray();
            }
            $dwoo->output("tpl/applicationNew.tpl", $pgdata);
            exit; //To not show the list
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Antrag erstellen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "postNew") {
        if ($user->isActionAllowed(PERM_APPLICATION_CREATE)) {
            \ICMS\ApplicationEntry::createNew($_POST["aNum"], $_POST["state"], $_POST["title"], $_POST["name"], str_replace("f", "",$_POST["file"]), $_POST["text"], $user, \ICMS\Tag::TagNameArrayToTagIDArray($_POST["tags"]));
            \ICMS\Util::forwardTo("applications.php?filter=Offen&sort=descID");
            exit;
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Antrag erstellen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "edit" and is_numeric($aID)) {
        if ($user->isActionAllowed(PERM_APPLICATION_EDIT)) {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Antrag bearbeiten", $user, false, true, "applications.php?filter=Offen&sort=descID");
            $entries = \ICMS\File::getAllFiles("ascName");
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgdata["files"][$i] = $entries[$i]->asArray();
            }
            $applToEdit = \ICMS\ApplicationEntry::fromAID($aID);
            $pgdata["edit"] = $applToEdit->asArray();
            $dwoo->output("tpl/applicationEdit.tpl", $pgdata);
            exit; //To not show the list
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Antrag bearbeiten", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "postEdit" and is_numeric($aID)) {
        if ($user->isActionAllowed(PERM_APPLICATION_EDIT)) {
            $applToEdit = \ICMS\ApplicationEntry::fromAID($aID);
            $applToEdit->saveChanges($_POST["state"], $_POST["title"],  str_replace("f", "",$_POST["file"]), $_POST["text"], \ICMS\Tag::TagNameArrayToTagIDArray($_POST["tags"]));
            \ICMS\Util::forwardTo("applications.php?filter=Offen&sort=descID");
            exit;
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Antrage erstellen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif(($action == "accept" or $action == "deny" or $action == "reopen") and is_numeric($aID)) {
        if ($user->isActionAllowed(PERM_APPLICATION_EDIT)) {
            $applToEdit = \ICMS\ApplicationEntry::fromAID($aID);
            switch ($action) {
                case "accept":
                    $applToEdit->changeState(1);
                    break;
                case "deny":
                    $applToEdit->changeState(2);
                    break;
                case "reopen":
                    $applToEdit->changeState(0);
                    break;
                default:
                    break;
            }
            \ICMS\Util::forwardTo("applications.php?filter=Offen&sort=descID");
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Antrage erstellen", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "del" and is_numeric($aID)) {
        if($user->isActionAllowed(PERM_APPLICATION_DELETE)) {
            $applToDelete = \ICMS\ApplicationEntry::fromAID($aID);
            $applToDelete->delete();
            \ICMS\Util::forwardTo("applications.php?filter=Offen&sort=descID");
            exit;
        } else {
            $pgdata = \ICMS\Util::getEditorPageDataStub("Anträge", $user);
            $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
            exit;
        }
    } elseif($action == "getTags") {
        $tags = \ICMS\Tag::getAllTagsAsArray();
        echo json_encode($tags);
        exit;
    }

    if($user->isActionAllowed(PERM_APPLICATION_VIEW)) {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Anträge", $user);
        $applications = \ICMS\ApplicationEntry::getAllApplications($_GET["sort"], $_GET["filter"]);
        for ($i = 0; $i < sizeof($applications); $i++) {
            $pgdata["page"]["items"][$i] = $applications[$i]->asArray();
        }

        if(isset($_GET["sort"])) $pgdata["page"]["sort"] = $_GET["sort"]; else $pgdata["page"]["sort"] = "descID";
        if(isset($_GET["filter"])) $pgdata["page"]["filter"] = $_GET["filter"]; else $pgdata["page"]["filter"] = "Alle";

        $dwoo->output("tpl/applicationList.tpl", $pgdata);
    } else {
        $pgdata = \ICMS\Util::getEditorPageDataStub("Anträge", $user);
        $dwoo->output("tpl/noPrivileges.tpl", $pgdata);
    }