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
