<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 19.11.2015
 * Time: 22:31
 */

namespace ICMS;

use PDO;
use PDO_MYSQL;

class User {
    private $uID;
    private $uName;
    private $uFirstName;
    private $uLastName;
    private $uEmail;
    private $uPassHash;
    private $uPrefix;

    /**
     * User constructor.
     *
     * @param $uID int User ID
     * @param $uName string Username
     * @param $uFirstName string Users Firstname
     * @param $uLastName string Users Lastname
     * @param $uEmail string Users Email
     * @param $uPassHash string Users md5-hash
     */
    private function __construct($uID, $uName, $uFirstName, $uLastName, $uEmail, $uPassHash, $level) {
        $this->uID = $uID;
        $this->uName = $uName;
        $this->uFirstName = $uFirstName;
        $this->uLastName = $uLastName;
        $this->uEmail = $uEmail;
        $this->uPassHash = $uPassHash;
        $this->uPrefix = $level;
    } // 0- User | 1- Mod | 2-Admin


    /**
     * Creates a new User Object from a give user ID
     *
     * @param $uID int User ID
     * @return User
     */
    public static function fromUID($uID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_user WHERE uID = :uid", [":uid" => $uID]);
        return new User($res->uID, $res->username, $res->firstname, $res->lastname, $res->mail, $res->passwd, $res->level);
    }

