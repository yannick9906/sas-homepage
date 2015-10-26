<!DOCTYPE html>
<html>
    <head lang="de">
        <meta charset="UTF-8">
        <title>Schlopolis 2.0</title>
        <meta name="theme-color" content="#3F51B5" />
        <meta name="apple-mobile-web-app-status-bar-style" content="#3F51B5">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes" />
        <link rel="import" href="bower_components/polymer/polymer.html" />
        <link rel="manifest" href="manifest.json" />
        <meta name="mobile-web-app-capable" content="yes" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic|Ubuntu:400,700' rel='stylesheet' type='text/css'>
        <script src="bower_components/webcomponentsjs/webcomponents.min.js"></script>
        <link rel="import" href="bower_components/core-scaffold/core-scaffold.html">
        <link rel="import" href="bower_components/core-item/core-item.html">
        <link rel="import" href="bower_components/core-menu/core-menu.html">
        <link rel="import" href="bower_components/paper-input/paper-input.html">
        <link rel="import" href="bower_components/paper-fab/paper-fab.html">
        <link rel="import" href="bower_components/paper-shadow/paper-shadow.html">
        <link rel="import" href="bower_components/paper-ripple/paper-ripple.html">
        <link rel="import" href="bower_components/core-icons/social-icons.html">
        <link rel="import" href="bower_components/core-icons/av-icons.html">
        <link rel="import" href="bower_components/paper-icon-button/paper-icon-button.html">
        <link rel="stylesheet" href="style/pages_main.css" type="text/css" />
    </head>
    <body fullbleed unresolved onload="countdown()">
        <core-scaffold>

            <!-- Drawer Panel -->

            <!--Luis-->
            <core-header-panel navigation flex>
                <core-toolbar style="background-color: #7986CB;">
                    Schlopolis 2.0
                </core-toolbar>
                <core-menu selected="0">
                    <core-item icon="home" label="Home"><a href="index.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="event" label="Kalender"><a href="pages/Calendar.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="av:news" label="News"><a href="pages/news.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="social:group" label="Arbeitskreise"><a href="pages/AKs.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="social:people-outline" label="Parteien"><a href="pages/parties.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="announcement" label="Fragen"><a href="pages/bugs.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="payment" label="SchlopoPay"><a href="bank/newbill.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="more-horiz" label="Impressum"><a href="pages/about.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="account-circle" label="Login"><a href="user/login.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                </core-menu>
            </core-header-panel>

            <div tool icon="menu">Schlopolis 2.0</div>

            <!-- Main Content -->
            <paper-shadow z="2" id="countdown" class="card"></paper-shadow>

            <paper-shadow z="1" class="card">
                <a href="pages/Calendar.php"><h2>Nächster Termin</h2></a>
                <?php
                    require_once 'php/main.php';
                    $link = DBConnect();

                    $res = $link->query("SELECT * FROM calendar WHERE `Date` > CURDATE() ORDER BY `Date` ASC LIMIT 1");
                    $row = mysqli_fetch_object($res);
                    $timestamp = strtotime($row->Date);
                    $date = date("d.m.Y H:i", $timestamp);

                    echo "<p>$date - $row->title</p>";
                ?>
            </paper-shadow>

            <paper-shadow z="1" class="card">
                <?php
                    $week = date('W');

                    $res = $link->query("SELECT * FROM spruchderwoche WHERE Week = $week");
                    $row = mysqli_fetch_object($res);
                    echo "<h2>Spruch der Woche $week</h2>";
                    echo "<p>$row->Spruch</p>";
                ?>
            </paper-shadow>

            <paper-shadow z="1" class="card2" style="display: none;">
                <script type="text/javascript" src="//rc.revolvermaps.com/0/0/6.js?i=2pgjgy5sa1m&amp;m=7&amp;s=220&amp;c=e63100&amp;cr1=ffffff&amp;f=arial&amp;l=0&amp;bv=90&amp;lx=-420&amp;ly=420&amp;hi=20&amp;he=7&amp;hc=a8ddff&amp;rs=80" async="async"></script>
            </paper-shadow>

            <!--<div class="send-message" layout horizontal>
                <paper-input floatingLabel flex label="Type message..." id="input" value="{{input}}"></paper-input>
                <paper-fab icon="send" id="sendButton" on-tap="{{sendMyMessage}}"></paper-fab>
            </div>-->
        </core-scaffold>

        <script src="javascript/main.js"></script>
    </body>
</html>