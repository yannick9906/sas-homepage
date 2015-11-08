<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 20.04.2015
 * Time: 22:00:28
 */

	$action = $_GET['action'];
    require_once 'php/PDO_MYSQL.class.php'; //DB Anbindung
    require_once 'php/Mobile_Detect.php'; // Mobile Detect
    require_once 'dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    $pdo = new PDO_MYSQL();
    $detect = new Mobile_Detect;
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();

	$pgData = [
			"header" => [
					"title" => "Login"
			],
			"page" => [
			]
	];
	if($action == 1) {
		require_once 'php/main.php';
		$usrname = $_POST['usrname'];
		$passwd  = md5($_POST['passwd']);
		$link    = DBConnect();

		$res = $link->query("SELECT * FROM Schlopolis_User WHERE Username = '$usrname'");
		$row = mysqli_fetch_object($res);

		if($row->Passwd == $passwd) {
			session_start();
			$_SESSION['usrName'] = $usrname;
			$_SESSION['uID'] = $row->uID;
			$_SESSION['Kontonr'] = $row->Kontonr;
			echo "Login successful!";
			//Weiterleitung
		} else {
			echo "Wrong Password/Username!";
			echo "<html><head><meta http-equiv='refresh' content='0; url=login.php?err=1' /></head></html>";
		}

		exit;
	} else {
		if($_GET['err']) {
			$pgData["page"]["err"] = "<span class='error'>Entweder der Benutzername oder das Kennwort ist falsch</span>";
		}
        if($detect->isMobile()) $dwoo->output("tpl/mobile/l0ogin.tpl", $pgData);
        else $dwoo->output("tpl/mobile/login.tpl", $pgData);
	}
?>