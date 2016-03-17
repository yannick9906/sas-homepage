<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 20.02.2016
 * Time: 20:39
 */

namespace ICMS;

use ICMS\File;

const PSORTING = [
    "ascName"  => " ORDER BY name ASC",
    "ascID"    => " ORDER BY fID ASC",
    "ascDate"  => " ORDER BY date ASC",
    "descName" => " ORDER BY name DESC",
    "descID"   => " ORDER BY fID DESC",
    "descDate" => " ORDER BY date DESC",
    "" => ""
];

const PFILTERING = [
    "" => "",
    "Alle"       => " ",
    "Orgateam"   => " WHERE type = 1",
    "Parlament"  => " WHERE type = 2",
    "Wirtschaft" => " WHERE type = 3",
    "Öffentl."   => " WHERE type = 4",
    "Politik"    => " WHERE type = 5",
    "Finanzen"   => " WHERE type = 6",
    "Sonstige"   => " WHERE type = 7",
];

class Protocol {
    private $vID, $prID, $fileID, $name, $date, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state;

    /**
     * Protocol constructor.
     * @param $vID
     * @param $prID
     * @param $fileID
     * @param $name
     * @param $date
     * @param $type
     * @param $authorID
     * @param $lastAuthorID
     * @param $lastEditDate
     * @param $version
     * @param $state
     */
    public function __construct($vID, $prID, $fileID, $name, $date, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state) {
        $this->vID = $vID;
        $this->prID = $prID;
        $this->fileID = $fileID;
        $this->name = $name;
        $this->date = strtotime($date);
        $this->type = $type;
        $this->authorID = $authorID;
        $this->lastAuthorID = $lastAuthorID;
        $this->lastEditDate = strtotime($lastEditDate);
        $this->version = $version;
        $this->state = $state;
    }