    /**
     * Creates a new User Object from a give username
     *
     * @param $uName string Username
     * @return User
     */
    public static function fromUName($uName) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_user WHERE username = :uname", [":uname" => $uName]);
        return new User($res->uID, $res->username, $res->firstname, $res->lastname, $res->mail, $res->passwd, $res->level);
    }

    /**
     * @param int $uID
     */
    public function setUID($uID) {
        $this->uID = $uID;
    }

    /**
     * @param string $uName
     */
    public function setUName($uName) {
        $this->uName = $uName;
    }

    /**
     * @param string $uFirstName
     */
    public function setUFirstName($uFirstName) {
        $this->uFirstName = $uFirstName;
    }

    /**
     * @param string $uLastName
     */
    public function setULastName($uLastName) {
        $this->uLastName = $uLastName;
    }

    /**
     * @param string $uEmail
     */
    public function setUEmail($uEmail) {
        $this->uEmail = $uEmail;
    }

    /**
     * @param string $uPassHash
     */
    public function setUPassHash($uPassHash) {
        $this->uPassHash = md5($uPassHash);
    }

    /**
     * @param int $uPrefix
     */
    public function setUPrefix($uPrefix) {
        $this->uPrefix = $uPrefix;
    }


    /**
     * @return int User ID
     */
    public function getUID() {
        return $this->uID;
    }


    /**
     * @return int User Level
     */
    public function getUPrefix() {
        return $this->uPrefix;
    }

    /**
     * @return string Username
     */
    public function getUName() {
        return $this->uName;
    }

    /**
     * Compares a md5() hash with the given Hash from db
     *
     * @param $hash string md5-hash
     * @return bool
     */
    public function comparePWHash($hash) {
        if($hash == $this->uPassHash) {
            echo $hash . "<br/>" . $this->uPassHash;
            return true;
        } else {
            echo $hash . "<br/>" . $this->uPassHash;
            return false;
        }
    }

    /**
     * Every user has a nominal Level. This will return the prefix shown everywhere before the username
     *
     * @return string htmlnotated prefix
     */
    public function getPrefixAsHtml() {
        switch($this->uPrefix) {
            case 0:
                return '<span class="uPreUsr">[User]</span>';
                break;
            case 1:
                return '<span class="uPreMod">[Partei]</span>';
                break;
            case 2:
                return '<span class="uPreMod">[Ak]</span>';
                break;
            case 3:
                return '<span class="uPreMod">[Orga]</span>';
                break;
            case 4:
                return '<span class="uPreMod">[Lehrer]</span>';
                break;
            case 5:
                return '<span class="uPreAdm">[Admin]</span>';
                break;
            default:
                return '<span class="uPreUsr">[User]</span>';
        }
    }

    /**
     * Checks if the user is permitted to do sth.
     *
     * @param $permission String for Permission
     * @return bool
     */
    public function isActionAllowed($permission) {
        if($this->uPrefix != 6) {
            $pdo = new PDO_MYSQL();
            $res = $pdo->query("SELECT * FROM schlopolis_user_rights WHERE uID = :uid AND permission = :key", [":uid" => $this->uID, ":key" => $permission]);
            if($res->active == 1) return true;
            else return false;
        } else return true;
    }


    /**
     * Tests if a permission action key is already present in the DB
     *
     * @param $permission string
     * @return bool
     */
    public function isActionInDB($permission) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_user_rights WHERE uID = :uid AND permission = :key", [":uid" => $this->uID, ":key" => $permission]);
        return isset($res->active);
    }

    /**
     * Updates a value for a specific action key or creates a new entry in the DB
     *
     * @param $actionKey string
     * @param $state int
     */
    public function setPermission($actionKey, $state) {
        $pdo = new PDO_MYSQL();
        if($this->isActionInDB($actionKey))
            $pdo->query("UPDATE schlopolis_user_rights SET active = :state WHERE uID = :uid and permission = :key", [":uid" => $this->uID, ":key" => $actionKey, ":state" => $state]);
        else
            $pdo->query("INSERT INTO schlopolis_user_rights(active, uID, permission) VALUES (:state, :uid, :key)", [":uid" => $this->uID, ":key" => $actionKey, ":state" => $state]);
    }

    /**
     * Makes this class as an array to use for tables etc.
     *
     * @return array
     */
    public function asArray() {
        return [
            "id" => $this->uID,
            "usrname" => $this->uName,
            "usrchar" => $this->uName[0],
            "firstname" => $this->uFirstName,
            "lastname" => $this->uLastName,
            "email" => $this->uEmail,
            "lvl" => $this->uPrefix,
            "prefix" => $this->getPrefixAsHtml()
        ];
    }


    /**
     * Makes this class as an string to use for debug only
     *
     * @return string
     */
    public function toString() {
        return
            "id:        ".$this->uID."\n".
            "usrname:   ".$this->uName."\n".
            "usrchar:   ".$this->uName[0]."\n".
            "firstname: ".$this->uFirstName."\n".
            "lastname:  ".$this->uLastName."\n".
            "email:     ".$this->uEmail."\n".
            "lvl:       ".$this->uPrefix."\n".
            "prefix:    ".$this->getPrefixAsHtml()."\n";
    }

    /**
     * Returns all permission for this user as an use-ready array
     *
     * @return array
     */
    public function getPermAsArray() {
        $array = [];
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT * FROM schlopolis_user_rights WHERE uID = :uid", [":uid" => $this->uID]);
        while($row = $stmt->fetchObject()) {
            $array[str_replace(".", "_", $row->permission)] = (int) $this->isActionAllowed($row->permission);
        }
        return $array;
    }

    /**
     * checks if a username is in the user db
     *
     * @param $uName string Username
     * @return bool
     */
    public static function doesUserNameExist($uName) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_user WHERE username = :uname", [":uname" => $uName]);
        if(isset($res->uID)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns all users as a array of Userobjects from db
     *
     * @return \ICMS\User[]
     */
    public static function getAllUsers() {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT uID FROM schlopolis_user ORDER BY uID");
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\User::fromUID");
    }

    /**
     * Deletes a user
     *
     * @return bool
     */
    public function delete() {
        $pdo = new PDO_MYSQL();
        return $pdo->query("DELETE FROM schlopolis_user WHERE uID = :uid", [":uid" => $this->uID]);
    }

    /**
     * Saves the Changes made to this object to the db
     */
    public function saveChanges() {
        $pdo = new PDO_MYSQL();
        $pdo->query("UPDATE schlopolis_user SET mail = :Email, firstname = :Firstname, lastname = :Lastname, passwd = :Passwd, username = :Username, level = :lvl WHERE uID = :uID LIMIT 1",
            [":Email" => $this->uEmail, ":Firstname" => $this->uFirstName, ":Lastname" => $this->uLastName, ":Passwd" => $this->uPassHash, ":Username" => $this->uName, ":uID" => $this->uID, ":lvl" => $this->uPrefix]);
    }

    /**
     * Creates a new user from the give attribs
     *
     * @param $username string Username
     * @param $firstname string Firstname
     * @param $lastname string Lastname
     * @param $email string Email Adress
     * @param $passwdhash string md5 Hash of Password
     * @return User The new User as an Object
     */
    public static function createUser($username, $firstname, $lastname, $email, $passwdhash) {
        $pdo = new PDO_MYSQL();
        $pdo->query("INSERT INTO schlopolis_user(username, firstname, lastname, mail, passwd) VALUES (:Username, :Firstname, :Lastname, :Email, :Passwd)",
        [":Username" => $username, ":Firstname" => $firstname, ":Lastname" => $lastname, ":Email" => $email, ":Passwd" => md5($passwdhash)]);
        return self::fromUName($username);
    }
}