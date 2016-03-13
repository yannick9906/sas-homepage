<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 10.12.2015
 * Time: 22:13
 */

namespace ICMS;


use PDO;
use PDO_MYSQL;

class TimelineEntry {
    private $vID, $tID, $date, $title, $info, $link, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state;

    /**
     * TimelineEntry constructor.
     *
     * @param $vID
     * @param $tID
     * @param $date
     * @param $title
     * @param $info
     * @param $link
     * @param $type
     * @param $authorID
     * @param $lastAuthorID
     * @param $lastEditDate
     * @param $version
     * @param $state
     */
    public function __construct($vID, $tID, $date, $title, $info, $link, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state) {
        $this->vID = $vID;
        $this->tID = $tID;
        $this->date = strtotime($date);
        $this->title = $title;
        $this->info = $info;
        $this->link = $link;
        $this->type = $type;
        $this->authorID = $authorID;
        $this->lastAuthorID = $lastAuthorID;
        $this->lastEditDate = strtotime($lastEditDate);
        $this->version = $version;
        $this->state = $state;
    }

    /**
     * @param $vID
     * @return TimelineEntry
     */
    public static function fromVID($vID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_timeline WHERE vID = :vid ORDER BY version DESC LIMIT 1", [":vid" => $vID]);
        return new TimelineEntry($res->vID, $res->tID, $res->date, $res->title, $res->info, $res->link, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }


    /**
     * @param $tID
     * @return TimelineEntry
     */
    public static function fromTID($tID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_timeline WHERE tID = :tid ORDER BY version DESC LIMIT 1", [":tid" => $tID]);
        return new TimelineEntry($res->vID, $res->tID, $res->date, $res->title, $res->info, $res->link, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }

    /**
     * Get the ID of the version
     *
     * @return int
     */
    public function getVID() {
        return $this->vID;
    }

    /**
     * Get the ID of this Entry
     *
     * @return int
     */
    public function getTID() {
        return $this->tID;
    }

    /**
     * Get the Date of this Event
     *
     * @return date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set a new Date for this Event
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @param timestamp $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * Get the Title of this Event
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set a new Title for this Event
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get the Infotext of this Event
     *
     * @return string
     */
    public function getInfo() {
        return $this->info;
    }

    /**
     * Set a new Infotext for this Event
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @param string $info
     */
    public function setInfo($info) {
        $this->info = $info;
    }

    /**
     * Get the Link, which should be displayed, null if no Link should be displayed
     *
     * @return string|null
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * Set a new Link, or null for no one
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @param string|null $link
     */
    public function setLink($link) {
        $this->link = $link;
    }

    /**
     * Get the type for diplaying the correct icon
     *
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set a new type for this Event
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @param int $type
     */
    public function setType($type) {
        $this->type = $type;
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
     * Set a new User as Owner (not recommended)
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @deprecated
     * @param User $author
     */
    public function setAuthor($author) {
        $this->authorID = $author->getUID();
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
     * Set a new Author for this edit, not recommended, create a new one...
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @deprecated Create a new one
     * @param User $lastAuthor
     */
    public function setLastAuthor($lastAuthor) {
        $this->lastAuthorID = $lastAuthor->getUID();
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
     * Sets a new date for the latest edit, not recommended, create a new one...
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @deprecated Create a new one
     * @param mixed $lastEditDate
     */
    public function setLastEditDate($lastEditDate) {
        $this->lastEditDate = $lastEditDate;
    }

    /**
     * Get the version number
     *
     * @return int
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Get the state of this Entry
     *
     * @return int
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Set a new state for this Entry
     *
     * @param int $state
     */
    public function setState($state) {
        $this->state = $state;
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
     * Returns the TimelineEntry as an use-ready Array
     *
     * @return array
     */
    public function asArray() {
        //if($this->link != "") $lnk = "Extern"; else $lnk = "";
        return [
            "id" => $this->tID,
            "vId" => $this->vID,
            "date" => dbDateToReadableWithTime($this->date),
            "title" => $this->title,
            "text" => truncate($this->info, 40),
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


    /**
     * Deletes the whole Entry, including it's versions
     */
    public function delete() {
        $pdo = new PDO_MYSQL();
        $pdo->query("DELETE FROM schlopolis_timeline WHERE tID = :tid", [":tid" => $this->tID]);
    }

    /**
     * Approves this version
     */
    public function approve() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_timeline SET state = 0 WHERE vID = :vid", [":vid" => $this->vID]);
    }

    /**
     * Denies this version
     */
    public function deny() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_timeline SET state = 2 WHERE vID = :vid", [":vid" => $this->vID]);
    }

    /**
     * @param $user User
     * @param $date string
     * @param $title string
     * @param $info string
     * @param $link string
     * @param $type int
     * @return TimelineEntry
     */
    public static function createEntry($user, $date, $title, $info, $link, $type) {
        $date = date("Y-m-d H:i:s", strtotime($date));
        $pdo = new PDO_MYSQL();
        $authorID = $user->getUID();
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");
        $res = $pdo->query("SELECT MAX(tID) as tID FROM schlopolis_timeline");
        var_dump($res);
        $tID = $res->tID + 1;
        $pdo->query("INSERT INTO schlopolis_timeline(tID, date, title, info, link, type, authorID, lastEditID, lastEditDate, version, state)"
                    ."VALUES (:tid, :date, :title, :info, :link, :type, :authorID, :lastEditID, :lastEditDate, 1, 1)",
                    [":tid" => $tID, ":date" => $date, ":title" => $title, ":info" => $info, ":link" => $link,":type" => $type, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate]);
        return self::fromTID($tID);
    }

    /**
     * Saves changes in fields (title, infotext, date, link, type) and creates a new Entry
     * ** Note, this will become the state "For Approval"
     *
     * @param $user User
     * @return bool
     */
    public function saveAsNewVersion($user) {
        $date = date("Y-m-d H:i:s", $this->date);
        $pdo = new PDO_MYSQL();
        $authorID = $this->authorID;
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");
        $res = $pdo->query("SELECT MAX(version) as version FROM schlopolis_timeline WHERE tID = :tID", [":tID" => $this->tID]);
        var_dump($res);
        $tID = $this->tID;
        $version = $res->version + 1;
        $title = $this->title;
        $info = $this->info;
        $link = $this->link;
        $type = $this->type;
        $pdo->query("INSERT INTO schlopolis_timeline(tID, date, title, info, link, type, authorID, lastEditID, lastEditDate, version, state)"
            ."VALUES (:tid, :date, :title, :info, :link, :type, :authorID, :lastEditID, :lastEditDate, :version, 1)",
            [":tid" => $tID, ":date" => $date, ":title" => $title, ":info" => $info, ":link" => $link,":type" => $type, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate, ":version" => $version]);

    }

    /**
     * @return TimelineEntry[]
     */
    public static function getAllPublicEntries() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT vID FROM (SELECT * FROM schlopolis_timeline WHERE state = 0 and `Date` > CURDATE() ORDER BY tID, version desc) x GROUP BY tID ORDER BY date asc");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\TimelineEntry::fromVID");

    }

    /**
     * @return TimelineEntry[]
     */
    public static function getAllEntries() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT vID FROM (SELECT * FROM schlopolis_timeline WHERE state != 2 ORDER BY tID, version desc) x GROUP BY tID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\TimelineEntry::fromVID");
    }

    /**
     * @param $tID int
     * @return TimelineEntry[]
     */
    public static function getAllVersions($tID) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT vID FROM schlopolis_timeline WHERE tID = :tid ORDER BY version desc", [":tid" => $tID]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\TimelineEntry::fromVID");
    }

    /**
     * Returns all pending timeline changes for a specific User
     *
     * @param $user User
     *
     * @return Site[]
     */
    public static function getOwnPendingChanges($user) {

    }


    /**
     * Returns all pending timeline changes
     *
     * @return Site[]
     */
    public static function getAllPendingChanges() {

    }
}