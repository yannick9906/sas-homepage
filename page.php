<?php

    error_reporting(E_ERROR);
    ini_set("diplay_errors", "on");

    $pg = $_POST['p']; // ID der Seite
    if (!is_numeric($pg)) $pg = 0; // Prüfe ob es eine Zahl ist
    require_once 'libs/Mobile_Detect.php'; // Mobile Detect
    require_once 'libs/Parsedown.php'; // Parsedown
    require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    require_once 'classes/Tag.php';
    require_once 'classes/Law.php';
    require_once 'classes/ApplicationEntry.php';
    require_once 'classes/TimelineEntry.php';
    require_once 'classes/NewsEntry.php';
    require_once 'classes/PDO_MYSQL.php';
    require_once 'classes/Site.php';
    require_once 'classes/User.php';
    require_once 'classes/Token.php';
    require_once 'classes/File.php';
    require_once 'classes/Protocol.php';
    require_once 'classes/TypeNormal.php';
    require_once 'classes/TypeAK.php';
    require_once 'classes/TypeParty.php';
    require_once 'classes/Util.php';
    $pdo = new \ICMS\PDO_MYSQL();
    $detect = new Mobile_Detect;
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

    if ($_SERVER['REMOTE_ADDR'] == "84.132.121.2") {
        http_response_code(403);
    }
    switch ($pg) {
        case 0: //Home
            //Naechster Termin
            $entries = \ICMS\TimelineEntry::getAllPublicEntries();
            $timestamp = $entries[0]->getDate();
            if ($timestamp == mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp))) $evDate = \ICMS\Util::dbDateToReadableWithOutTime($timestamp); else
                $evDate = \ICMS\Util::dbDateToReadableWithTime($timestamp);
            $evTitle = $entries[0]->getTitle();

            //Spruch der Woche
            $res = $pdo->query("SELECT * FROM schlopolis_sow WHERE week = :w", [":w" => date('W')]);
            $spWeek = $res->week;
            $spText = $res->text;

            //Dwoo
            $pgData = ["header" => ["title" => "Home"], "page" => ["evDate" => $evDate, "evTitle" => $evTitle, "spWeek" => $spWeek, "spText" => $spText, "items" => []]];

            $entries = \ICMS\TimelineEntry::getAllPublicEntries(5);
            for ($i = 0; $i < sizeof($entries); $i++) {
                $timestamp = $entries[$i]->getDate();
                if ($timestamp == mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp))) $evDate = \ICMS\Util::dbDateToReadableWithOutTime($timestamp); else
                    $evDate = \ICMS\Util::dbDateToReadableWithTime($timestamp);
                $pgData["page"]["items"][$i]["title"] = $entries[$i]->getTitle();
                $pgData["page"]["items"][$i]["text"] = $entries[$i]->getInfo();
                $pgData["page"]["items"][$i]["date"] = $evDate;
                $pgData["page"]["items"][$i]["link"] = $entries[$i]->getLink();
                $pgData["page"]["items"][$i]["htmlclass"] = \ICMS\Util::getHtmlClassForCalType($entries[$i]->getType());
                $pgData["page"]["items"][$i]["imgpath"] = \ICMS\Util::getImgPathForCalType($entries[$i]->getType());
                if ($i == 5) break;
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/home.tpl", $pgData); else $dwoo->output("tpl/mobile/home.tpl", $pgData);

            break;
        case 1: //Timeline
            $pgData = ["header" => ["title" => "Timeline"], "page" => ["items" => []]];

            //$res = $db->query("SELECT * FROM calendar  WHERE `Date` > CURDATE() ORDER BY `Date` ASC");
            $entries = \ICMS\TimelineEntry::getAllPublicEntries();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $timestamp = $entries[$i]->getDate();
                if ($timestamp == mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp))) $evDate = \ICMS\Util::dbDateToReadableWithOutTime($timestamp); else
                    $evDate = \ICMS\Util::dbDateToReadableWithTime($timestamp);
                $pgData["page"]["items"][$i]["title"] = $entries[$i]->getTitle();
                $pgData["page"]["items"][$i]["text"] = $entries[$i]->getInfo();
                $pgData["page"]["items"][$i]["date"] = $evDate;
                $pgData["page"]["items"][$i]["link"] = $entries[$i]->getLink();
                $pgData["page"]["items"][$i]["htmlclass"] = \ICMS\Util::getHtmlClassForCalType($entries[$i]->getType());
                $pgData["page"]["items"][$i]["imgpath"] = \ICMS\Util::getImgPathForCalType($entries[$i]->getType());
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/calendar.tpl", $pgData); else $dwoo->output("tpl/mobile/calendar.tpl", $pgData);
            break;
        case 2: //News
            $pgData = ["header" => ["title" => "News"], "page" => ["items" => []]];

            $entries = \ICMS\NewsEntry::getAllPublicEntries();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $timestamp = $entries[$i]->getDate();
                if ($timestamp == mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp))) $evDate = \ICMS\Util::dbDateToReadableWithOutTime($timestamp); else
                    $evDate = \ICMS\Util::dbDateToReadableWithTime($timestamp);
                $pgData["page"]["items"][$i]["title"] = $entries[$i]->getTitle();
                $pgData["page"]["items"][$i]["text"] = $entries[$i]->getText();
                $pgData["page"]["items"][$i]["date"] = $evDate;
                $pgData["page"]["items"][$i]["link"] = \ICMS\Util::handleLinks($entries[$i]->getLink());
                if ($i == 5) break;
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/news.tpl", $pgData); else $dwoo->output("tpl/mobile/news.tpl", $pgData);
            break;
        case 3: //Aks Liste
            $pgData = ["header" => ["title" => "Arbeitskreise"], "page" => ["items" => []]];

            $entries = \ICMS\TypeAK::listAKs();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgData["page"]["items"][$i]["id"] = $entries[$i]->getPID();
                $pgData["page"]["items"][$i]["info"] = $entries[$i]->getShort();
                $pgData["page"]["items"][$i]["name"] = $entries[$i]->getName();
                $pgData["page"]["items"][$i]["icon"] = $entries[$i]->getIcon();
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/AksList.tpl", $pgData); else $dwoo->output("tpl/mobile/AksList.tpl", $pgData);
            break;
        case 4: //Aks Detail
            $id = $_POST['id'];
            if (is_numeric($id)) {
                $site = \ICMS\Site::fromPID($id)->toTypeObject();
                $pgData = ["header" => ["title" => $site->getName()], "page" => ["title" => $site->getName(), "text" => $site->asArray()["textHTML"], "img" => $site->getImg()]];

                if ($detect->isMobile()) $dwoo->output("tpl/mobile/AkDetail.tpl", $pgData); else $dwoo->output("tpl/mobile/AkDetail.tpl", $pgData);
            }

            break;
        case 5: //Parteien List
            $pgData = ["header" => ["title" => "Parteien"], "page" => ["items" => []]];

            $entries = \ICMS\TypeParty::listParties();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgData["page"]["items"][$i]["id"] = $entries[$i]->getPID();
                $pgData["page"]["items"][$i]["info"] = $entries[$i]->getShort();
                $pgData["page"]["items"][$i]["name"] = $entries[$i]->getName();
                $pgData["page"]["items"][$i]["icon"] = $entries[$i]->getIcon();
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/PartyList.tpl", $pgData); else $dwoo->output("tpl/mobile/PartyList.tpl", $pgData);
            break;
        case 6: //Parteien Detail
            $id = $_POST['id'];
            if (is_numeric($id)) {
                $site = \ICMS\Site::fromPID($id)->toTypeObject();
                $pgData = ["header" => ["title" => $site->getName()], "page" => ["title" => $site->getName(), "text" => $site->asArray()["textHTML"], "img" => $site->getImg()]];

                if ($detect->isMobile()) $dwoo->output("tpl/mobile/PartyDetail.tpl", $pgData); else $dwoo->output("tpl/mobile/PartyDetail.tpl", $pgData);
            }
            break;
        case 7: //FAQ
            $db = \ICMS\Util::DBConnect();

            $token = \ICMS\Token::generateNewToken();

            if ($token == false) $tokenTXT = "youdonothaveatoken"; else $token->getToken();

            $pgData = ["header" => ["title" => "Häufige Fragen (FAQ)"], "page" => ["items" => [], "i" => $_GET["i"], "token" => $tokenTXT]];

            $i = 0;
            $res = $db->query("SELECT * FROM faq");
            while ($row = $res->fetch_object()) {
                $pgData["page"]["items"][$i]["ques"] = $row->question;
                $pgData["page"]["items"][$i]["answ"] = $row->answer;
                $i++;
            }


            if ($detect->isMobile()) $dwoo->output("tpl/mobile/bugs.tpl", $pgData); else $dwoo->output("tpl/mobile/bugs.tpl", $pgData);
            break;
        case 8: //Unused
            $pgData = ["header" => ["title" => "Häufige Fragen"], "page" => ["items" => []]];

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/bugs.tpl", $pgData); else $dwoo->output("tpl/mobile/bugs.tpl", $pgData);
            break;
        case 9: // Impressum
            $pgData = ["header" => ["title" => "Impressum"], "page" => ["items" => []]];

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/about.tpl", $pgData); else $dwoo->output("tpl/mobile/about.tpl", $pgData);
            break;
        case 10: // Protokolle
            $pgData = ["header" => ["title" => "Protokolle"], "page" => ["items" => [],]];

            $entries = \ICMS\Protocol::getAllPublicEntries();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgData["page"]["items"][$i]["dl"] = $entries[$i]->getFile()->getFilePath();
                $pgData["page"]["items"][$i]["name"] = $entries[$i]->getName();
                $pgData["page"]["items"][$i]["info"] = \ICMS\Util::dbDateToReadableWithOutTime($entries[$i]->getDate());
                $pgData["page"]["items"][$i]["typeNo"] = $entries[$i]->getType();
                $pgData["page"]["items"][$i]["lastEdit"] = \ICMS\Util::dbDateToReadableWithTime($entries[$i]->getLastEditDate());
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/protokollList.tpl", $pgData); else $dwoo->output("tpl/mobile/protokollList.tpl", $pgData);
            break;
        case 11: // Pages
            $id = $_POST['id'];
            if (!is_numeric($id)) {
                http_response_code(404);
                exit;
            }

            $site = \ICMS\Site::fromPID($id)->toTypeObject();


            switch ($site->getType()) {//Dwoo
                case 0:
                    $pgData = ["header" => ["title" => $site->getTitle()], "page" => ["highlight" => '', "text" => $site->asArray()["textHTML"], "header" => $site->getHeader()]];

                    if ($detect->isMobile()) $dwoo->output("tpl/mobile/page.tpl", $pgData); else $dwoo->output("tpl/mobile/page.tpl", $pgData);
                    break;
                case 1:
                    $pgData = ["header" => ["title" => $site->getTitle()], "page" => ["highlight" => '', "text" => $site->asArray()["textHTML"], "header" => $site->getHeader()]];

                    if ($detect->isMobile()) $dwoo->output("tpl/mobile/page.tpl", $pgData); else $dwoo->output("tpl/mobile/page.tpl", $pgData);
                    break;
                case 2:
                    $pgData = ["header" => ["title" => $site->getTitle()], "page" => ["highlight" => '', "text" => $site->asArray()["textHTML"], "header" => $site->getHeader()]];

                    if ($detect->isMobile()) $dwoo->output("tpl/mobile/page.tpl", $pgData); else $dwoo->output("tpl/mobile/page.tpl", $pgData);
                    break;
            }


            break;
        case 12: //Parlament
            $pageIDParla = 16;
            $pageIDFrakt = 13;
            $pgData = ["header" => ["title" => "Parlament"], "page" => []];

            $siteParla = \ICMS\Site::fromPID($pageIDParla)->toTypeObject();
            $siteFrakt = \ICMS\Site::fromPID($pageIDFrakt)->toTypeObject();
            $pgData["page"] = ["appls" => [], "highlight" => '', "text" => $siteParla->asArray()["textHTML"], "header" => $siteParla->getHeader()];

            $appls = \ICMS\ApplicationEntry::getAllApplications("descID", "Alle");
            foreach ($appls as $appl) {
                array_push($pgData["page"]["appls"], $appl->asArray());
            }
            $entries = \ICMS\TypeParty::listParties();
            for ($i = 0; $i < sizeof($entries); $i++) {
                if($entries[$i]->getPID() != 13 and $entries[$i]->getPID() !=  11) {
                    $pgData["page"]["parties"][$i]["id"] = $entries[$i]->getPID();
                    $pgData["page"]["parties"][$i]["info"] = $entries[$i]->getShort();
                    $pgData["page"]["parties"][$i]["name"] = $entries[$i]->getName();
                    $pgData["page"]["parties"][$i]["icon"] = $entries[$i]->getIcon();
                }
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/parlament.tpl", $pgData); else $dwoo->output("tpl/mobile/parlament.tpl", $pgData);

            break;
        case 13: //Laws
            $pgData = ["header" => ["title" => "Gesetze"], "page" => ["laws" => [], "regl" => []]];
            $laws = \ICMS\Law::getAllPublicLaws();
            foreach ($laws as $law) {
                array_push($pgData["page"]["laws"], $law->asArray());
            }

            $regl = \ICMS\Law::getAllPublicRegulations();
            foreach ($regl as $regulation) {
                array_push($pgData["page"]["regl"], $regulation->asArray());
            }

            if ($detect->isMobile()) $dwoo->output("tpl/mobile/laws.tpl", $pgData); else $dwoo->output("tpl/mobile/laws.tpl", $pgData);

            break;
        default:
            http_response_code(404);
    }