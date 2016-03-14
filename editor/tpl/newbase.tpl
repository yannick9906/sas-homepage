<!DOCTYPE html>
<html>
    <head>
        <title>Sas Entrance</title>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="bower_components/materialize/css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="style/style.css" />
        <link type="text/css" rel="stylesheet" href="style/materialdesignicons.min.css" media="all"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="manifest" href="manifest.json" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="theme-color" content="#3F51B5" />
    </head>
    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="bower_components/materialize/js/materialize.min.js"></script>
        <script type="text/javascript" src="bower_components/markdown.min.js"></script>

        <!-- Dropdown Structure -->
        <ul id="dropdown1" class="dropdown-content">
            <li><a href="users.php?action=edit&uID={$args.uID}">Mein Account</a></li>
            <li class="divider"></li>
            <li><a href="logon.php?logout=1">Abmelden</a></li>
        </ul>
        <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper indigo">
                <a href="#!" class="brand-logo hide-on-med-and-down" style="padding-left: 250px;"><b>IC</b>MS - {$args.title}</a>
                <a href="#!" class="brand-logo hide-on-large-only" style=""><b>IC</b>MS - {$args.title}</a>
                <ul class="right">
                    <!-- Dropdown Trigger -->
                    {if $args.editor == 1}
                    <li><a href="{$args.undoUrl}"><i class="mdi mdi-close"></i></a></li>
                    <li><a href="javascript:{}" onclick="document.getElementById('form').submit();"><i class="mdi mdi-check"></i></a></li>
                    {/if}
                    <li><a class="dropdown-button hide-on-med-and-down" href="#!" data-activates="dropdown1">{$args.usrname}<i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
                <ul id="slide-out" class="side-nav fixed">
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">ICH<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!">Dashboard</a></li>
                                        <li><a href="users.php?action=edit&uID={$args.uID}">Mein Account</a></li>
                                        <li class="hide-on-large-only"><a href="logon.php?logout=1">Abmelden</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {if $args.perm.site_view == 1 or $args.perm.timeline_view == 1 or $args.perm.news_view == 1}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Bearbeiten<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {if $args.perm.site_view == 1}<li><a href="sites.php">Seiten</a></li>{/if}
                                        {if $args.perm.timeline_view == 1}<li><a href="timeline.php?filter=%2B30T&sort=ascDate">Timeline</a></li>{/if}
                                        {if $args.perm.news_view == 1}<li><a href="news.php">News</a></li>{/if}                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {/if}
                    {if $args.perm.file_view == 1 or $args.perm.protocols_view == 1}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Dateien<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {if $args.perm.file_view == 1}<li><a href="files.php">Dateien</a></li>{/if}
                                        {if $args.perm.protocols_view == 1}<li><a href="protocols.php">Protokolle</a></li>{/if}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {/if}
                    {if $args.perm.site_approve and false or 0 == 1}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Überprüfen<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {if $args.perm.site_approve == 1 and false}<li><a href="">Ausst. Änderungen</a></li>{/if}
                                        {if 0 == 1}<li><a href="">Fragen</a></li>{/if}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {/if}
                    {if $args.perm.users_view == 1 or $args.perm.admin_database}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Administration<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {if $args.perm.users_view == 1}<li><a href="users.php?filter=Alle&sort=ascID">Benutzerkonten</a></li>{/if}
                                        {if 0 == 1}<li><a href="">Emailverteilung</a></li>{/if}
                                        {if $args.perm.admin_database == 1}<li><a href="adminer-4.2.4-mysql.php">Adminer (DB)</a></li>{/if}
                                     </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li class="indigo" style="position: absolute; width:100%; bottom: 60px; font-size: 12px; line-height: 16px; padding: 10px;">
                        ICMS&trade; Version 3.1.5b(SAS)<br/>&copy;2014-2016 Yannick F&#233;lix
                    </li>
                    {/if}
                </ul>
                {if $args.backable == 0}<a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi mdi-menu"></i></a>{/if}
                {if $args.backable == 1}<a href="{$args.undoUrl}" class="button"><i class="mdi mdi-backburger"></i></a>{/if}
            </div>
        </nav>
        </div>