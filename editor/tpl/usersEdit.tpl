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
                        <th>Rechte</th>
                        <td>
                            <form action="users.php?action=updatePerms&uID={$edit.id}" method="post">
                                <table>
                                    <tr><th>Rechte</th><th>{if $perm.users_perms == 1}<input type="submit" value="übernehmen"/>{/if}</th></tr>
                                    <tr><td>Benutzer ansehen</td>       <td><input {if $perm.users_view          == 1}checked{/if} type="radio" value="1" name="users.view"/>           ON <input {if $perm.users_view          == 0}checked{/if} type="radio" value="0" name="users.view"/>             OFF</td></tr>
                                    <tr><td>Benutzer erstellen</td>     <td><input {if $perm.users_create        == 1}checked{/if} type="radio" value="1" name="users.create"/>         ON <input {if $perm.users_create        == 0}checked{/if} type="radio" value="0" name="users.create"/>           OFF</td></tr>
                                    <tr><td>Benutzer bearbeiten</td>    <td><input {if $perm.users_edit          == 1}checked{/if} type="radio" value="1" name="users.edit"/>           ON <input {if $perm.users_edit          == 0}checked{/if} type="radio" value="0" name="users.edit"/>             OFF</td></tr>
                                    <tr><td>Benutzerrechte ändern</td>  <td><input {if $perm.users_perms         == 1}checked{/if} type="radio" value="1" name="users.perms"/>          ON <input {if $perm.users_perms         == 0}checked{/if} type="radio" value="0" name="users.perms"/>              OFF</td></tr>
                                    <tr><td>Benutzer löschen</td>       <td><input {if $perm.users_del           == 1}checked{/if} type="radio" value="1" name="users.del"/>            ON <input {if $perm.users_del           == 0}checked{/if} type="radio" value="0" name="users.del"/>              OFF</td></tr>

                                    <tr><td>Timeline ansehen</td>       <td><input {if $perm.timeline_view       == 1}checked{/if} type="radio" value="1" name="timeline.view"/>        ON <input {if $perm.timeline_view       == 0}checked{/if} type="radio" value="0" name="timeline.view"/>          OFF</td></tr>
                                    <tr><td>Timeline erstellen</td>     <td><input {if $perm.timeline_create     == 1}checked{/if} type="radio" value="1" name="timeline.create"/>      ON <input {if $perm.timeline_create     == 0}checked{/if} type="radio" value="0" name="timeline.create"/>        OFF</td></tr>
                                    <tr><td>Timeline neue Version</td>  <td><input {if $perm.timeline_newVersion == 1}checked{/if} type="radio" value="1" name="timeline.newVersion"/>  ON <input {if $perm.timeline_newVersion == 0}checked{/if} type="radio" value="0" name="timeline.newVersion"/>    OFF</td></tr>
                                    <tr><td>Timeline akzetieren</td>    <td><input {if $perm.timeline_approve    == 1}checked{/if} type="radio" value="1" name="timeline.approve"/>     ON <input {if $perm.timeline_approve    == 0}checked{/if} type="radio" value="0" name="timeline.approve"/>       OFF</td></tr>
                                    <tr><td>Timeline löschen</td>       <td><input {if $perm.admin_timeline_del  == 1}checked{/if} type="radio" value="1" name="admin.timeline.del"/>   ON <input {if $perm.admin_timeline_del  == 0}checked{/if} type="radio" value="0" name="admin.timeline.del"/>     OFF</td></tr>
                                    <tr><td>Timeline bearbeiten</td>    <td><input {if $perm.admin_timeline_edit == 1}checked{/if} type="radio" value="1" name="admin.timeline.edit"/>  ON <input {if $perm.admin_timeline_edit == 0}checked{/if} type="radio" value="0" name="admin.timeline.edit"/>    OFF</td></tr>

                                    <tr><td>Seite ansehen</td>       <td><input {if $perm.site_view       == 1}checked{/if} type="radio" value="1" name="site.view"/>        ON <input {if $perm.site_view       == 0}checked{/if} type="radio" value="0" name="site.view"/>          OFF</td></tr>
                                    <tr><td>Seite erstellen</td>     <td><input {if $perm.site_create     == 1}checked{/if} type="radio" value="1" name="site.create"/>      ON <input {if $perm.site_create     == 0}checked{/if} type="radio" value="0" name="site.create"/>        OFF</td></tr>
                                    <tr><td>Seite neue Version</td>  <td><input {if $perm.site_newVersion == 1}checked{/if} type="radio" value="1" name="site.newVersion"/>  ON <input {if $perm.site_newVersion == 0}checked{/if} type="radio" value="0" name="site.newVersion"/>    OFF</td></tr>
                                    <tr><td>Seite akzetieren</td>    <td><input {if $perm.site_approve    == 1}checked{/if} type="radio" value="1" name="site.approve"/>     ON <input {if $perm.site_approve    == 0}checked{/if} type="radio" value="0" name="site.approve"/>       OFF</td></tr>
                                    <tr><td>Seite löschen</td>       <td><input {if $perm.admin_site_del  == 1}checked{/if} type="radio" value="1" name="admin.site.del"/>   ON <input {if $perm.admin_site_del  == 0}checked{/if} type="radio" value="0" name="admin.site.del"/>     OFF</td></tr>
                                    <tr><td>Seite bearbeiten</td>    <td><input {if $perm.admin_site_edit == 1}checked{/if} type="radio" value="1" name="admin.site.edit"/>  ON <input {if $perm.admin_site_edit == 0}checked{/if} type="radio" value="0" name="admin.site.edit"/>    OFF</td></tr>

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