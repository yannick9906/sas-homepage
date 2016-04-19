<?php
    /**
     * Created by PhpStorm.
     * User: yanni
     * Date: 19.04.2016
     * Time: 23:14
     */

    namespace ICMS;


    use PDO;

    class Tag {
        public $tagID;
        public $name;

        /**
         * Tag constructor.
         *
         * @param int    $tagID
         * @param string $name
         */
        public function __construct($tagID, $name) {
            $this->tagID = $tagID;
            $this->name = $name;
        }

        /**
         * @param $tagID
         *
         * @return Tag
         */
        public static function fromTagID($tagID) {
            $pdo = new PDO_MYSQL();
            $res = $pdo->query("SELECT * FROM schlopolis_tags WHERE tagID = :tid", [":tid" => $tagID]);
            return new Tag($tagID, $res->tagName);
        }

        /**
         * @param $tagName
         *
         * @return Tag
         */
        public static function fromTagName($tagName) {
            $pdo = new PDO_MYSQL();
            $res = $pdo->query("SELECT * FROM schlopolis_tags WHERE tagName = :tname", [":tname" => $tagName]);
            return new Tag($res->tagID, $tagName);
        }

        public static function fromTagIDToArray($tagID) {
            $pdo = new PDO_MYSQL();
            $res = $pdo->query("SELECT * FROM schlopolis_tags WHERE tagID = :tid", [":tid" => $tagID]);
            return ["id" => $tagID, "name" => $res->tagName];
        }

        /**
         * @return Tag[]
         */
        public static function getAllTags() {
            $pdo = new PDO_MYSQL();
            $stmt = $pdo->queryMulti("SELECT tagID FROM schlopolis_tags");
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\Tag::fromTagID");
        }

        /**
         * @return array
         */
        public static function getAllTagsAsArray() {
            $pdo = new PDO_MYSQL();
            $stmt = $pdo->queryMulti("SELECT tagID FROM schlopolis_tags");
            return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\Tag::fromTagIDToArray");
        }

        public static function TagNameArrayToTagIDArray($array) {
            $tags = [];
            foreach($array as $item) {
                $tag = self::fromTagName($item);
                array_push($tags, $tag->name);
            }
            return $tags;
        }
    }