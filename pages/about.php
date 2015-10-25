<!DOCTYPE html>
<html>
<head lang="de">
	<meta charset="UTF-8">
	<title>Impressum - Schlopolis 2.0</title>
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
	<link rel="import" href="../bower_components/paper-icon-button/paper-icon-button.html">
	<link rel="stylesheet" href="../css_components/pages_main.css" type="text/css" />
</head>
<body fullbleed unresolved>
<core-scaffold>

	<!-- Drawer Panel -->
	<core-header-panel navigation flex>
		<core-toolbar style="background-color: #7986CB;">
			Schlopolis 2.0
		</core-toolbar>
		</core-toolbar>
		<core-menu selected="7">
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

	<div tool>Impressum</div>

	<paper-shadow z="1" class="card">
		<h2>Betreiber</h2>
		<p>Yannick F&#233;lix<br/>Tucholskyweg 17<br/><a href="mailto:yannick.felix1999@gmail.com">yannick.felix1999@gmail.com</a></p>
	</paper-shadow>
	<paper-shadow z="1" class="card2">
		<h2>Programmierer</h2>
		<p>Yannick F&#233;lix</p>
	</paper-shadow>
	<paper-shadow z="1" class="card2">
		<script type="text/javascript" src="//rc.revolvermaps.com/0/0/6.js?i=2pgjgy5sa1m&amp;m=7&amp;s=220&amp;c=e63100&amp;cr1=ffffff&amp;f=arial&amp;l=0&amp;bv=90&amp;lx=-420&amp;ly=420&amp;hi=20&amp;he=7&amp;hc=a8ddff&amp;rs=80" async="async"></script>
	</paper-shadow>
</core-scaffold>
</body>
</html>
