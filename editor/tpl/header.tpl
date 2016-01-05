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
                <li><a href="">Dashboard</a></li>
                <li><a href="">Änderungen</a></li>
                <li><a href="">Seiten</a></li>
                <li><a href="">News</a></li>
                <li><a href="">Download</a></li>
                <li><a href="">Bilder</a></li>
                <li><a href="timeline.php">Timeline</a></li>
                {/if}
                {if $args.level >= 1}
                <hr/>
                <li>Moderation</li>
                <li><a href="">Ausst. Änderungen</a></li>
                <li><a href="">Ausst. Anfragen</a></li>
                <li><a href="">Fragen</a></li>
                <li><a href="users.php">Benutzerkonten</a></li>
                {/if}
                {if $args.level >= 2}
                <hr/>
                <li>Admin</li>
                <li><a href="">Ausst. Änderungen</a></li>
                <li><a href="">Ausst. Anfragen</a></li>
                <li><a href="users.php">Benutzerkonten</a></li>
                <li><a href="">Emailverteilung</a></li>
                <li><a href="adminer-4.2.3-mysql.php">Adminer (DB)</a></li>
                {/if}
                <hr/>
                <li>{exectime 3}ms</li>
            </ul>
        </div>