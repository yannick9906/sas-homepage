<?php
    require_once 'php/Mobile_Detect.php'; // Mobile Detect
    $detect = new Mobile_Detect;
    if($detect->isMobile() or !$detect->isMobile()) {
?>
<!DOCTYPE html>
<html>
    <head lang="de">
        <meta charset="UTF-8">
        <title>Schlopolis 2.0</title>
        <meta name="theme-color" content="#3F51B5"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black_translucent">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes"/>
        <link rel="import" href="bower_components/polymer/polymer.html"/>
        <link rel="manifest" href="manifest.webapp"/>
        <meta name="mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic|Ubuntu:400,700'
              rel='stylesheet' type='text/css'>
        <script src="bower_components/webcomponentsjs/webcomponents.js"></script>
        <link rel="import" href="bower_components/core-scaffold/core-scaffold.html">
        <link rel="import" href="bower_components/core-item/core-item.html">
        <link rel="import" href="bower_components/core-menu/core-menu.html">
        <link rel="import" href="bower_components/paper-input/paper-input.html">
        <link rel="import" href="bower_components/paper-fab/paper-fab.html">
        <link rel="import" href="bower_components/paper-shadow/paper-shadow.html">
        <link rel="import" href="bower_components/paper-ripple/paper-ripple.html">
        <link rel="import" href="bower_components/paper-toast/paper-toast.html">
        <link rel="import" href="bower_components/core-icons/social-icons.html">
        <link rel="import" href="bower_components/core-icons/av-icons.html">
        <link rel="import" href="bower_components/paper-icon-button/paper-icon-button.html">
        <link rel="import" href="bower_components/core-pages/core-pages.html">
        <link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="import" href="bower_components/paper-tabs/paper-tabs.html">
        <link rel="import" href="bower_components/paper-input/paper-autogrow-textarea.html">
        <link rel="import" href="bower_components/paper-input/paper-char-counter.html">
        <script src="javascript/jquery-2.1.4.min.js"></script> <!-- jQuery -->
        <script src="javascript/main.js"></script> <!-- jQuery -->
        <script src="vertical-timeline/js/modernizr.js"></script> <!-- Modernizr -->
        <link rel="stylesheet" href="style/pages_main.css" type="text/css"/>
        <!-- Piwik -->
        <script type="text/javascript">
          var _paq = _paq || [];
          if (!window.location.pathname.match(/(\/editor)/))
          {
              _paq.push(['trackPageView']);
              _paq.push(['enableLinkTracking']);
          }
          (function() {
              var u="//piwik.schlopolis.de/";
              _paq.push(['setTrackerUrl', u+'piwik.php']);
              _paq.push(['setSiteId', 1]);
              var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
              g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
          })();
        </script>
        <noscript><p><img src="//piwik.schlopolis.de/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
        <!-- End Piwik Code -->
    </head>
    <body fullbleed unresolved>
        <core-scaffold id="pageContent">

            <!-- Drawer Panel -->
            <core-header-panel navigation flex>
                <core-toolbar style="background-color: #7986CB;">
                    Schlopolis
                </core-toolbar>
                <core-menu selected="{$args}">
                    <core-item icon="home" label="Home"><a href="#p=0" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
                    <core-item icon="view-list" label="Timeline"><a href="#p=1" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="av:news" label="News"><a href="#p=2" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="assignment" label="Protokolle"><a href="#p=10" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="account-balance" label="Staat"><a href="#p=11&id=1" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="view-headline" label="Verfassung"><a href="pdf/verf.pdf" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="social:group" label="Arbeitskreise"><a href="#p=3" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="receipt" label="Wahlen"><a href="#p=5" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="announcement" label="Fragen"><a href="#p=7" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="more-horiz" label="Impressum"><a href="#p=9" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                    <core-item icon="account-circle" label="Login"><a href="editor/logon.php" target="_self"><paper-ripple
                                fit></paper-ripple></a></core-item>
                </core-menu>
            </core-header-panel>
        </core-scaffold>
        <script>
            $(document).ready(function () {	//executed after the page has loaded

                if(window.location.hash == "") window.location.hash='p=0';

                checkURL();	//check if the URL has a reference to a page and load it

                $('ul li a').click(function (e) {	//traverse through all our navigation links..

                    checkURL(this.hash);	//.. and assign them a new onclick event, using their own hash as a parameter (#page1 for example)

                });

                setInterval("checkURL()", 100);	//check for a change in the URL every 250 ms to detect if the history buttons have been used

            });

            var lasturl = "";	//here we store the current URL hash

            function checkURL(hash) {
                if (!hash) hash = window.location.hash;	//if no parameter is provided, use the hash value from the current address

                if (hash != lasturl)	// if the hash value has changed
                {
                    lasturl = hash;	//update the current hash
                    loadPage(hash);	// and load the new page
                }
            }

            function loadPage(url)	//the function that loads pages via AJAX
            {
                url = url.replace('#', '');	//strip the #page part of the hash and leave only the page number

                if(window.chrome) document.getElementById("pageContent").closeDrawer();

                $('.spinner').css('visibility', 'visible');	//show the rotating gif animation

                $('#pageContent').html('<div class="loa"><svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>');

                $.ajax({	//create an ajax request to load_page.php
                    type: "POST",
                    async: true,
                    url: "page.php",
                    data: url,	//with the page number as a parameter
                    dataType: "html",	//expect html to be returned
                    error: function () {
                        alert("Mmh irgendwas ist hier falsch :/")
                    },
                    success: function (msg) {

                        if (parseInt(msg) != -1)	//if no errors
                        {
                            sel = msg.charAt(0);
                            drawer = "<core-header-panel navigation flex>" +
                                '<core-toolbar style="background-color: #7986CB;">' +
                                "Schlopolis" +
                                "</core-toolbar>" +
                                '<core-menu selected="' + sel + '">' +
                                '<core-item icon="home" label="Home"><a href="#p=0" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="view-list" label="Timeline"><a href="#p=1" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="av:news" label="News"><a href="#p=2" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="assignment" label="Protokolle"><a href="#p=10" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="account-balance" label="Staat"><a href="#p=11&id=1" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="view-headline" label="Verfassung"><a href="pdf/verf.pdf" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="social:group" label="Arbeitskreise"><a href="#p=3" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="receipt" label="Wahlen"><a href="#p=5" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="announcement" label="Fragen"><a href="#p=7" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="more-horiz" label="Impressum"><a href="#p=9" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '<core-item icon="account-circle" label="Login"><a href="editor/logon.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>' +
                                '</core-menu>' +
                                "</core-header-panel>";
                            msg = drawer + msg;
                            $('#pageContent').html(msg);	//load the returned html into pageContent
                            $('.spinner').css('visibility', 'hidden');	//and hide the rotating gif
                            console.log(msg);
                            if (sel == 0) {
                                countdown();
                            }

                        }
                    }

                });
            }
        </script>
    </body>
</html>
<?php
    }
?>