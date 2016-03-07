<?php

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

    $pg = $_POST['p']; // ID der Seite
    if(!is_numeric($pg)) $pg = 0; // Prüfe ob es eine Zahl ist
    require_once 'php/PDO_MYSQL.class.php'; //DB Anbindung
    require_once 'php/Mobile_Detect.php'; // Mobile Detect
    require_once 'php/Parsedown.php'; // Parsedown
    require_once 'dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    require_once 'editor/classes/TimelineEntry.php';
    require_once 'editor/classes/NewsEntry.php';
    require_once 'editor/classes/Site.php';
    require_once 'editor/classes/User.php';
    require_once 'editor/classes/Token.php';
    require_once 'editor/classes/File.php';
    require_once 'editor/classes/Protocol.php';
    require_once 'editor/classes/TypeNormal.php';
    require_once 'editor/classes/TypeAK.php';
    require_once 'editor/classes/TypeParty.php';
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
            $res = $pdo->query("SELECT * FROM schlopolis_sow WHERE week = :w", [":w" => date('W')]);
            $spWeek = $res->week;
            $spText = $res->text;

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

            $entries = \ICMS\NewsEntry::getAllPublicEntries();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $timestamp = $entries[$i]->getDate();
                if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                    $evDate = dbDateToReadableWithOutTime($timestamp);
                else
                    $evDate = dbDateToReadableWithTime($timestamp);
                $pgData["page"]["items"][$i]["title"]     = $entries[$i]->getTitle();
                $pgData["page"]["items"][$i]["text"]      = $entries[$i]->getText();
                $pgData["page"]["items"][$i]["date"]      = $evDate;
                $pgData["page"]["items"][$i]["link"]      = handleLinks($entries[$i]->getLink());
                if($i == 5)
                    break;
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
            $pgData = [
                "header" => [
                    "title" => "News"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            $entries = \ICMS\NewsEntry::getAllPublicEntries();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $timestamp = $entries[$i]->getDate();
                if($timestamp == mktime(0,0,0,date("m", $timestamp),date("d", $timestamp),date("Y", $timestamp)))
                    $evDate = dbDateToReadableWithOutTime($timestamp);
                else
                    $evDate = dbDateToReadableWithTime($timestamp);
                $pgData["page"]["items"][$i]["title"]     = $entries[$i]->getTitle();
                $pgData["page"]["items"][$i]["text"]      = $entries[$i]->getText();
                $pgData["page"]["items"][$i]["date"]      = $evDate;
                $pgData["page"]["items"][$i]["link"]      = handleLinks($entries[$i]->getLink());
                if($i == 5)
                    break;
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/news.tpl", $pgData);
            else $dwoo->output("tpl/mobile/news.tpl", $pgData);
            break;
        case 3: //Aks Liste
            $pgData = [
                "header" => [
                    "title" => "Arbeitskreise"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            $entries = \ICMS\TypeAK::listAKs();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgData["page"]["items"][$i]["id"] = $entries[$i]->getPID();
                $pgData["page"]["items"][$i]["info"]  = $entries[$i]->getShort();
                $pgData["page"]["items"][$i]["name"]  = $entries[$i]->getName();
                $pgData["page"]["items"][$i]["icon"]  = $entries[$i]->getIcon();
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/AksList.tpl", $pgData);
            else $dwoo->output("tpl/mobile/AksList.tpl", $pgData);
            break;
        case 4: //Aks Detail
            $id = $_POST['id'];
            if(is_numeric($id)) {
                $site = \ICMS\Site::fromPID($id)->toTypeObject();
                $pgData = [
                    "header" => [
                        "title" => $site->getName()
                    ],
                    "page" => [
                        "title" => $site->getName(),
                        "text" => $site->asArray()["textHTML"],
                        "img" => $site->getImg()
                    ]
                ];

                if ($detect->isMobile()) $dwoo->output("tpl/mobile/AkDetail.tpl", $pgData);
                else $dwoo->output("tpl/mobile/AkDetail.tpl", $pgData);
            }

            break;
        case 5: //Parteien List
            $pgData = [
                "header" => [
                    "title" => "Parteien"
                ],
                "page" => [
                    "items"  => []
                ]
            ];

            $entries = \ICMS\TypeParty::listParties();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgData["page"]["items"][$i]["id"] = $entries[$i]->getPID();
                $pgData["page"]["items"][$i]["info"]  = $entries[$i]->getShort();
                $pgData["page"]["items"][$i]["name"]  = $entries[$i]->getName();
                $pgData["page"]["items"][$i]["icon"]  = $entries[$i]->getIcon();
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/PartyList.tpl", $pgData);
            else $dwoo->output("tpl/mobile/PartyList.tpl", $pgData);
            break;
        case 6: //Parteien Detail
            echo "7";
            $id = $_POST['id'];
            if(is_numeric($id)) {
                $site = \ICMS\Site::fromPID($id)->toTypeObject();
                $pgData = [
                    "header" => [
                        "title" => $site->getName()
                    ],
                    "page" => [
                        "title" => $site->getName(),
                        "text" => $site->asArray()["textHTML"],
                        "img" => $site->getImg()
                    ]
                ];

                if ($detect->isMobile()) $dwoo->output("tpl/mobile/PartyDetail.tpl", $pgData);
                else $dwoo->output("tpl/mobile/PartyDetail.tpl", $pgData);
            }
            break;
        case 7: //FAQ
            require_once 'php/main.php';
            $db = DBConnect();

            $token = \ICMS\Token::generateNewToken();

            if($token == false) $tokenTXT = "youdonothaveatoken";
            else $token->getToken();

            $pgData = [
                "header" => [
                    "title" => "Häufige Fragen (FAQ)"
                ],
                "page" => [
                    "items"  => [],
                    "i" => $_GET["i"],
                    "token" => $tokenTXT
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
            $pgData = [
                "header" => [
                    "title" => "Protokolle"
                ],
                "page" => [
                    "items"  => [],
                ]
            ];

            $entries = \ICMS\Protocol::getAllPublicEntries();
            for ($i = 0; $i < sizeof($entries); $i++) {
                $pgData["page"]["items"][$i]["dl"]     = $entries[$i]->getFile()->getFilePath();
                $pgData["page"]["items"][$i]["name"]   = $entries[$i]->getName();
                $pgData["page"]["items"][$i]["info"]   = dbDateToReadableWithOutTime($entries[$i]->getDate());
                $pgData["page"]["items"][$i]["typeNo"] = $entries[$i]->getType();
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


            switch($site->getType()) {//Dwoo
                case 0:
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
                case 1: //todo
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
                case 2://todo
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
            }


            break;
        default:
            if($detect->isMobile()) $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
            else $dwoo->output("tpl/mobile/error.tpl", ["header" => ["title" => 404],"code" => 404]);
            break;
    }