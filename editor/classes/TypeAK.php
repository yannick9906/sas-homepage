<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 21.11.2015
 * Time: 01:17
 */

namespace ICMS;

use PDO;
use PDO_MYSQL;


class TypeAK extends Site {

    private $tplLink = "tpl/siteAKEdit.tpl";
    private $text, $img, $icon, $short;

    function __construct($vID, $pID, $name, $type, $authorID, $lastAuthorID, $lastEditDate, $version, $state, $content) {
        parent::__construct($vID, $pID, $name, 1, $authorID, $lastAuthorID, $lastEditDate, $version, $state);
        $pgData = json_decode($content);
        $this->text = $pgData->text;
        $this->img = $pgData->image;
        $this->icon = $pgData->logo;
        $this->short = $pgData->short;
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
        return new TypeAK($res->ID, $res->pID, $res->title, $res->type, $res->authorID, $res->lastEditID, $res->lastEditDate, $res->version, $res->state, $res->content);
    }

    /**
     * @return mixed
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getImg() {
        return $this->img;
    }

    /**
     * @return mixed
     */
    public function getIcon() {
        return $this->icon;
    }

    /**
     * @return mixed
     */
    public function getShort() {
        return $this->short;
    }

    /**
     * @param mixed $text
     */
    public function setText($text) {
        $this->text = $text;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img) {
        $this->img = $img;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon) {
        $this->icon = $icon;
    }

    /**
     * @param mixed $short
     */
    public function setShort($short) {
        $this->short = $short;
    }


    /**
     * @return string
     */
    public function getTplLink() {
        return $this->tplLink;
    }

    public function asArray() {
        $parseDown = new \Parsedown();
        $parent = parent::asArray();
        $parent["name"] = $this->getName();
        $parent["icon"] = $this->icon;
        $parent["image"] = $this->img;
        $parent["short"] = $this->short;
        $parent["text"] = $this->text;
        $parent["textHTML"] = $parseDown->text($this->text);
        return $parent;
    }

    /**
     * Creates a new Type Normal Site
     *
     * @param $name string
     * @param $user User
     * @return TypeNormal
     */
    public static function createNew($name, $user) {
        $pdo = new PDO_MYSQL();


        $pgDataStub = [
            "name" => $name,
            "image" => "",
            "logo" => "",
            "short" => "-- Hier kommt ein kurzer Text hin --",
            "text" => "Hier kommt der **Text** hin. `Markdown` wird hier unterstützt"
        ];

        $pgDataJSON = json_encode($pgDataStub);
        $authorID = $user->getUID();
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");

        $res = $pdo->query("SELECT MAX(pID) as pID FROM schlopolis_sites");
        var_dump($res);
        $pID = $res->pID + 1;

        $resn = $pdo->queryMulti("INSERT INTO schlopolis_sites(pID, type, title, content, version, authorID, lastEditID, lastEditDate, state)"
            ."VALUES (:pID, 1, :title, :cnt, 1, :authorID, :lastEditID, :lastEditDate, 1)",
            [":pID" => $pID, ":title" => $name, ":cnt" => $pgDataJSON, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate]);
        var_dump($resn->errorInfo());
        return Site::fromPID($pID);
    }


    /**
     * Saves changes in fields (title, infotext, date, link, type) and creates a new Entry
     * ** Note, this will become the state "For Approval"
     *
     * @param $user User
     * @return bool
     */
    public function saveAsNewVersion($user) {
        $pdo = new PDO_MYSQL();
        $authorID = $this->getAuthor()->getUID();
        $lastEditID = $user->getUID();
        $lastEditDate = date("Y-m-d H:i:s");
        $res = $pdo->query("SELECT MAX(version) as version FROM schlopolis_sites WHERE pID = :pID", [":pID" => $this->getPID()]);
        var_dump($res);
        $pID = $this->getPID();
        $version = $res->version + 1;

        var_dump($content = [
            "name" => $this->getName(),
            "image" => $this->img,
            "logo" => $this->icon,
            "short" => $this->short,
            "text" => $this->text
        ]);
        $contentJSON = json_encode($content);
        $res = $pdo->queryMulti("INSERT INTO schlopolis_sites(pID, type, title, content, version, authorID, lastEditID, lastEditDate, state)"
            ."VALUES (:pID, 1, :name, :cnt, :vers, :authorID, :lastEditID, :lastEditDate, 1)",
            [":pID" => $pID, ":name" => $this->getName(), ":cnt" => $contentJSON, ":authorID" => $authorID, ":lastEditID" => $lastEditID, ":lastEditDate" => $lastEditDate, ":vers" => $version]);
        var_dump($res->errorInfo());
    }

    /**
     * @return TypeAK[]
     */
    public static function listAKs() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT pID FROM (SELECT * FROM schlopolis_sites WHERE state = 0 and type = 1 ORDER BY pID, version desc) x GROUP BY pID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\TypeAK::fromPID");
    }
}