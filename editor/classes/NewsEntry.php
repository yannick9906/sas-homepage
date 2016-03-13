<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 14.02.2016
 * Time: 01:49
 */

namespace ICMS;


use PDO;
use PDO_MYSQL;

class NewsEntry {
    private $vID, $nID, $date, $title, $text, $link, $authorID, $lastAuthorID, $lastEditDate, $version, $state;

    /**
     * TimelineEntry constructor.
     *
     * @param $vID
     * @param $nID
     * @param $date
     * @param $title
     * @param $text
     * @param $link
     * @param $authorID
     * @param $lastAuthorID
     * @param $lastEditDate
     * @param $version
     * @param $state
     */
    public function __construct($vID, $nID, $date, $title, $text, $link, $authorID, $lastAuthorID, $lastEditDate, $version, $state) {
        $this->vID = $vID;
        $this->nID = $nID;
        $this->date = strtotime($date);
        $this->title = $title;
        $this->text = $text;
        $this->link = $link;
        $this->authorID = $authorID;
        $this->lastAuthorID = $lastAuthorID;
        $this->lastEditDate = strtotime($lastEditDate);
        $this->version = $version;
        $this->state = $state;
    }

    /**
     * @param $vID
     * @return NewsEntry
     */
    public static function fromVID($vID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_news WHERE ID = :vid ORDER BY version DESC LIMIT 1", [":vid" => $vID]);
        return new NewsEntry($res->ID, $res->nID, $res->date, $res->title, $res->text, $res->link, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
    }


    /**
     * @param $nID
     * @return NewsEntry
     */
    public static function fromNID($nID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_news WHERE nID = :nid ORDER BY version DESC LIMIT 1", [":nid" => $nID]);
        return new NewsEntry($res->ID, $res->nID, $res->date, $res->title, $res->text, $res->link, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state);
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
    public function getNID() {
        return $this->nID;
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
    public function getText() {
        return $this->text;
    }

    /**
     * Set a new Infotext for this Event
     * ** Note: after you changed something, please commit with saveChanges()
     *
     * @param string $text
     */
    public function setText($text) {
        $this->text = $text;
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
            "id" => $this->nID,
            "vId" => $this->vID,
            "date" => dbDateToReadableWithTime($this->date),
            "title" => $this->title,
            "text" => truncate($this->text, 40),
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
        $pdo->query("DELETE FROM schlopolis_news WHERE nID = :nid", [":nid" => $this->nID]);
    }

    /**
     * Approves this version
     */
    public function approve() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_news SET state = 0 WHERE ID = :vid", [":vid" => $this->vID]);
    }

    /**
     * Denies this version
     */
    public function deny() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_news SET state = 2 WHERE ID = :vid", [":vid" => $this->vID]);
    }

    /**
     * @param $user User
     * @param $date string
     * @param $title string
     * @param $text string
     * @param $link string
     * @return NewsEntry
     */
    public static function createEntry($user, $date, $title, $text, $link) {
        $pdo = new PDO_MYSQL();
        $authorID = $user->getUID();
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");
        $res = $pdo->query("SELECT MAX(nID) as nID FROM schlopolis_news");
        $nID = $res->nID + 1;
        echo $nID;
        $pdo->query("INSERT INTO schlopolis_news(nID, date, title, text, link, authorID, lastEditID, lastEditDate, version, state)"
            ."VALUES (:nid, :date, :title, :text, :link, :authorID, :lastEditID, :lastEditDate, 1, 1)",
            [":nid" => $nID, ":date" => $date, ":title" => $title, ":text" => $text, ":link" => $link, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate]);
        return self::fromNID($nID);
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
        $res = $pdo->query("SELECT MAX(version) as version FROM schlopolis_news WHERE nID = :nID", [":nID" => $this->nID]);
        $nID = $this->nID;
        $version = $res->version + 1;
        $title = $this->title;
        $info = $this->text;
        $link = $this->link;
        $pdo->query("INSERT INTO schlopolis_news(nID, date, title, text, link, authorID, lastEditID, lastEditDate, version, state)"
            ."VALUES (:nid, :date, :title, :text, :link, :authorID, :lastEditID, :lastEditDate, :version, 1)",
            [":nid" => $nID, ":date" => $date, ":title" => $title, ":title" => $title, ":link" => $link, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate, ":version" => $version]);

    }

    /**
     * @return NewsEntry[]
     */
    public static function getAllPublicEntries() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT ID FROM (SELECT * FROM schlopolis_news WHERE state = 0 and CURDATE() >= date ORDER BY nID, version desc) x GROUP BY nID ORDER BY date desc");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\NewsEntry::fromVID");

    }

    /**
     * @return NewsEntry[]
     */
    public static function getAllEntries() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT ID FROM (SELECT * FROM schlopolis_news WHERE state != 2 ORDER BY nID, version desc) x GROUP BY nID ORDER BY date desc");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\NewsEntry::fromVID");
    }

    /**
     * @param $nID int
     * @return TimelineEntry[]
     */
    public static function getAllVersions($nID) {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT ID FROM schlopolis_news WHERE nID = :nid ORDER BY version desc", [":nid" => $nID]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\NewsEntry::fromVID");
    }

    /**
     * Returns all pending timeline changes for a specific User
     *
     * @param $user User
     *
     * @return NewsEntry[]
     */
    public static function getOwnPendingChanges($user) {

    }


    /**
     * Returns all pending timeline changes
     *
     * @return NewsEntry[]
     */
    public static function getAllPendingChanges() {

    }
}