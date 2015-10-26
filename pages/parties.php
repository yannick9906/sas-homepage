<!DOCTYPE html>
<html>
<head lang="de">
	<meta charset="UTF-8">
	<title>Parteien - Schlopolis 2.0</title>
	<meta name="theme-color" content="#3F51B5" />
	<meta name="apple-mobile-web-app-status-bar-style" content="#3F51B5">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes" />
	<link rel="import" href="../bower_components/polymer/polymer.html" />
	<link rel="manifest" href="../manifest.json" />
	<meta name="mobile-web-app-capable" content="yes" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic|Ubuntu:400,700' rel='stylesheet' type='text/css'>
	<script src="../bower_components/webcomponentsjs/webcomponents.min.js"></script>
	<link rel="import" href="../bower_components/core-scaffold/core-scaffold.html">
	<link rel="import" href="../bower_components/core-item/core-item.html">
	<link rel="import" href="../bower_components/core-menu/core-menu.html">
	<link rel="import" href="../bower_components/paper-input/paper-input.html">
	<link rel="import" href="../bower_components/paper-fab/paper-fab.html">
	<link rel="import" href="../bower_components/paper-shadow/paper-shadow.html">
	<link rel="import" href="../bower_components/paper-ripple/paper-ripple.html">
	<link rel="import" href="../bower_components/core-icons/social-icons.html">
	<link rel="import" href="../bower_components/core-icons/editor-icons.html">
	<link rel="import" href="../bower_components/core-icons/av-icons.html">
	<link rel="import" href="../bower_components/paper-icon-button/paper-icon-button.html">
	<link rel="stylesheet" href="../css_components/pages_main.css" type="text/css" />
	<link rel="stylesheet" href="../css_components/Lists.css" type="text/css" />
</head>
<body fullbleed unresolved onload="countdown()">
<core-scaffold>

	<!-- Drawer Panel -->
	<core-header-panel navigation flex>
		<core-toolbar style="background-color: #7986CB;">
			Schlopolis 2.0
		</core-toolbar>
		<core-menu selected="4">
			<core-item icon="home" label="Home"><a href="../index.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="event" label="Kalender"><a href="Calendar.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="av:news" label="News"><a href="news.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="social:group" label="Arbeitskreise"><a href="AKs.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="social:people-outline" label="Parteien"><a href=parties.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="announcement" label="Fragen"><a href=bugs.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="payment" label="SchlopoPay"><a href="../bank/newbill.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="more-horiz" label="Impressum"><a href="about.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
			<core-item icon="account-circle" label="Login"><a href="../user/login.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
		</core-menu>
	</core-header-panel>

	<div tool>Vorstellung der Parteien</div>


	<?php
		require_once '../php_components/main.php';

		$link = DBConnect();

		$res = $link->query("SELECT * FROM parties");
		while($row = mysqli_fetch_object($res)) {
			echo <<<END
    <paper-shadow z="1" class="card">
        <a href="partyDetail.php?id=$row->ID"><core-icon style="height: 64px; width: 64px; color: black;"icon="$row->Icon"></core-icon></a>
        <a href="partyDetail.php?id=$row->ID"><h2>$row->Name</h2></a>
        <p>$row->textshort</p>
    </paper-shadow>
END;

		}
	?>
</core-scaffold>
</body>
</html>