<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 19.04.2015
 * Time: 19:24:14
 */

	/**
     * Connects to a Mysql DB
     *
     * @deprecated
	 * @return mysqli
	 */
	function DBConnect() {
		return new mysqli('rdbms.strato.de', 'U2344370', 'bA2ZeRp0', 'DB2344370');
	}


    /**
     * Returns the class String for a Cal type
     *
     * @param $type int From Database
     * @return string String For use in tpl
     */
    function getHtmlClassForCalType($type) {
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
    function getImgPathForCalType($type) {
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
     * @return bool|\ICMS\User
     */
    function checkSession() {
        session_start();
        if(!isset($_SESSION["uID"])) {
            forwardTo("logon.php?badsession=1");
            exit;
        } else {
            return \ICMS\User::fromUID($_SESSION["uID"]);
        }
    }

    function forwardTo($url) {
        echo "<meta http-equiv=\"refresh\" content=\"0; url=$url\" />";
    }

    /**
     * @param $title String
     * @param $user \ICMS\User
     * @return array
     */
    function getEditorPageDataStub($title, $user) {
        return [
            "header" => [
                "title" => $title,
                "usrname" => $user->getUName(),
                "usrchar" => substr($user->getUName(), 0, 1),
                "uID" => $user->getUID(),
                "level" => $user->getUPrefix()
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
    function truncate($text, $length) {
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
    function dbDateToReadableWithTime($timestamp) {
        return date("d. M Y - H:i", $timestamp);
    }

    /**
     * Returns the timestamp as an readable production ready text (w/o time, only date)
     *
     * @param $timestamp int input datetime
     * @return string
     */
    function dbDateToReadableWithOutTime($timestamp) {
        return date("d. M Y", $timestamp);
    }

