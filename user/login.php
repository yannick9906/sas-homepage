<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 20.04.2015
 * Time: 22:00:28
 */

	$action = $_GET['action'];

	if($action == 1) {
		require_once '../php/main.php';
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
			echo "<html><head><meta http-equiv='refresh' content='0; url=?err=1' /></head></html>";
		}

		exit;
	} else {
		if($_GET['err']) {
			$errtxt = "<span class='error'>Entweder der Benutzername oder das Kennwort ist falsch</span>";
		}
	}
?>

<!DOCTYPE html>
<html>
<head lang="de">
	<meta charset="UTF-8">
	<title>Login - Schlopolis 2.0</title>
	<meta name="theme-color" content="#3F51B5" />
	<meta name="apple-mobile-web-app-status-bar-style" content="#3F51B5">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes" />
	<link rel="import" href="../bower_components/polymer/polymer.html" />
	<link rel="manifest" href="../manifest.json" />
	<meta name="mobile-web-app-capable" content="yes" />
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<script src="../bower_components/webcomponentsjs/webcomponents.min.js"></script>
	<link rel="import" href="../bower_components/core-scaffold/core-scaffold.html">
	<link rel="import" href="../bower_components/core-item/core-item.html">
	<link rel="import" href="../bower_components/core-menu/core-menu.html">
	<link rel="import" href="../bower_components/paper-input/paper-input.html">
	<link rel="import" href="../bower_components/paper-button/paper-button.html">
	<link rel="import" href="../bower_components/paper-fab/paper-fab.html">
	<link rel="import" href="../bower_components/paper-shadow/paper-shadow.html">
	<link rel="import" href="../bower_components/paper-ripple/paper-ripple.html">
	<link rel="import" href="../bower_components/core-icons/social-icons.html">
	<link rel="import" href="../bower_components/core-icons/av-icons.html">
	<link rel="import" href="../bower_components/paper-icon-button/paper-icon-button.html">
	<link rel="stylesheet" href="../style/pages_main.css" type="text/css" />
</head>
<body fullbleed unresolved onload="countdown()">
<core-scaffold>

	<!-- Drawer Panel -->
	<core-header-panel navigation flex>
		<core-toolbar style="background-color: #7986CB;">
			Schlopolis 2.0
		</core-toolbar>
		<core-menu selected="8">
			<core-item icon="home" label="Home"><a href="../index.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="event" label="Kalender"><a href="../pages/Calendar.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="av:news" label="News"><a href="../pages/news.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="social:group" label="Arbeitskreise"><a href="../pages/AKs.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="social:people-outline" label="Parteien"><a href="../pages/parties.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="announcement" label="Fragen"><a href="../pages/bugs.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="payment" label="SchlopoPay"><a href="../bank/newbill.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="more-horiz" label="Impressum"><a href="../pages/about.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="account-circle" label="Login"><a href="../user/login.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
		</core-menu>
	</core-header-panel>

	<div tool>Benutzerlogin</div>

	<!-- Main Content -->
	<form action="?action=1" method="post">
	<paper-shadow z="2" class="card">
		<?php echo $errtxt;?>
		<paper-input-decorator floatingLabel flex label="Benutzername"><input type="text" name="usrname" /></paper-input-decorator>
		<paper-input-decorator floatingLabel flex label="Passwort"><input type="password" name="passwd" /></paper-input-decorator>
		<paper-button raised flex onclick="document.getElementById('submit').click();">Login</paper-button>
	</paper-shadow>
		<input type="submit" id="submit" style="display: none;"/>
	</form>

	<!--<div class="send-message" layout horizontal>
		<paper-input floatingLabel flex label="Type message..." id="input" value="{{input}}"></paper-input>
		<paper-fab icon="send" id="sendButton" on-tap="{{sendMyMessage}}"></paper-fab>
	</div>-->
</core-scaffold>
</body>
</html>