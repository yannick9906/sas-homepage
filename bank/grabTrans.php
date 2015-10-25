<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 19.04.2015
 * Time: 17:12:40
 */
	echo "<pre>";
	$action = $_GET['action'];
	$link = new mysqli('mysql.lima-city.de', 'USER302476', 'Yannick1', 'db_302476_1');
	echo $tID = $_GET['tID'];
	echo "\n";
	echo $sum = $_GET['sum'];

	if($action == 1) {
		echo "Aktzepted!";
	} elseif($action == 2) {
		echo "Refused!";
	} else {

		$res = $link->query("SELECT * FROM schlopolis_transactions WHERE tID = $tID");
		$row = mysqli_fetch_object($res);

		echo "\n";
		echo $row->fromUID;
		echo "\n";
		echo $row->toUID;
		echo "\n";
		echo $row->Amount;
		echo "\n";
		echo $row->Title;
		echo "\n";
		echo $row->checksum;
		echo "\n";
		if($sum == $row->checksum)
			echo <<<END
<html>
<body>
	<a href="?action=1&tID=$tID&sum=$sum">Akzeptieren</a>
	<a href="?action=2&tID=$tID&sum=$sum">Ablehnen</a>
</body>
</html>
END;
		else
			echo "Nope !!";

	}