<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 19.04.2015
 * Time: 19:24:14
 */

	/**
	 * @return mysqli
	 */
	function DBConnect() {
		return new mysqli('mysql.lima-city.de', 'USER302476', 'ubW0yhSI', 'db_302476_1');
	}
?>
