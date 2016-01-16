<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 21.11.2015
 * Time: 01:17
 */

namespace ICMS;


class TypeNormal extends Site {

    private $header, $text, $title;

    function __construct($vID, $pID, $name, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state) {
        parent::__construct($vID, $pID, $name, 0, $authorID, $lastAuthorID, $lastEditDate, $version, $state);

    }

    /**
     * Creates a new Type Normal Site
     *
     * @param $name string
     * @param $user User
     * @return TypeNormal
     */
    public static function createNew($name, $user) {
        $pdo = new \PDO_MYSQL();


        $pgDataStub = [
            "header" => "-- Hier kommt der Titel hin --",
            "title" => $name,
            "text" => "Hier kommt der __Text__ hin. `Markdown` wird hier unterstützt"
        ];

        $pgDataJSON = json_encode($pgDataStub);
        $authorID = $user->getUID();
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");

        $res = $pdo->query("SELECT MAX(pID) as pID FROM schlopolis_sites");
        var_dump($res);
        $pID = $res->pID + 1;

        $pdo->query("INSERT INTO schlopolis_sites(pID, type, title, content, version, authorID, lastEditID, lastEditDate, state)"
            ."VALUES (:pID, 0, :title, :cnt, 1, :authorID, :lastEditID, :lastEditDate, 1)",
            [":pid" => $pID, ":title" => $name, ":cnt" => $pgDataJSON, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate]);
        return Site::fromPID($pID);
    }
}