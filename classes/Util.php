<?php
/**
 *
 * Created by PhpStorm.
 * User: Yannick
 * Date: 19.04.2015
 * Time: 19:24:14
 */

namespace ICMS;

use mysqli;

class Util {

    /**
     * @return bool|User
     */
    public static function checkSession() {
        session_start();
        if(!isset($_SESSION["uID"])) {
            self::forwardTo("logon.php?badsession=1");
            exit;
        } else {
            $user = User::fromUID($_SESSION["uID"]);
            if($_GET["m"] == "debug") {
                echo "<pre style='display: block; position: absolute'>\n";
                echo "[0] Perm Array Information:\n";
                var_dump($user->getPermAsArray());
                echo "\n[1] Permission Information:\n";
                self::printPermission($user);
                echo "\n[2] User Information:\n";
                echo $user->toString();
                echo "\n[3] Client Information:\n";
                echo "    Arguments: ".$_SERVER["REQUEST_URI"]."\n";
                echo "    Req Time : ".$_SERVER["REQUEST_TIME"]."ns\n";
                echo "    Remote IP: ".$_SERVER["REMOTE_ADDR"]."\n";
                echo "    Usr Agent: ".$_SERVER["HTTP_USER_AGENT"]."\n";
                echo "</pre>\n";
            }

            return $user;
        }
    }

    /**
     * @param $user User
     */
    public static function printPermission($user) {
        $consts = self::returnConstants("PERM");
        //var_dump($consts);
        foreach ($consts as $const) {
            echo "    ".$const.": ".(($user->isActionAllowed($const)) ? 'on' : 'off')."\n";
        }
    }

    public static function forwardTo($url) {
        echo "<meta http-equiv=\"refresh\" content=\"0; url=$url\" />";
    }

    /**
     * @param $prefix
     * @return array
     */
    public static function returnConstants ($prefix) {
        foreach (get_defined_constants() as $key=>$value)
            if (substr($key,0,strlen($prefix))==$prefix)  $dump[$key] = $value;
        if(empty($dump)) { return "Error: No Constants found with prefix '".$prefix."'"; }
        else { return $dump; }
    }

    /**
     * @param $title String
     * @param $user User
     * @param bool $backable
     * @param bool $editor
     * @param string $undoUrl
     * @return array
     */
    public static function getEditorPageDataStub($title, $user, $backable = false, $editor = false, $undoUrl = "") {
        return [
            "header" => [
                "title" => $title,
                "usrname" => $user->getUName(),
                "usrchar" => substr($user->getUName(), 0, 1),
                "uID" => $user->getUID(),
                "level" => $user->getUPrefix(),
                "perm" => $user->getPermAsArray(),
                "editor" => $editor ? 1:0,
                "undoUrl" => $undoUrl,
                "backable" => $backable ? 1:0,
                "vInfo" => self::getVersionInfo()
            ],
            "perm" => $user->getPermAsArray()
        ];
    }


    /**
     * truncate a string only at a whitespace (by nogdog)
     *
     * @param $text String
     * @param $length int
     * @return String
     */
    public static function truncate($text, $length) {
        $length = abs((int)$length);
        if(strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return($text);
    }


    /**
     * Returns the timestamp as an readable production ready text (w/ Time)
     *
     * @param $timestamp int input datetime
     * @return string
     */
    public static function dbDateToReadableWithTime($timestamp) {
        return date("d. M Y - H:i", $timestamp);
    }

    /**
     * Returns the timestamp as an readable production ready text (w/o time, only date)
     *
     * @param $timestamp int input datetime
     * @return string
     */
    public static function dbDateToReadableWithOutTime($timestamp) {
        return date("d. M Y", $timestamp);
    }

    /**
     * Generates a random string
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!.,:;-*+#';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Generates a link from the cryptic db format
     *
     * @param string $lnk
     * @return bool | string
     */
    public static function handleLinks($lnk) {
        return $lnk == null or "" ? null : (substr($lnk, 0, 5) === "int::" ? "?p=11&id=" . str_replace("int::", "", $lnk) : $lnk);
    }

    /**
     * Returns the class String for a Cal type
     *
     * @param $type int From Database
     * @return string String For use in tpl
     */
    public static function getHtmlClassForCalType($type) {
        switch($type) {
            case 1:
                return "cd-picture";
                break;
            case 2:
                return "cd-movie";
                break;
            case 3:
                return "cd-location";
                break;
            default:
                return "cd-picture";
                break;
        }
    }

    /**
     * Returns the img Path for a Cal type
     *
     * @param $type int From Database
     * @return string String For use in tpl
     */
    public static function getImgPathForCalType($type) {
        switch($type) {
            case 1:
                return "cd-icon-voting.svg";
                break;
            case 2:
                return "cd-icon-down.svg";
                break;
            case 3:
                return "cd-icon-up.svg";
                break;
            default:
                return "cd-icon-picture.svg";
                break;
        }
    }

    /**
     * Connects to a Mysql DB
     *
     * @deprecated
     * @return mysqli
     */
    public static function DBConnect() {
        return new mysqli('rdbms.strato.de', 'U2344370', 'bA2ZeRp0', 'DB2344370');
    }

    public static function getVersionInfo() {
        return "3.1.8b (SAS)";
    }
}