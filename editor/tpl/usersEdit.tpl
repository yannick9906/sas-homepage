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
                </tbody>
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>