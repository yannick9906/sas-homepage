<div class="header">
            <div class="logo"><b>IC</b>MS</div>
            <input class="search" type="text" placeholder="Suchen" />
            <div class="account-logo" onclick="onclickaccount()">{$args.usrchar}</div>
            <div class="account-detail" id="toggl">
                <ul>
                    <li>Eingeloggt als</li>
                    <li>{$args.usrname}</li>
                    <hr/>
                    <li><a href="users.php?action=edit&uID={$args.uID}">Account</a></li>
                    <hr/>
                    <li><a href="logon.php?logout=1">Logout</a></li>
                </ul>
            </div>
            <div class="title">{$args.title}</div>
        </div>
        <div class="aside">
            <ul>
                {if $args.level >= 0}
                <li>User</li>
                {if 0 == 1}<li><a href="">Dashboard</a></li>{/if}
                {if $args.perm.site_view == 1}<li><a href="">Änderungen</a></li>{/if}
                {if $args.perm.site_view == 1}<li><a href="sites.php">Seiten</a></li>{/if}
                {if $args.perm.news_view == 1}<li><a href="news.php">News</a></li>{/if}
                {if 0 == 1}<li><a href="">Download</a></li>{/if}
                {if 0 == 1}<li><a href="">Bilder</a></li>{/if}
                {if $args.perm.timeline_view == 1}<li><a href="timeline.php">Timeline</a></li>{/if}
                {/if}
                {if $args.level >= 1}
                <hr/>
                <li>Moderation</li>
                {if $args.perm.site_approve == 1}<li><a href="">Ausst. Änderungen</a></li>{/if}
                {if 0 == 1}<li><a href="">Fragen</a></li>{/if}
                {if $args.perm.users_view == 1}<li><a href="users.php">Benutzerkonten</a></li>{/if}
                {/if}
                {if $args.level >= 2}
                <hr/>
                <li>Admin</li>
                {if $args.perm.site_approve == 1}<li><a href="">Ausst. Änderungen</a></li>{/if}
                {if $args.perm.users_view == 1}<li><a href="users.php">Benutzerkonten</a></li>{/if}
                {if 0 == 1}<li><a href="">Emailverteilung</a></li>{/if}
                {if $args.perm.admin_database == 1}<li><a href="adminer-4.2.4-mysql.php">Adminer (DB)</a></li>{/if}
                {/if}
                <hr/>
                <li>{exectime 3}ms</li>
            </ul>
            <span style="position: absolute; bottom: 5px; font-family: 'Roboto'; font-size: 11.5px;">ICMS&trade; Version 3.1.1(SAS) <span style="color: red;">beta</span><br/>&copy;2014-2016 Yannick F&#233;lix</span>
        </div>
        <div style="position: fixed; top: 0; left: 135px; z-index: 1000; color: red; font-family: 'Roboto'; font-size: 15px">beta</div>
        <!-- Before body closing tag -->
        <script src="bower_components/jquery/dist/jquery.js"></script>
        <script src="bower_components/velocity/velocity.js"></script>
        <script src="bower_components/moment/min/moment-with-locales.js"></script>
        <script src="bower_components/angular/angular.js"></script>
        <script src="bower_components/lumx/dist/lumx.js"></script>