<!DOCTYPE html>
<html>
<head lang="de">
	<meta charset="UTF-8">
	<title>Fragen & Anregungen - Schlopolis 2.0</title>
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
	<link rel="import" href="../bower_components/paper-fab/paper-fab.html">
	<link rel="import" href="../bower_components/paper-shadow/paper-shadow.html">
	<link rel="import" href="../bower_components/paper-ripple/paper-ripple.html">
	<link rel="import" href="../bower_components/core-icons/social-icons.html">
	<link rel="import" href="../bower_components/core-icons/av-icons.html">
	<link rel="import" href="../bower_components/core-pages/core-pages.html">
	<link rel="import" href="../bower_components/paper-icon-button/paper-icon-button.html">
	<link rel="import" href="../bower_components/paper-button/paper-button.html">
	<link rel="import" href="../bower_components/paper-tabs/paper-tabs.html">
	<link rel="import" href="../bower_components/paper-input/paper-autogrow-textarea.html">
	<link rel="import" href="../bower_components/paper-input/paper-char-counter.html">
	<link rel="stylesheet" href="../css_components/pages_main.css" type="text/css" />
	<link rel="stylesheet" href="../css_components/Lists.css" type="text/css" />
</head>
<body fullbleed unresolved>
<core-scaffold>

	<!-- Drawer Panel -->
	<core-header-panel navigation flex>
		<core-toolbar style="background-color: #7986CB;">
			Schlopolis 2.0
		</core-toolbar>
		<core-menu selected="5">
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

	<div tool>Fragen & Anregungen</div>


	<?php
		require_once '../php_components/main.php';

		$link = DBConnect();

		/*if(is_numeric($id)) {
			$res = $link->query("SELECT * FROM parties WHERE ID = $id");
			$row = mysqli_fetch_object($res);
			echo <<<END
	<img src="party.png" style="width: 100%; height: auto;"/>
    <paper-shadow z="1" class="card">
        <h2>$row->Name</h2>
        <p>$row->textlong</p>
    </paper-shadow>
END;
		} else {
			echo <<<END
    <paper-shadow z="4" class="card">
        <core-icon style="height: 64px; width: 64px;"icon="warning"></core-icon>
        <h2>Fehler</h2>
        <p>:/</p>
    </paper-shadow>
END;

		}*/
	?>
	<paper-tabs selected="0">
		<paper-tab>Häufige Fragen (FAQ)</paper-tab>
		<paper-tab>Neue Frage</paper-tab>
	</paper-tabs>
	<core-pages selected="0">
		<div>
			<paper-shadow z="4" class="card">
				<core-icon style="height: 64px; width: 64px;"icon="warning"></core-icon>
				<h2 style="font-size: 20px;">Diese Seite ist noch in Arbeit</h2>
				<p>:/ Versuche es später erneut</p>
			</paper-shadow>
		</div>
		<div>
			<form action="" method="post">
				<paper-shadow class="card" z="1">
						<paper-input-decorator floatingLabel flex label="Emailadresse" error="Muss eine Emailadresse sein" autoValidate><input type="email" name="email"/></paper-input-decorator>
						<paper-input-decorator floatingLabel flex label="Betreff"><input type="text" name="subject" /></paper-input-decorator>
						<paper-input-decorator floatingLabel flex label="Nachricht"><paper-autogrow-textarea><textarea id="i1" name="text" maxlength="10000"></textarea></paper-autogrow-textarea><paper-char-counter class="counter" target="i1"></paper-char-counter></paper-input-decorator>
				</paper-shadow>
				<paper-button raised flex style="top: 20px; position: relative; width: 95%; left: 5px;" onclick="document.getElementById('submit').click();">Einschicken</paper-button>
				<input type="submit" id="submit" style="display: none;"/>
			</form>
		</div>
	</core-pages>
	<script>
		var tabs = document.querySelector('paper-tabs');
		var pages = document.querySelector('core-pages');

		tabs.addEventListener('core-select',function(){
			pages.selected = tabs.selected;
		});
	</script>

</core-scaffold>
</body>
</html>

