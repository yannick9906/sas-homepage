<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 17.04.2016
     * Time: 15:34
     */

    namespace ICMS;

    const ASORTING = ["ascName" => " ORDER BY title, state ASC", "ascDate" => " ORDER BY date, state ASC", "ascID" => " ORDER BY aNum ASC", "descName" => " ORDER BY title, state DESC", "descDate" => " ORDER BY date, state DESC", "descID" => " ORDER BY aNum DESC", "" => " ORDER BY state ASC"];

    const AFILTERING = ["" => "", "Alle" => "", "Offen" => " WHERE state = 0", "Angenommen" => " WHERE state = 1 or state = 3", "Abgelehnt" => " WHERE state = 2",];

    use PDO;

    class ApplicationEntry {
        private $aID;
        private $aNum;
        private $state;
        private $title;
        private $date;
        private $name;
        private $fID;
        private $shorttext;
        private $uID;
        private $tags;

        /**
         * ApplicationEntry constructor.
         *
         * @param int    $aID
         * @param string $aNum
         * @param int    $state
         * @param date   $date
         * @param string $name
         * @param int    $fID
         * @param string $shorttext
         * @param int    $uID
         */
        public function __construct($aID, $aNum, $state, $title, $date, $name, $fID, $shorttext, $uID, $tags) {
            $this->aID = $aID;
            $this->aNum = $aNum;
            $this->state = $state;
            $this->title = $title;
            $this->date = strtotime($date);
            $this->name = $name;
            $this->fID = $fID;
            $this->shorttext = $shorttext;
            $this->uID = $uID;
            $this->tags = explode(";", $tags);
        }

        /**
         * Makes a new ApplicationEntry object with data for a specific aID
         *
         * @param int $aID
         * @return ApplicationEntry
         */
        public static function fromAID($aID) {
            $pdo = new PDO_MYSQL();
            $res = $pdo->query("SELECT * FROM schlopolis_applications WHERE aID = :aid", [":aid" => $aID]);
            return new ApplicationEntry($res->aID, $res->aNum, $res->state, $res->title, $res->date, $res->name, $res->fID, $res->shorttext, $res->user, $res->tags);
        }

        /**
         * Returns all Applications available in the DB. Sorted by $sort and filtered by $filter
         *
         * @param string $sort
         * @param string $filter
         * @return ApplicationEntry[]
         */
        public static function getAllApplications($sort = "", $filter = "") {
            $pdo = new PDO_MYSQL();
            $stmt = $pdo->queryMulti("SELECT aID FROM schlopolis_applications " . AFILTERING[$filter] . ASORTING[$sort]);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\ApplicationEntry::fromAID");
        }

        /**
         * @param int    $aNum
         * @param int    $state
         * @param string $title
         * @param string $name
         * @param int    $fID
         * @param string $shorttext
         * @param User   $user
         * @param array  $tags
         */
        public static function createNew($aNum, $state, $title, $name, $fID, $shorttext, $user, $tags) {
            $pdo = new PDO_MYSQL();
            $date = date("Y-m-d H:i");
            $tags = implode(";", $tags);
            $user = $user->getUID();
            $pdo->query("INSERT INTO schlopolis_applications(aNum, state, fID, title, user, date, shorttext, name, tags) VALUES (:anum, :state, :fid, :title, :user, :date, :shorttext, :name, :tags)", [":anum" => $aNum, ":state" => $state, ":fid" => $fID, ":title" => $title, ":user" => $user, ":date" => $date, ":shorttext" => $shorttext, ":name" => $name, ":tags" => $tags]);
        }

        /**
         * Deletes this object also in the db
         */
        public function delete() {
            $pdo = new PDO_MYSQL();
            $pdo->queryMulti("DELETE FROM schlopolis_applications WHERE aID = :aid", [":aid" => $this->aID]);
        }

        /**
         * @param int    $state
         * @param string $title
         * @param int    $fID
         * @param string $shorttext
         * @param array  $tags
         */
        public function saveChanges($state, $title, $fID, $shorttext, $tags) {
            $pdo = new PDO_MYSQL();
            $tags = implode(";", $tags);
            $pdo->query("UPDATE schlopolis_applications SET state = :state, title = :title, fID = :fid, shorttext = :shorttext, tags = :tags WHERE aID = :aid",
                [":state" => $state, ":title" => $title, ":fid" => $fID, ":shorttext" => $shorttext, ":tags" => $tags, ":aid" => $this->aID]);
        }

        /**
         * @param int $to
         */
        public function changeState($to) {
            $pdo = new PDO_MYSQL();
            $pdo->query("UPDATE schlopolis_applications SET state = :state WHERE aID = :aid", [":state" => $to, ":aid" => $this->aID]);
        }

        /**
         * @return array
         */
        public function asArray() {
            return ["aID" => $this->aID, "aNum" => $this->aNum, "state" => $this->state, "stateColor" => self::stateToColor($this->state), "stateText" => self::stateToText($this->state), "fID" => $this->fID, "fileName" => \ICMS\File::fromFID($this->fID)->getFileName(), "filePath" => File::fromFID($this->fID)->getFilePath(), "title" => $this->title, "userID" => $this->uID, "username" => User::fromUID($this->uID)->getUNameFrontEnd(), "date" => Util::dbDateToReadableWithTime($this->date), "shorttext" => $this->shorttext, "name" => $this->name, "tags" => $this->getAllTagsAsHtml(), "tagsList" => $this->tags, "font" => strlen($this->aNum) > 5 ? "small" : "big"];
        }

        public static function stateToColor($state) {
            switch ($state) {
                case 0:
                    return "orange";
                case 1:
                    return "green";
                case 2:
                    return "red";
                case 3:
                    return "green";
                default:
                    return "grey";
            }
        }

        public static function stateToText($state) {
            switch ($state) {
                case 0:
                    return "In Beratung";
                case 1:
                    return "Angenommen";
                case 2:
                    return "Abgelehnt";
                case 3:
                    return "Mit Änderungen angenommen";
                default:
                    return "invalid";
            }
        }

        public function getAllTagsAsHtml() {
            $html = "";
            foreach ($this->tags as $tag) {
                $tag = Tag::fromTagID($tag);
                $html .= "<div class=\"chip\">" . $tag->name . "</div>";
            }
            return $html;
        }

        /**
         * @return int
         */
        public function getAID() {
            return $this->aID;
        }

        /**
         * @return string
         */
        public function getANum() {
            return $this->aNum;
        }

        /**
         * @return int
         */
        public function getState() {
            return $this->state;
        }

        /**
         * @return date
         */
        public function getDate() {
            return $this->date;
        }

        /**
         * @return string
         */
        public function getName() {
            return $this->name;
        }

        /**
         * @return File
         */
        public function getFile() {
            return File::fromFID($this->fID);
        }

        /**
         * @return string
         */
        public function getShorttext() {
            return $this->shorttext;
        }

        /**
         * @return string
         */
        public function getTitle() {
            return $this->title;
        }

        /**
         * @return int
         */
        public function getFID() {
            return $this->fID;
        }

        /**
         * @return int
         */
        public function getUID() {
            return $this->uID;
        }
    }