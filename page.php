<?php
    $pg = $_POST['p']; // ID der Seite
    if(!is_numeric($pg)) $pg = 0; // Prüfe ob es eine Zahl ist
    require_once 'php/PDO_MYSQL.class.php'; //DB Anbindung
    require_once 'php/Mobile_Detect.php'; // Mobile Detect
    require_once 'php/Parsedown.php'; // Parsedown
    require_once 'dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    require_once 'editor/classes/TimelineEntry.php';
    require_once 'editor/classes/Site.php';
    require_once 'editor/classes/User.php';
    require_once 'editor/classes/TypeNormal.php';
    require_once 'php/main.php';
    $pdo = new PDO_MYSQL();
    $detect = new Mobile_Detect;
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

if($_SERVER['REMOTE_ADDR'] == "84.132.121.2") {

    if($detect->isMobile()) $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 403],"code" => 403]);
    else $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 403],"code" => 403]);
    exit;
}

    switch($pg) {
        case 0: //Home
            //Naechster Termin
            $entries = \ICMS\TimelineEntry::getAllPublicEntries();
            $timestamp = $entries[0]->getDate();
            if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                $evDate = dbDateToReadableWithOutTime($timestamp);
            else
                $evDate = dbDateToReadableWithTime($timestamp);
            $evTitle    = $entries[0]->getTitle();

            //Spruch der Woche
            $res = $pdo->query("SELECT * FROM spruchderwoche WHERE Week = :w", [":w" => date('W')]);
            $spWeek = $res->Week;
            $spText = $res->Spruch;

            //Dwoo
            $pgData = [
                "header" => [
                    "title" => "Home"
                ],
                "page" => [
                    "evDate"  => $evDate,
                    "evTitle" => $evTitle,
                    "spWeek"  => $spWeek,
                    "spText"  => $spText,
                    "items"   => []
                ]
            ];

            $db = DBConnect();

            $i = 0;
            $res = $db->query("SELECT * FROM news ORDER BY ID DESC LIMIT 5");
            while($row = $res->fetch_object()) {
                $timestamp = strtotime($row->date);
                if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                    $evDate = date("d. M Y", $timestamp);
                else
                    $evDate = date("d. M Y - H:i", $timestamp);
                $pgData["page"]["items"][$i]["title"] = $row->title;
                $pgData["page"]["items"][$i]["text"]  = $row->text;
                $pgData["page"]["items"][$i]["date"]  = $evDate;
                $pgData["page"]["items"][$i]["link"]  = $row->link;
                $i++;
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/home.tpl", $pgData);
            else $dwoo->output("tpl/mobile/home.tpl", $pgData);

            break;
        case 1: //Timeline
            $pgData = [
                "header" => [
                    "title" => "Timeline"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            //$res = $db->query("SELECT * FROM calendar  WHERE `Date` > CURDATE() ORDER BY `Date` ASC");
            $entries = \ICMS\TimelineEntry::getAllPublicEntries();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $timestamp = $entries[$i]->getDate();
                if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                    $evDate = dbDateToReadableWithOutTime($timestamp);
                else
                    $evDate = dbDateToReadableWithTime($timestamp);
                $pgData["page"]["items"][$i]["title"]     = $entries[$i]->getTitle();
                $pgData["page"]["items"][$i]["text"]      = $entries[$i]->getInfo();
                $pgData["page"]["items"][$i]["date"]      = $evDate;
                $pgData["page"]["items"][$i]["link"]      = $entries[$i]->getLink();
                $pgData["page"]["items"][$i]["htmlclass"] = getHtmlClassForCalType($entries[$i]->getType());
                $pgData["page"]["items"][$i]["imgpath"]   = getImgPathForCalType($entries[$i]->getType());
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/calendar.tpl", $pgData);
            else $dwoo->output("tpl/mobile/calendar.tpl", $pgData);
            break;
        case 2: //News
            require_once 'php/main.php';
            $db = DBConnect();
            $pgData = [
                "header" => [
                    "title" => "News"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            $i = 0;
            $res = $db->query("SELECT * FROM news ORDER BY ID DESC LIMIT 20");
            while($row = $res->fetch_object()) {
                $timestamp = strtotime($row->date);
                if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                    $evDate = date("d. M Y", $timestamp);
                else
                    $evDate = date("d. M Y - H:i", $timestamp);
                $pgData["page"]["items"][$i]["title"] = $row->title;
                $pgData["page"]["items"][$i]["text"]  = $row->text;
                $pgData["page"]["items"][$i]["date"]  = $evDate;
                $pgData["page"]["items"][$i]["link"]  = $row->link;
                $i++;
            }
            if($detect->isMobile()) $dwoo->output("tpl/mobile/news.tpl", $pgData);
            else $dwoo->output("tpl/mobile/news.tpl", $pgData);
            break;
        case 3: //Aks Liste
            require_once 'php/main.php';
            $db = DBConnect();
            $pgData = [
                "header" => [
                    "title" => "Arbeitskreise"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            $i = 0;
            $res = $db->query("SELECT * FROM AKs");
            while($row = $res->fetch_object()) {
                $pgData["page"]["items"][$i]["id"] = $row->ID;
                $pgData["page"]["items"][$i]["info"]  = $row->textshort;
                $pgData["page"]["items"][$i]["name"]  = $row->Name;
                $pgData["page"]["items"][$i]["icon"]  = $row->Icon;
                $i++;
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/AksList.tpl", $pgData);
            else $dwoo->output("tpl/mobile/AksList.tpl", $pgData);
            break;
        case 4: //Aks Detail
            require_once 'php/main.php';
            $db = DBConnect();
            $id = $_POST['id'];
            if(is_numeric($id)) {
                $res = $pdo->query("SELECT * FROM AKs WHERE ID = :id", [":id" => $id]);
                $pgData = [
                    "header" => [
                        "title" => $res->Name
                    ],
                    "page" => [
                        "title" => $res->Name,
                        "text" => $res->textlong,
                        "img" => $res->img
                    ]
                ];

                if ($detect->isMobile()) $dwoo->output("tpl/mobile/AkDetail.tpl", $pgData);
                else $dwoo->output("tpl/mobile/AkDetail.tpl", $pgData);
            }

            break;
        case 5: //Parteien List
            require_once 'php/main.php';
            $db = DBConnect();
            $pgData = [
                "header" => [
                    "title" => "Parteien"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            $i = 0;
            $res = $db->query("SELECT * FROM parties");
            while($row = $res->fetch_object()) {
                $pgData["page"]["items"][$i]["id"] = $row->ID;
                $pgData["page"]["items"][$i]["info"]  = $row->textshort;
                $pgData["page"]["items"][$i]["name"]  = $row->Name;
                $pgData["page"]["items"][$i]["icon"]  = $row->Icon;
                if(mktime(date("d M Y")) >= mktime(0,0,0,11,9,2015)) $pgData["page"]["ok"] = 1;
                $i++;
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/PartyList.tpl", $pgData);
            else $dwoo->output("tpl/mobile/PartyList.tpl", $pgData);
            break;
        case 6: //Parteien Detail
            require_once 'php/main.php';
            $db = DBConnect();
            $id = $_GET['id'];
            if(is_numeric($id)) {
                $res = $pdo->query("SELECT * FROM parties WHERE ID = :id", [":id" => $id]);
                $pgData = [
                    "header" => [
                        "title" => $res->Name
                    ],
                    "page" => [
                        "title" => $res->Name,
                        "text" => $res->textlong,
                        "img" => $res->img
                    ]
                ];

                if ($detect->isMobile()) $dwoo->output("tpl/mobile/PartyDetail.tpl", $pgData);
                else $dwoo->output("tpl/mobile/PartyDetail.tpl", $pgData);
            }
            break;
        case 7: //FAQ
            require_once 'php/main.php';
            $db = DBConnect();
            $pgData = [
                "header" => [
                    "title" => "Häufige Fragen (FAQ)"
                ],
                "page" => [
                    "items"  => [],
                    "i" => $_GET["i"]
                ]
            ];

            $i = 0;
            $res = $db->query("SELECT * FROM faq");
            while($row = $res->fetch_object()) {
                $pgData["page"]["items"][$i]["ques"] = $row->question;
                $pgData["page"]["items"][$i]["answ"]  = $row->answer;
                $i++;
            }


            if($detect->isMobile()) $dwoo->output("tpl/mobile/bugs.tpl", $pgData);
            else $dwoo->output("tpl/mobile/bugs.tpl", $pgData);
            break;
        case 8: //Unused
            $pgData = [
                "header" => [
                    "title" => "Häufige Fragen"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            if($detect->isMobile()) $dwoo->output("tpl/mobile/bugs.tpl", $pgData);
            else $dwoo->output("tpl/mobile/bugs.tpl", $pgData);
            break;
        case 9: // Impressum
            $pgData = [
                "header" => [
                    "title" => "Impressum"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            if($detect->isMobile()) $dwoo->output("tpl/mobile/about.tpl", $pgData);
            else $dwoo->output("tpl/mobile/about.tpl", $pgData);
            break;
        case 10: // Protokolle
            require_once 'php/main.php';
            $db = DBConnect();
            $pgData = [
                "header" => [
                    "title" => "Protokolle"
                ],
                "page" => [
                    "items"  => [],
                ]
            ];

            $i = 0;
            $res = $db->query("SELECT * FROM protokols");
            while($row = $res->fetch_object()) {
                $timestamp = strtotime($row->date);
                $date = date("d. M Y", $timestamp);
                $pgData["page"]["items"][$i]["dl"] = $row->dl;
                $pgData["page"]["items"][$i]["name"]  = $row->title;
                $pgData["page"]["items"][$i]["info"]  = $date;
                $i++;
            }


            if($detect->isMobile()) $dwoo->output("tpl/mobile/protokollList.tpl", $pgData);
            else $dwoo->output("tpl/mobile/protokollList.tpl", $pgData);
            break;
        case 11: // Pages
            $id = $_POST['id'];
            if(!is_numeric($id)) {
                if($detect->isMobile()) $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
                else $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
                exit;
            }

            $site = \ICMS\Site::fromPID($id)->toTypeObject();

            //Dwoo
            $pgData = [
                "header" => [
                    "title" => $site->getTitle()
                ],
                "page" => [
                    "highlight" => '',
                    "text"  => $site->asArray()["textHTML"],
                    "header" => $site->getHeader()
                ]
            ];

            if($detect->isMobile()) $dwoo->output("tpl/mobile/page.tpl", $pgData);
            else $dwoo->output("tpl/mobile/page.tpl", $pgData);

            break;
        default:
            if($detect->isMobile()) $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
            else $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
            break;
    }