<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 19.04.2015
 * Time: 00:55:58
 */

	$action = $_GET['action'];

	if($action == 1) {
		$name = $_POST['Name'];
		$price= $_POST['price'];
		$checksum = rand(11111,99999);
		$link = new mysqli('mysql.lima-city.de', 'USER302476', 'Yannick1', 'db_302476_1');

		echo $query = "INSERT INTO schlopolis_transactions(fromUID, toUID, Amount, Title, `checksum`) VALUES (null, 1, $price, '$name', $checksum);";
		echo $link->query($query);
		echo $link->error;
		$res = $link->query("SELECT * FROM schlopolis_transactions ORDER BY tID DESC LIMIT 1");
		$row = mysqli_fetch_object($res);


		echo <<<END
<html>
	<head>
		<title>SchlopoBank - Neue Rechnung</title>
		<meta charset="UtF-8" />
		<script src="qrcode.min.js"></script>
	</head>
	<body>
		<div id="qrcode"></div>
		<script>
			new QRCode(document.getElementById("qrcode"), "http://www.y-book.tk/Schlopolis/bank/grabTrans.php?tID=$row->tID&sum=$checksum");
		</script>
	</body>
</html>
END;

exit;
	} else {

	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>SchlopoBank - Neue Rechnung</title>
		<meta charset="UtF-8" />
	</head>
	<body>
		<form action="?action=1" method="post">
			<input type="text" placeholder="Name" name="Name"/><br/>
			<input type="number" step="0.01" name="price" placeholder="Preis"/> Schlopo<br/>
			<input type="submit" value="Karten bezahlung" />
		</form>
	</body>
</html>
