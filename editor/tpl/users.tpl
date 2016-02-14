{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <!--<tr><th colspan="6" class="new"><a href="?action=new">Neuer Benutzer</a></th></tr>-->
                    <tr>
                        <th style="width: 30px; max-width: 30px;">#</th>
                        <th style="width: 90%; max-width: 90%;"></th>
                        <th style="width: 100px; max-width: 100px;"></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <!--<tr>
                            <td>{$id}</td>
                            <td>{$usrname}</td>
                            <td>{$firstname} {$lastname}</td>
                            <td>{$email}</td>
                            <td>{$prefix}</td>
                            <td><a href="users.php?action=edit&uID={$id}" class="edit">BEARBEITEN</a> | <a href="users.php?action=del&uID={$id}" class="delete">LÖSCHEN</a></td>
                        </tr>-->
                        <tr>
                            <td>{$id}</td>
                            <td>
                                <div class="list-name">{$firstname} {$lastname}</div>
                                <div class="list-type">{$prefix} {$usrname} | {$email}</div>
                            </td>
                            <td style="">
                                <a href="users.php?action=edit&uID={$id}" class="normal"><i class="mdi mdi-pencil"></i></a><a href="users.php?action=del&uID={$id}" class="normal"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    {/loop}
            </table>
            <div style="position: fixed; bottom: 20px; right: 20px;">
                <div class="fab">
                    <button class="fab__primary btn btn--xl btn--green btn--fab" lx-ripple lx-tooltip="Lorem Ipsum" tooltip-position="left" onclick="parent.location='?action=new'">
                        <i class="mdi mdi-plus"></i>
                        <i class="mdi mdi-account-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        {include file="header.tpl" args=$header}
    </body>
</html>