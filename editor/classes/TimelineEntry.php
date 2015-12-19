<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 10.12.2015
 * Time: 22:13
 */

namespace ICMS;


use PDO;

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
        $this->date = $date;
        $this->title = $title;
        $this->info = $info;
        $this->link = $link;
        $this->type = $type;
        $this->authorID = $authorID;
        $this->lastAuthorID = $lastAuthorID;
        $this->lastEditDate = $lastEditDate;
        $this->version = $version;
        $this->state = $state;
    }

    public static function fromVID($vID) {
        $pdo = new \PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM timeline WHERE vID = :vid ORDER BY version DESC LIMIT 1", [":vid" => $vID]);
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
     * @param date $date
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
     * Saves all changes, done to this Entry
     * ** Note, this will NOT create a new Entry
     *
     * @return bool
     */
    public function saveChanges() {
        //TODO
    }

    /**
     * turns state int into a readable production ready HTML code
     *
     * @param $state int
     * @return string
     */
    public static function stateAsHtml($state) {
        switch($state) {
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
        switch($state) {
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

    public function asArray() {
        return [
            "id" => $this->tID,
            "vId" => $this->vID,
            "date" => dbDateToReadableWithTime($this->date),
            "title" => $this->title,
            "text" => truncate($this->info, 40),
            "type" => $this->type,
            "linkTo" => $this->link,
            "author" => User::fromUID($this->authorID)->getUName(),
            "lastEdit" => dbDateToReadableWithTime($this->lastEditDate),
            "lastEditAuthor" => User::fromUID($this->lastAuthorID)->getUName(),
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
        $pdo->query("DELETE FROM timeline WHERE tID = :tid", [":tid" => $this->tID]);
    }

    /**
     * Approves this version
     */
    public function approve() {
        $pdo = new \PDO_MYSQL();
        $pdo->query("UPDATE timeline SET state = 0 WHERE vID = :vid", [":vid" => $this->vID]);
    }

    /**
     * Denies this version
     */
    public function deny() {
        $pdo = new \PDO_MYSQL();
        $pdo->query("UPDATE timeline SET state = 2 WHERE vID = :vid", [":vid" => $this->vID]);
    }

    /**
     * Saves changes in fields (title, infotext, date, link, type) and creates a new Entry
     * ** Note, this will become the state "For Approval"
     *
     * @return bool
     */
    public function saveChangesAsNewVersion() {
        //TODO
    }

    public static function getAllPublicEntries() {
        // TODO
    }

    /**
     * @return TimelineEntry[]
     */
    public static function getAllEntries() {
        $pdo = new \PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT vID FROM (SELECT * FROM timeline ORDER BY tID, version desc) x GROUP BY tID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\TimelineEntry::fromVID");
    }
}