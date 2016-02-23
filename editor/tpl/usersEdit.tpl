{include file="base.tpl"}
<div class="content">
            <table class="edit">
                <thead>
                    <tr>
                        <th colspan="2">
                            User bearbeiten
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Username</th>
                        <td><form method="post" action="users.php?action=postEdit&field=usrname&uID={$edit.id}"><input type="text" name="usrname" value="{$edit.usrname}" {if $header.uID == $edit.id}disabled{else}required{/if} placeholder="Darf nicht leer sein"/> <input type="submit" value="setzen" {if $header.uID == $edit.id}disabled{/if}/></form></td>
                    </tr>
                    <tr>
                        <th>Vorname</th>
                        <td><form method="post" action="users.php?action=postEdit&field=firstname&uID={$edit.id}"><input type="text" name="firstname" value="{$edit.firstname}" {if $header.uID == $edit.id}disabled{else}required{/if} required placeholder="Darf nicht leer sein"/> <input type="submit" value="setzen" {if $header.uID == $edit.id}disabled{/if}/></form></td>
                    </tr>
                    <tr>
                        <th>Nachname</th>
                        <td><form method="post" action="users.php?action=postEdit&field=lastname&uID={$edit.id}"><input type="text" name="lastname" value="{$edit.lastname}" {if $header.uID == $edit.id}disabled{else}required{/if} required placeholder="Darf nicht leer sein"/> <input type="submit" value="setzen" {if $header.uID == $edit.id}disabled{/if}/></form></td>
                    </tr>
                    <tr>
                        <th>Neues Passwort</th>
                        <td><form method="post" action="users.php?action=postEdit&field=passwd&uID={$edit.id}"><input type="password" name="passwd" required placeholder="Darf nicht leer sein"/> <input type="submit" value="setzen"/></form></td>
                    </tr>
                    <tr>
                        <th>Emailadresse</th>
                        <td><form method="post" action="users.php?action=postEdit&field=email&uID={$edit.id}"><input type="email" name="email" value="{$edit.email}" required placeholder="Darf nicht leer sein"/> <input type="submit" value="setzen"/></form></td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>
                            <form method="post" action="users.php?action=postEdit&field=lvl&uID={$edit.id}">
                                <select name="lvl" title="lvl">
                                    <option {if $edit.lvl == 0}selected{/if} {if $header.level < 0}disabled{/if} value="0">User</option>
                                    <option {if $edit.lvl == 1}selected{/if} {if $header.level < 1}disabled{/if} value="1">Partei</option>
                                    <option {if $edit.lvl == 2}selected{/if} {if $header.level < 2}disabled{/if} value="2">AK</option>
                                    <option {if $edit.lvl == 3}selected{/if} {if $header.level < 3}disabled{/if} value="3">Orga</option>
                                    <option {if $edit.lvl == 4}selected{/if} {if $header.level < 4}disabled{/if} value="4">Lehrer</option>
                                    <option {if $edit.lvl == 5}selected{/if} {if $header.level < 5}disabled{/if} value="5">Admin</option>
                                </select>
                                <input type="submit" value="setzen"/>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>Rechte</th>
                        <td>
                            <form action="users.php?action=updatePerms&uID={$edit.id}" method="post">
                                <table>
                                    <tr><th>Rechte</th><th>{if $permU.users_perms == 1}<input type="submit" value="übernehmen"/>{/if}</th></tr>
                                    <tr><td><b>Benutzer</b></td></tr>
                                    <tr><td>Benutzer ansehen</td>       <td><input {if $perm.users_view          == 1}checked{/if} type="radio" value="1" name="users.view"/>           ON <input {if $perm.users_view          == 0}checked{/if} type="radio" value="0" name="users.view"/>             OFF</td></tr>
                                    <tr><td>Benutzer erstellen</td>     <td><input {if $perm.users_create        == 1}checked{/if} type="radio" value="1" name="users.create"/>         ON <input {if $perm.users_create        == 0}checked{/if} type="radio" value="0" name="users.create"/>           OFF</td></tr>
                                    <tr><td>Benutzer bearbeiten</td>    <td><input {if $perm.users_edit          == 1}checked{/if} type="radio" value="1" name="users.edit"/>           ON <input {if $perm.users_edit          == 0}checked{/if} type="radio" value="0" name="users.edit"/>             OFF</td></tr>
                                    <tr><td>Benutzerrechte ändern</td>  <td><input {if $perm.users_perms         == 1}checked{/if} type="radio" value="1" name="users.perms"/>          ON <input {if $perm.users_perms         == 0}checked{/if} type="radio" value="0" name="users.perms"/>              OFF</td></tr>
                                    <tr><td>Benutzer löschen</td>       <td><input {if $perm.users_del           == 1}checked{/if} type="radio" value="1" name="users.del"/>            ON <input {if $perm.users_del           == 0}checked{/if} type="radio" value="0" name="users.del"/>              OFF</td></tr>

                                    <tr><td><b>Timeline</b></td></tr>
                                    <tr><td>Timeline ansehen</td>       <td><input {if $perm.timeline_view       == 1}checked{/if} type="radio" value="1" name="timeline.view"/>        ON <input {if $perm.timeline_view       == 0}checked{/if} type="radio" value="0" name="timeline.view"/>          OFF</td></tr>
                                    <tr><td>Timeline erstellen</td>     <td><input {if $perm.timeline_create     == 1}checked{/if} type="radio" value="1" name="timeline.create"/>      ON <input {if $perm.timeline_create     == 0}checked{/if} type="radio" value="0" name="timeline.create"/>        OFF</td></tr>
                                    <tr><td>Timeline neue Version</td>  <td><input {if $perm.timeline_newVersion == 1}checked{/if} type="radio" value="1" name="timeline.newVersion"/>  ON <input {if $perm.timeline_newVersion == 0}checked{/if} type="radio" value="0" name="timeline.newVersion"/>    OFF</td></tr>
                                    <tr><td>Timeline akzetieren</td>    <td><input {if $perm.timeline_approve    == 1}checked{/if} type="radio" value="1" name="timeline.approve"/>     ON <input {if $perm.timeline_approve    == 0}checked{/if} type="radio" value="0" name="timeline.approve"/>       OFF</td></tr>
                                    <tr><td>Timeline löschen</td>       <td><input {if $perm.admin_timeline_del  == 1}checked{/if} type="radio" value="1" name="admin.timeline.del"/>   ON <input {if $perm.admin_timeline_del  == 0}checked{/if} type="radio" value="0" name="admin.timeline.del"/>     OFF</td></tr>
                                    <tr><td>Timeline bearbeiten</td>    <td><input {if $perm.admin_timeline_edit == 1}checked{/if} type="radio" value="1" name="admin.timeline.edit"/>  ON <input {if $perm.admin_timeline_edit == 0}checked{/if} type="radio" value="0" name="admin.timeline.edit"/>    OFF</td></tr>

                                    <tr><td><b>Seiten</b></td></tr>
                                    <tr><td>Seite ansehen</td>                  <td><input {if $perm.site_view          == 1}checked{/if} type="radio" value="1" name="site.view"/>          ON <input {if $perm.site_view          == 0}checked{/if} type="radio" value="0" name="site.view"/>          OFF</td></tr>
                                    <tr><td>Seite erstellen</td>                <td><input {if $perm.site_create        == 1}checked{/if} type="radio" value="1" name="site.create"/>        ON <input {if $perm.site_create        == 0}checked{/if} type="radio" value="0" name="site.create"/>        OFF</td></tr>
                                    <tr><td>Seite neue Version(Nur Eigene)</td> <td><input {if $perm.site_newVersionOwn == 1}checked{/if} type="radio" value="1" name="site.newVersionOwn"/> ON <input {if $perm.site_newVersionOwn == 0}checked{/if} type="radio" value="0" name="site.newVersionOwn"/> OFF</td></tr>
                                    <tr><td>Seite neue Version(Alle)</td>       <td><input {if $perm.site_newVersionAll == 1}checked{/if} type="radio" value="1" name="site.newVersionAll"/> ON <input {if $perm.site_newVersionAll == 0}checked{/if} type="radio" value="0" name="site.newVersionAll"/> OFF</td></tr>
                                    <tr><td>Seite akzetieren</td>               <td><input {if $perm.site_approve       == 1}checked{/if} type="radio" value="1" name="site.approve"/>       ON <input {if $perm.site_approve       == 0}checked{/if} type="radio" value="0" name="site.approve"/>       OFF</td></tr>
                                    <tr><td>Seite löschen</td>                  <td><input {if $perm.admin_site_del     == 1}checked{/if} type="radio" value="1" name="admin.site.del"/>     ON <input {if $perm.admin_site_del     == 0}checked{/if} type="radio" value="0" name="admin.site.del"/>     OFF</td></tr>
                                    <tr><td>Seite bearbeiten</td>               <td><input {if $perm.admin_site_edit    == 1}checked{/if} type="radio" value="1" name="admin.site.edit"/>    ON <input {if $perm.admin_site_edit    == 0}checked{/if} type="radio" value="0" name="admin.site.edit"/>    OFF</td></tr>

                                    <tr><td><b>News</b></td></tr>
                                    <tr><td>News ansehen</td>       <td><input {if $perm.news_view       == 1}checked{/if} type="radio" value="1" name="news.view"/>        ON <input {if $perm.news_view       == 0}checked{/if} type="radio" value="0" name="news.view"/>          OFF</td></tr>
                                    <tr><td>News erstellen</td>     <td><input {if $perm.news_create     == 1}checked{/if} type="radio" value="1" name="news.create"/>      ON <input {if $perm.news_create     == 0}checked{/if} type="radio" value="0" name="news.create"/>        OFF</td></tr>
                                    <tr><td>News neue Version</td>  <td><input {if $perm.news_newVersion == 1}checked{/if} type="radio" value="1" name="news.newVersion"/>  ON <input {if $perm.news_newVersion == 0}checked{/if} type="radio" value="0" name="news.newVersion"/>    OFF</td></tr>
                                    <tr><td>News akzetieren</td>    <td><input {if $perm.news_approve    == 1}checked{/if} type="radio" value="1" name="news.approve"/>     ON <input {if $perm.news_approve    == 0}checked{/if} type="radio" value="0" name="news.approve"/>       OFF</td></tr>
                                    <tr><td>News löschen</td>       <td><input {if $perm.admin_news_del  == 1}checked{/if} type="radio" value="1" name="admin.news.del"/>   ON <input {if $perm.admin_news_del  == 0}checked{/if} type="radio" value="0" name="admin.news.del"/>     OFF</td></tr>
                                    <tr><td>News bearbeiten</td>    <td><input {if $perm.admin_news_edit == 1}checked{/if} type="radio" value="1" name="admin.news.edit"/>  ON <input {if $perm.admin_news_edit == 0}checked{/if} type="radio" value="0" name="admin.news.edit"/>    OFF</td></tr>

                                    <tr><td><b>Dateien</b></td></tr>
                                    <tr><td>Datei ansehen</td>       <td><input {if $perm.file_view       == 1}checked{/if} type="radio" value="1" name="file.view"/>        ON <input {if $perm.file_view       == 0}checked{/if} type="radio" value="0" name="file.view"/>          OFF</td></tr>
                                    <tr><td>Datei erstellen</td>     <td><input {if $perm.file_create     == 1}checked{/if} type="radio" value="1" name="file.create"/>      ON <input {if $perm.file_create     == 0}checked{/if} type="radio" value="0" name="file.create"/>        OFF</td></tr>
                                    <tr><td>Datei löschen</td>       <td><input {if $perm.admin_file_del  == 1}checked{/if} type="radio" value="1" name="admin.file.del"/>   ON <input {if $perm.admin_file_del  == 0}checked{/if} type="radio" value="0" name="admin.file.del"/>     OFF</td></tr>
                                    <tr><td>Datei bearbeiten</td>    <td><input {if $perm.admin_file_edit == 1}checked{/if} type="radio" value="1" name="admin.file.edit"/>  ON <input {if $perm.admin_file_edit == 0}checked{/if} type="radio" value="0" name="admin.file.edit"/>    OFF</td></tr>

                                    <tr><td><b>Protokolle</b></td></tr>
                                    <tr><td>Protokoll ansehen</td>       <td><input {if $perm.protocols_view       == 1}checked{/if} type="radio" value="1" name="protocols.view"/>        ON <input {if $perm.protocols_view       == 0}checked{/if} type="radio" value="0" name="protocols.view"/>          OFF</td></tr>
                                    <tr><td>Protokoll erstellen</td>     <td><input {if $perm.protocols_create     == 1}checked{/if} type="radio" value="1" name="protocols.create"/>      ON <input {if $perm.protocols_create     == 0}checked{/if} type="radio" value="0" name="protocols.create"/>        OFF</td></tr>
                                    <tr><td>Protokoll neue Version</td>  <td><input {if $perm.protocols_newVersion == 1}checked{/if} type="radio" value="1" name="protocols.newVersion"/>  ON <input {if $perm.protocols_newVersion == 0}checked{/if} type="radio" value="0" name="protocols.newVersion"/>    OFF</td></tr>
                                    <tr><td>Protokoll akzetieren</td>    <td><input {if $perm.protocols_approve    == 1}checked{/if} type="radio" value="1" name="protocols.approve"/>     ON <input {if $perm.protocols_approve    == 0}checked{/if} type="radio" value="0" name="protocols.approve"/>       OFF</td></tr>
                                    <tr><td>Protokoll löschen</td>       <td><input {if $perm.admin_protocols_del  == 1}checked{/if} type="radio" value="1" name="admin.protocols.del"/>   ON <input {if $perm.admin_protocols_del  == 0}checked{/if} type="radio" value="0" name="admin.protocols.del"/>     OFF</td></tr>
                                    <tr><td>Protokoll bearbeiten</td>    <td><input {if $perm.admin_protocols_edit == 1}checked{/if} type="radio" value="1" name="admin.protocols.edit"/>  ON <input {if $perm.admin_protocols_edit == 0}checked{/if} type="radio" value="0" name="admin.protocols.edit"/>    OFF</td></tr>

                                    <tr><td><b>Sonstige</b></td></tr>
                                    <tr><td>Datenbank</td>               <td><input {if $perm.admin_database    == 1}checked{/if} type="radio" value="1" name="admin.database"/>    ON <input {if $perm.admin_database    == 0}checked{/if} type="radio" value="0" name="admin.database"/>    OFF</td></tr>

                                </table>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>