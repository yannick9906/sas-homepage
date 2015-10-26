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


    switch($pg) {
        case 0: //Home
            //Naechster Termin
            $res = $pdo->query("SELECT * FROM calendar WHERE `Date` > CURDATE() ORDER BY `Date` ASC LIMIT 1");
            $timestamp = strtotime($res->Date);
            $evDate  = date("d.m.Y", $timestamp);
            $evTitle = $res->title;

            //Spruch der Woche
            $res = $pdo->query("SELECT * FROM spruchderwoche WHERE Week = :w", [":w" => date('W')]);
            $spWeek = $res->Week;
            $spText = $res->Spruch;

            //Dwoo
            $pgData = [
                "header" => "Home",
                "page" => [
                    "evDate"  => $evDate,
                    "evTitle" => $evTitle,
                    "spWeek"  => $spWeek,
                    "evText"  => $spText
                ]
            ];

            if($detect->isMobile()) $dwoo->output("tpl/mobile/home.tpl", $pgData);
            else echo "You're a PC!";

            break;
        case 1: //Kalender
            require_once 'php/main.php';
            $db = DBConnect();
            $pgData = [
                "header" => "Kalender",
                "page" => [
                    "items"  => []
                ]
            ];

            $i = 0;
            $res = $db->query("SELECT * FROM calendar  WHERE `Date` > CURDATE() ORDER BY `Date` ASC");
            while($row = $res->fetch_object()) {
                $timestamp = strtotime($row->Date);
                $evDate = date("d.m.Y", $timestamp);
                $pgData["page"]["items"][$i]["title"] = $row->title;
                $pgData["page"]["items"][$i]["text"]  = $row->info;
                $pgData["page"]["items"][$i]["date"]  = $evDate;
                $i++;
            }

            if($detect->isMobile()) $dwoo->output("tpl/mobile/calendar.tpl", $pgData);
            else $dwoo->output("tpl/mobile/calendar.tpl", $pgData);
            break;
    }