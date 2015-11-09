<?php
    $pg = $_GET['p']; // ID der Seite
    if(!is_numeric($pg)) $pg = 0; // Prüfe ob es eine Zahl ist
    require_once 'php/PDO_MYSQL.class.php'; //DB Anbindung
    require_once 'php/Mobile_Detect.php'; // Mobile Detect
    require_once 'dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    $pdo = new PDO_MYSQL();
    $detect = new Mobile_Detect;
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

if($_SERVER['REMOTE_ADDR'] == "84.132.121.2") {

    if($detect->isMobile()) $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 403],"code" => 403]);
    else $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 403],"code" => 403]);
    exit;
}
print $_SERVER["REMOTE_ADDR"];


    switch($pg) {
        case 0: //Home
            //Naechster Termin
            $res = $pdo->query("SELECT * FROM calendar WHERE `Date` > CURDATE() ORDER BY `Date` ASC LIMIT 1");
            $timestamp = strtotime($res->Date);
            if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                $evDate = date("d. M Y", $timestamp);
            else
                $evDate = date("d. M Y - H:i", $timestamp);
            $evTitle = $res->title;

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
                    "spText"  => $spText
                ]
            ];

            if($detect->isMobile()) $dwoo->output("tpl/mobile/home.tpl", $pgData);
            else $dwoo->output("tpl/mobile/home.tpl", $pgData);

            break;
        case 1: //Timeline
            require_once 'php/main.php';
            $db = DBConnect();
            $pgData = [
                "header" => [
                    "title" => "Timeline"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            $i = 0;
            $res = $db->query("SELECT * FROM calendar  WHERE `Date` > CURDATE() ORDER BY `Date` ASC");
            while($row = $res->fetch_object()) {
                $timestamp = strtotime($row->Date);
                if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                    $evDate = date("d. M Y", $timestamp);
                else
                    $evDate = date("d. M Y - H:i", $timestamp);
                $pgData["page"]["items"][$i]["title"]     = $row->title;
                $pgData["page"]["items"][$i]["text"]      = $row->info;
                $pgData["page"]["items"][$i]["date"]      = $evDate;
                $pgData["page"]["items"][$i]["htmlclass"] = getHtmlClassForCalType($row->type);
                $pgData["page"]["items"][$i]["imgpath"]   = getImgPathForCalType($row->type);
                $i++;
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
            $id = $_GET['id'];
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
            $id = $_GET['id'];
            if(!is_numeric($id)) {
                if($detect->isMobile()) $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
                else $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
                exit;
            }

            //Spruch der Woche
            $res = $pdo->query("SELECT * FROM pages WHERE pID = :p", [":p" => $id]);

            //Dwoo
            $pgData = [
                "header" => [
                    "title" => $res->title
                ],
                "page" => [
                    "highlight" => $res->highlight,
                    "text"  => $res->text
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