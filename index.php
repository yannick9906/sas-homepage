<?php

error_reporting(E_ERROR);
ini_set("diplay_errors", "on");

    require_once 'libs/Mobile_Detect.php'; // Mobile Detect
    require_once 'classes/Util.php'; // Mobile Detect
    $detect = new Mobile_Detect;
    $mobile = $detect->isMobile();
    if($detect->isMobile() or !$detect->isMobile()) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Schlopolis 2.0</title>
        <meta name="theme-color" content="#3F51B5"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="#3F51B5">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes"/>
        <link rel="manifest" href="manifest.webapp"/>
        <meta name="mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="libs/mdi/css/materialdesignicons.min.css" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="libs/materialize/js/materialize.min.js"></script>

        <!-- Dropdown Structure -->
        <ul id="dropdown1" class="dropdown-content">
        </ul>
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper indigo">
                    <a href="#!" class="brand-logo hide-on-med-and-down" style="padding-left: 250px;">Schlopolis</a>
                    <a href="#!" class="brand-logo hide-on-large-only" style="">Schlopolis</a>
                    <ul class="right hide-on-med-and-down">

                    </ul>
                    <ul id="slide-out" class="side-nav fixed">
                        <li class="logo">
                            <img src="img/splashicon/Schlopolis.png" alt="Logo" style="width: 100%; height: auto" />
                        </li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=0"><i class="mdi mdi-home left"></i>Home</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=1"><i class="mdi mdi-view-list left"></i>Timeline</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=12"><i class="mdi mdi-city left"></i>Parlament</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=5"><i class="mdi mdi-chart-pie left"></i>Wahlen</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="pdf/verf.pdf"><i class="mdi mdi-book-open left"></i>Gesetze</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=10"><i class="mdi mdi-clipboard-text left"></i>Protokolle</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=3"><i class="mdi mdi-account-multiple left"></i>Arbeitskreise</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=7"><i class="mdi mdi-comment left"></i>Fragen</a></li>
                        <li class="divider"></li>
                        <li class="no-padding"><a href="#p=9"><i class="mdi mdi-dots-horizontal left"></i>Impressum</a></li>
                        <li class="divider"></li>
                        <li class="no-padding" style="height:40px"></li>
                        {/if}
                        <li class="indigo" style="position: fixed; width: 240px; bottom: 0; font-size: 12px; line-height: 16px; padding: 10px;">
                            ICMS&trade; Version <? echo \ICMS\Util::getVersionInfo(); ?><br/>&copy;2014-2016 Yannick F&#233;lix
                        </li>
                    </ul>
                    <div class="menu"><a href="#" data-activates="slide-out" class="button-collapse"><i id="menu" class="mdi mdi-menu"></i></a></div>
                    <div class="back" style="visibility: hidden;"><a onclick="history.back()" data-activates="" class="btn-block"><i id="menu" class="mdi mdi-backburger"></i></a></div>
                </div>
            </nav>
        </div>
        <main>
            <div class="loading">
                <div class="preloader-wrapper active">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left">
                        <div class="circle"></div>
                        </div><div class="gap-patch">
                            <div class="circle"></div>
                        </div><div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="networkerror grey lighten-4 hide-on-med-and-down" style="visibility: hidden; position: absolute; padding-left: 250px; left: 0; right: 0; height: 100%;">
                <div class="container row">
                    <div class="card-panel col s6 offset-s3 center grey lighten-3">
                        <br/>
                        <i class="mdi mdi-server-network-off grey-text" style="font-size: 100px;"></i>
                        <br/>
                        <b class="grey-text">
                        Beim Abrufen der Seite ist ein Fehler aufgetreten<br/>
                            Versuche es später erneut</b>
                        <br/>
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="networkerror center grey lighten-4 hide-on-large-only" style="visibility: hidden; position: absolute; left: 0; right: 0; height: 100%;">
                <br/>
                <i class="mdi mdi-server-network-off grey-text" style="font-size: 100px;"></i>
                <br/>
                <b class="grey-text">
                Beim Abrufen der Seite ist ein Fehler aufgetreten<br/>
                    Versuche es später erneut</b>
                <br/>
                &nbsp;
            </div>
            <div class="content">

            </div>
        </main>
    </body>
    <script>
        var lasturl = "";	//here we store the current URL hash

        $(document).ready(function() {
            $(".back").css('visibility', 'hidden');
            $(".menu").css('display', 'block');
            $(".menu").css('visibility', 'visible');
            // Initialize collapse button
            $(".button-collapse").sideNav(<? if ($mobile) {?>{closeOnClick: true}<? } ?>);
            // Initialize collapsible (uncomment the line below if you use the dropdown variation)
            $('.collapsible').collapsible();

            if(window.location.hash == "") window.location.hash='p=0';
            checkURL();	//check if the URL has a reference to a page and load it
            $('ul li a').click(function (e) {	//traverse through all our navigation links..
                checkURL(this.hash);	//.. and assign them a new onclick event, using their own hash as a parameter (#page1 for example)
            });
            setInterval("checkURL()", 100);	//check for a change in the URL every 250 ms to detect if the history buttons have been used

            <? if($_GET["i"] == 1) { ?>Materialize.toast('Frage eingesendet', 4000)<? } ?>
            <? if($_GET["i"] == 2) { ?>Materialize.toast('Fehler', 4000)<? } ?>
        });

        function checkURL(hash) {
            if (!hash) hash = window.location.hash;	//if no parameter is provided, use the hash value from the current address
            if (hash != lasturl) {	// if the hash value has changed
                lasturl = hash;	//update the current hash
                loadPage(hash);	// and load the new page
            }
        }

        function loadPage(url) {//the function that loads pages via AJAX
            url = url.replace('#', '');	//strip the #page part of the hash and leave only the page number

            $('.content').html("");
            $('.loading').css('visibility', 'visible');	//show the rotating gif animation

            $.ajax({	//create an ajax request to load_page.php
                type: "POST",
                async: true,
                url: "page.php",
                data: url,	//with the page number as a parameter
                dataType: "html",	//expect html to be returned
                error: function () {
                    $('.loading').css('visibility', 'hidden');	//and hide the rotating gif
                    $('.networkerror').css('visibility', 'visible');	//and hide the rotating gif
                },
                success: function (msg) {
                    if (parseInt(msg) != -1) {	//if no errors
                        console.log(msg);
                        sel = msg.charAt(0);
                        if (sel == 1) {
                            $(".menu").css('visibility', 'hidden');
                            $(".menu").css('display', 'none');
                            $(".back").css('visibility', 'visible');
                            $('.content').html(msg);	//load the returned html into pageContent
                            msg = msg.substr(1);
                        } else if(sel == 2) {
                            msg = msg.substr(1);
                            $('.content').html(msg);	//load the returned html into pageContent
                            countdown();
                        } else if(sel == 3) {
                            msg = msg.substr(1);
                            $('.content').html(msg);	//load the returned html into pageContent
                            try {
                                $('#tabs').tabs();
                                $('.tooltipped').tooltip({delay: 50});
                                console.log("Worked!");
                            } catch(err) {
                                location.reload(true);
                                console.log("Catched!");
                            }
                        } else {
                            $(".back").css('visibility', 'hidden');
                            $(".menu").css('display', 'block');
                            $(".menu").css('visibility', 'visible');
                            $('.content').html(msg);	//load the returned html into pageContent
                        }
                        $('.networkerror').css('visibility', 'hidden');	//and hide the rotating gif
                        $('.loading').css('visibility', 'hidden');	//and hide the rotating gif
                    } else {
                        $('.loading').css('visibility', 'hidden');	//and hide the rotating gif
                        $('.networkerror').css('visibility', 'visible');	//and hide the rotating gif
                    }
                }
            });
        }
    </script>
    <span style="display: none;"><script type="text/javascript" src="//rc.revolvermaps.com/0/0/6.js?i=2pgjgy5sa1m&amp;m=7&amp;s=220&amp;c=e63100&amp;cr1=ffffff&amp;f=arial&amp;l=0&amp;bv=90&amp;lx=-420&amp;ly=420&amp;hi=20&amp;he=7&amp;hc=a8ddff&amp;rs=80" async="async"></script></span>
</html>
<?php
    }
?>