{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr><th colspan="6" class="new"><a href="?action=new">Neuer Benutzer</a></th></tr>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Voller Name</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <tr>
                            <td>{$id}</td>
                            <td>{$usrname}</td>
                            <td>{$firstname} {$lastname}</td>
                            <td>{$email}</td>
                            <td>{$prefix}</td>
                            <td><a href="users.php?action=edit&uID={$id}" class="edit">BEARBEITEN</a> | <a href="users.php?action=del&uID={$id}" class="delete">LÖSCHEN</a></td>
                        </tr>
                    {/loop}
            </table>
        </div>
        {include file="header.tpl" args=$header}
    </body>
</html>