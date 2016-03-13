<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 07.01.2016
 * Time: 16:46
 */

namespace ICMS;

use PDO;
use PDO_MYSQL;

class Site {
    private $vID, $pID, $name, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state;

    /**
     * Site constructor.
     * @param $vID
     * @param $pID
     * @param $name
     * @param $type
     * @param $authorID
     * @param $lastAuthorID
     * @param $lastEditDate
     * @param $version
     * @param $state
     */
    public function __construct($vID, $pID, $name, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state) {
        $this->vID = $vID;
        $this->pID = $pID;
        $this->name = $name;
        $this->type = $type;
        $this->authorID = $authorID;
        $this->lastAuthorID = $lastAuthorID;
        $this->lastEditDate = strtotime($lastEditDate);
        $this->version = $version;
        $this->state = $state;
    }

    /**
     * Create a new Site Object
     *
     * @param $pID
     * @return Site
     */
    public static function fromPID($pID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_sites WHERE pID = :pid ORDER BY version DESC LIMIT 1", [":pid" => $pID]);
        return new Site($res->ID, $res->pID, $res->title, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }

    /**
     * Create a new Site Object which is the latest live one
     *
     * @param $pID
     * @return Site
     */
    public static function fromPIDLiveOnly($pID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_sites WHERE pID = :pid and state = 0 ORDER BY version DESC LIMIT 1", [":pid" => $pID]);
        return new Site($res->ID, $res->pID, $res->title, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }

    /**
     * Create a new Site Object
     *
     * @param $vID
     * @return Site
     */
    public static function fromVID($vID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_sites WHERE ID = :vid ORDER BY version DESC LIMIT 1", [":vid" => $vID]);
        return new Site($res->ID, $res->pID, $res->title, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }

    /**
     * @return TypeNormal | TypeAK | TypeParty
     */
    public function toTypeObject() {
        switch($this->type) {
            case 0:
                return TypeNormal::fromVID($this->vID);
                break;
            case 1:
                return TypeAK::fromVID($this->vID);
                break;
            case 2:
                return TypeParty::fromVID($this->vID);
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getVID() {
        return $this->vID;
    }

    /**
     * @return mixed
     */
    public function getPID() {
        return $this->pID;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Get the Original Author/Owner
     *
     * @return User
     */
    public function getAuthor() {
        return User::fromUID($this->authorID);
    }

    /**
     * Get the Author of the latest edit
     *
     * @return User
     */
    public function getLastAuthor() {
        return User::fromUName($this->lastAuthorID);
    }

    /**
     * Get the date for the latest edit
     *
     * @return date
     */
    public function getLastEditDate() {
        return $this->lastEditDate;
    }

    /**
     * @return mixed
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @return mixed
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
                return "thumbs_up_down";
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
                return "green-text";
                break;
            case 1:
                return "orange-text";
                break;
            case 2:
                return "red-text";
                break;
        }
    }

    /**
     * Returns the TimelineEntry as an use-ready Array (for listing only)
     *
     * @return array
     */
    public function asArray() {
        //if($this->link != "") $lnk = "Extern"; else $lnk = "";
        return [
            "id" => $this->pID,
            "vId" => $this->vID,
            "title" => $this->name,
            "type" => self::getTypeAsText($this->type),
            "author" =>  User::fromUID($this->authorID)->getPrefixAsHtml()." ".User::fromUID($this->authorID)->getUName(),
            "lastEdit" => dbDateToReadableWithTime($this->lastEditDate),
            "lastEditAuthor" => User::fromUID($this->lastAuthorID)->getPrefixAsHtml()." ".User::fromUID($this->lastAuthorID)->getUName(),
            "state" => $this->state,
            "stateCSS" => self::stateAsCSS($this->state),
            "stateText" => self::stateAsHtml($this->state),
            "version" => $this->version
        ];
    }

    public static function getTypeAsText($type) {
        switch( $type ) {
            case 0:
                return "Normal";
            case 1:
                return "AK";
            case 2:
                return "Partei";
        }
    }

    /**
     * Approves this version
     */
    public function approve() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_sites SET state = 0 WHERE ID = :vid", [":vid" => $this->vID]);
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }



    /**
     * Denies this version
     */
    public function deny() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_sites SET state = 2 WHERE ID = :vid", [":vid" => $this->vID]);
    }

    /**
     * Deletes the whole Site, including it's versions
     */
    public function delete() {
        $pdo = new PDO_MYSQL();
        $pdo->query("DELETE FROM schlopolis_sites WHERE pID = :pid", [":pid" => $this->pID]);
    }

    /**
     * Returns all sites for Listing. Not for use in front-end
     *
     * @return \ICMS\Site[]
     */
    public static function getAllSites() {
        $pdo = new \PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT ID FROM (SELECT * FROM schlopolis_sites WHERE state != 2 ORDER BY pID, version desc) x GROUP BY pID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\Site::fromVID");
    }

    /**
     * Returns all versions(newest first) from a specific Page
     *
     * @param $pID int
     * @return Site[]
     */
    public static function getAllVersions($pID) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT ID FROM schlopolis_sites WHERE pID = :pid ORDER BY version desc", [":pid" => $pID]);
        $array = $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\Site::fromVID");
        return $array;
    }


    /**
     * Creates a new Page
     *
     * @param $name
     * @param $type
     * @param $user
     *
     * @return TypeNormal
     */
    public static function createNew($name, $type, $user) {
        switch($type) {
            case "normal":
                return TypeNormal::createNew($name, $user);
            case "party":
                return TypeParty::createNew($name, $user);
            case "ak":
                return TypeAK::createNew($name, $user);
        }
    }


    /**
     * Returns all pending site changes for a specific User
     *
     * @param $user User
     *
     * @return Site[]
     */
    public static function getOwnPendingChanges($user) {

    }


    /**
     * Returns all pending site changes
     *
     * @return Site[]
     */
    public static function getAllPendingChanges() {

    }

    public static function getSiteVersionBefore($vID) {
        $pdo = new PDO_MYSQL();

        $curr = self::fromVID($vID);
        $vers = ((int) $curr->getVersion()) - 1;
        $pID  = $curr->pID;
        $res  = $pdo->query("SELECT ID from schlopolis_sites WHERE version = :vers and pID = :pid", [":vers" => $vers, ":pid" => $pID]);
        return self::fromVID($res->ID);
    }
}