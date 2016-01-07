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
     * Create a new Site Object(or TypeObject)
     *
     * @param $pID
     */
    public static function fromPID($pID) {

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
                return "LIVE";
                break;
            case 1:
                return "Zu überprüfen";
                break;
            case 2:
                return "Abgelehnt";
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
            "type" => $this->type,
            "linkTo" => $this->link,
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
     * Returns all sites for Listing. Not for use in front-end
     */
    public static function getAllSites() {
        $pdo = new \PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT vID FROM (SELECT * FROM timeline WHERE state != 2 ORDER BY tID, version desc) x GROUP BY tID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\TimelineEntry::fromVID");
    }
}