    /**
     * Returns the latest version for a specific protocol
     *
     * @param $prID int
     * @return Protocol
     */
    public static function fromPRID($prID) {
        $pdo = new \PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_protocols WHERE prID = :prid ORDER BY version DESC LIMIT 1", [":prid" => $prID]);
        return new Protocol($res->ID, $res->prID, $res->fileID, $res->name, $res->date, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }

    /**
     * Returns a specific version
     *
     * @param $vID int
     * @return Protocol
     */
    public static function fromVID($vID) {
        $pdo = new \PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_protocols WHERE ID = :id", [":id" => $vID]);
        return new Protocol($res->ID, $res->prID, $res->fileID, $res->name, $res->date, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }

    /**
     * @param mixed $fileID
     */
    public function setFileID($fileID) {
        $this->fileID = $fileID;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param int $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }


    /**
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }


    /**
     * @return int
     */
    public function getVID() {
        return $this->vID;
    }

    /**
     * @return int
     */
    public function getPrID() {
        return $this->prID;
    }

    /**
     * @return File
     */
    public function getFile() {
        return File::fromFID($this->fileID);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return User
     */
    public function getAuthorID() {
        return User::fromUID($this->authorID);
    }

    /**
     * @return User
     */
    public function getLastAuthorID() {
        return User::fromUID($this->lastAuthorID);
    }

    /**
     * @return date
     */
    public function getLastEditDate() {
        return $this->lastEditDate;
    }

    /**
     * @return int
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getState() {
        return $this->state;
    }


    /**
    * turns state int into a readable production ready HTML code
    *
    * @param $state int
    * @return string
    */
    public static function stateAsHtml($state) {
        switch ($state) {
            case 0:
                return "check";
                break;
            case 1:
                return "account-alert";
                break;
            case 2:
                return "close";
                break;
        }
    }

    /**
     * turns state int into a CSS class name
     *
     * @param $state int
     * @return string
     */
    public static function stateAsCSS($state) {
        switch ($state) {
            case 0:
                return "live";
                break;
            case 1:
                return "test";
                break;
            case 2:
                return "invalid";
                break;
        }
    }

    public static function typeAsText($type) {
        switch($type) {
            case 1:
                return "Orgateam";
                break;
            case 2:
                return "Parlament";
                break;
            case 3:
                return "AK Wirtschaft";
                break;
            case 4:
                return "AK Öffentlichkeitsarbeit";
                break;
            case 5:
                return "AK Politik";
                break;
            case 6:
                return "AK Finanzen";
                break;
            case 7:
                return "Sonstige";
                break;
        }
    }

    /**
     * Returns the TimelineEntry as an use-ready Array
     *
     * @return array
     */
    public function asArray() {
        return [
            "id" => $this->prID,
            "vId" => $this->vID,
            "date" => dbDateToReadableWithOutTime($this->date),
            "title" => $this->name,
            "type" => self::typeAsText($this->type),
            "typeNo" => $this->type,
            "fileName" => $this->getFile()->getFileName(),
            "fileID" => $this->fileID,
            "author" =>  User::fromUID($this->authorID)->getPrefixAsHtml()." ".User::fromUID($this->authorID)->getUName(),
            "lastEdit" => dbDateToReadableWithTime($this->lastEditDate),
            "lastEditAuthor" => User::fromUID($this->lastAuthorID)->getPrefixAsHtml()." ".User::fromUID($this->lastAuthorID)->getUName(),
            "state" => $this->state,
            "stateCSS" => self::stateAsCSS($this->state),
            "stateText" => self::stateAsHtml($this->state),
            "version" => $this->version
        ];
    }


    /**
     * Deletes the whole Entry, including it's versions
     */
    public function delete() {
        $pdo = new \PDO_MYSQL();
        $pdo->query("DELETE FROM schlopolis_protocols WHERE prID = :prid", [":prid" => $this->prID]);
    }

    /**
     * Approves this version
     */
    public function approve() {
        $pdo = new \PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_protocols SET state = 0 WHERE ID = :id", [":id" => $this->vID]);
    }

    /**
     * Denies this version
     */
    public function deny() {
        $pdo = new \PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_protocols SET state = 2 WHERE ID = :id", [":id" => $this->vID]);
    }

    /**
     * @param $user User
     * @param $date string
     * @param $name
     * @param $fileID
     * @param $type int
     * @return Protocol
     */
    public static function createEntry($user, $date, $name, $fileID, $type) {
        echo $date = date("Y-m-d H:i:s", strtotime($date));
        $pdo = new \PDO_MYSQL();
        $authorID = $user->getUID();
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");
        $res = $pdo->query("SELECT MAX(prID) as prID FROM schlopolis_protocols");
        $prID = $res->prID + 1;
        $pdo->query("INSERT INTO schlopolis_protocols(prID, name, date, fileID, type, authorID, lastEditID, lastEditDate, version, state)"
            ."VALUES (:prid, :name, :date, :fileID, :type, :authorID, :lastEditID, :lastEditDate, 1, 1)",
            [":prid" => $prID, ":name" => $name, ":date" => $date, ":fileID" => $fileID, ":type" => $type, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate]);
        return self::fromPRID($prID);
    }

    /**
     * Saves changes in fields (title, infotext, date, link, type) and creates a new Entry
     * ** Note, this will become the state "For Approval"
     *
     * @param $user User
     */
    public function saveAsNewVersion($user) {
        $pdo = new \PDO_MYSQL();
        $authorID = $this->authorID;
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");
        $res = $pdo->query("SELECT MAX(version) as version FROM schlopolis_protocols WHERE prID = :prID", [":prID" => $this->prID]);
        var_dump($res);
        $prID = $this->prID;
        $version = $res->version + 1;
        $name = $this->name;
        $fileID = $this->fileID;
        $type = $this->type;
        $date = date("Y-m-d H:i:s", $this->date);
        $pdo->query("INSERT INTO schlopolis_protocols(prID, name, date, fileID, type, authorID, lastEditID, lastEditDate, version, state)"
            ."VALUES (:prid, :name, :date, :fileID, :type, :authorID, :lastEditID, :lastEditDate, :version, 1)",
            [":prid" => $prID, ":name" => $name, ":date" => $date, ":fileID" => $fileID, ":type" => $type, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate, ":version" => $version]);
    }

    /**
     * @return Protocol[]
     */
    public static function getAllPublicEntries() {
        $pdo = new \PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT prID FROM (SELECT * FROM schlopolis_protocols WHERE state = 0 ORDER BY prID, version desc) x GROUP BY prID ORDER BY date DESC");
        return $stmt->fetchAll(\PDO::FETCH_FUNC, "\\ICMS\\Protocol::fromPRID");

    }

    /**
     * @return Protocol[]
     */
    public static function getAllEntries($sort, $filter) {
        $pdo = new \PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT prID FROM (SELECT * FROM (SELECT * FROM schlopolis_protocols WHERE state != 2 ORDER BY prID, version desc) x GROUP BY prID) y ".PFILTERING[$filter].PSORTING[$sort]);
        return $stmt->fetchAll(\PDO::FETCH_FUNC, "\\ICMS\\Protocol::fromPRID");
    }

    /**
     * @param $prID int
     * @return Protocol[]
     */
    public static function getAllVersions($prID) {
        $pdo = new \PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT ID FROM schlopolis_protocols WHERE prID = :prid ORDER BY version desc", [":prid" => $prID]);
        return $stmt->fetchAll(\PDO::FETCH_FUNC, "\\ICMS\\Protocol::fromVID");
    }

    /**
     * Returns all pending protocol changes for a specific User
     *
     * @param $user User
     *
     * @return Protocol[]
     */
    public static function getOwnPendingChanges($user) {

    }


    /**
     * Returns all pending protocol changes
     *
     * @return Protocol[]
     */
    public static function getAllPendingChanges() {

    }
}