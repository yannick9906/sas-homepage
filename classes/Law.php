<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 04.05.2016
     * Time: 20:52
     */

    namespace ICMS;

    const ASORTING = ["ascName" => " ORDER BY title ASC", "ascDate" => " ORDER BY date ASC", "ascID" => " ORDER BY lwNum ASC", "descName" => " ORDER BY title DESC", "descDate" => " ORDER BY date DESC", "descID" => " ORDER BY lwNum DESC", "" => ""];

    use PDO;

    class Law {
        private $lwID;
        private $lwNum;
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
         * @param int    $lwID
         * @param string $lwNum
         * @param string $title
         * @param date   $date
         * @param string $name
         * @param int    $fID
         * @param string $shorttext
         * @param int    $uID
         * @param string $tags
         */
        public function __construct($lwID, $lwNum, $title, $date, $name, $fID, $shorttext, $uID, $tags) {
            $this->lwID = $lwID;
            $this->lwNum = $lwNum;
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
         * @return Law
         */
        public static function fromLWID($lwID) {
            $pdo = new PDO_MYSQL();
            $res = $pdo->query("SELECT * FROM schlopolis_laws WHERE lwID = :lwid", [":lwid" => $lwID]);
            return new Law($res->lwID, $res->lwNum, $res->title, $res->date, $res->name, $res->fID, $res->shorttext, $res->user, $res->tags);
        }

        /**
         * Returns all Applications available in the DB. Sorted by $sort and filtered by $filter
         *
         * @param string $sort
         * @param string $filter
         * @return Law[]
         */
        public static function getAllLaws($sort = "") {
            $pdo = new PDO_MYSQL();
            $stmt = $pdo->queryMulti("SELECT lwID FROM schlopolis_laws " . ASORTING[$sort]);
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\Law::fromLWID");
        }

        /**
         * @param string $lwNum
         * @param string $title
         * @param string $name
         * @param int    $fID
         * @param string $shorttext
         * @param User   $user
         * @param array  $tags
         */
        public static function createNew($lwNum, $title, $name, $fID, $shorttext, $user, $tags) {
            var_dump($lwNum);
            $pdo = new PDO_MYSQL();
            $date = date("Y-m-d H:i");
            $tags = implode(";", $tags);
            $user = $user->getUID();
            $pdo->query("INSERT INTO schlopolis_laws(lwNum, fID, title, user, date, shorttext, name, tags) VALUES (:lwnum, :fid, :title, :user, :date, :shorttext, :name, :tags)", [":lwnum" => $lwNum, ":fid" => $fID, ":title" => $title, ":user" => $user, ":date" => $date, ":shorttext" => $shorttext, ":name" => $name, ":tags" => $tags]);
        }

        /**
         * Deletes this object also in the db
         */
        public function delete() {
            $pdo = new PDO_MYSQL();
            $pdo->queryMulti("DELETE FROM schlopolis_laws WHERE lwID = :lwid", [":lwid" => $this->lwID]);
        }

        /**
         * @param string $title
         * @param int    $fID
         * @param string $shorttext
         * @param array  $tags
         */
        public function saveChanges($title, $fID, $shorttext, $tags) {
            $pdo = new PDO_MYSQL();
            $tags = implode(";", $tags);
            $pdo->query("UPDATE schlopolis_laws SET title = :title, fID = :fid, shorttext = :shorttext, tags = :tags WHERE lwID = :lwid",
                [":title" => $title, ":fid" => $fID, ":shorttext" => $shorttext, ":tags" => $tags, ":lwid" => $this->lwID]);
        }

        /**
         * @return array
         */
        public function asArray() {
            return ["lwID" => $this->lwID, "lwNum" => $this->lwNum, "fID" => $this->fID, "fileName" => \ICMS\File::fromFID($this->fID)->getFileName(), "filePath" => File::fromFID($this->fID)->getFilePath(), "title" => $this->title, "userID" => $this->uID, "username" => User::fromUID($this->uID)->getUNameFrontEnd(), "date" => Util::dbDateToReadableWithTime($this->date), "shorttext" => $this->shorttext, "name" => $this->name, "tags" => $this->getAllTagsAsHtml(), "tagsList" => $this->tags, "font" => strlen($this->lwNum) > 5 ? "small" : "big"];
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
        public function getLWID() {
            return $this->lwID;
        }

        /**
         * @return string
         */
        public function getLwNum() {
            return $this->lwNum;
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