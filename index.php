<?php
    $pg = $_GET['p']; // ID der Seite
    if(!is_numeric($pg)) $pg = 0; // Prüfe ob es eine Zahl ist

    require_once 'php/PDO_MYSQL.class.php'; //DB Anbindung
    require_once 'dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();
    $pdo = new PDO_MYSQL();

    switch($pg) {
        case 0: //Home
            //Naechster Termin
            $res = $pdo->query("SELECT * FROM calendar WHERE `Date` > CURDATE() ORDER BY `Date` ASC LIMIT 1");
            $timestamp = strtotime($res->Date);
            $evDate  = date("d.m.Y H:i", $timestamp);
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

            $dwoo->output("tpl/mobile/home.tpl", $pgData);

            break;
    }