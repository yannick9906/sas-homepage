        {include file="base.tpl"}
        <div class="content">
            <form method="post" action="users.php?action=postNew">
                <table class="edit">
                    <thead>
                        <tr>
                            <th colspan="2">
                                Neuer Benutzer
                            </th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr>
                                <th>Username</th>
                                <td><input type="text" name="usrname" required placeholder="Darf nicht leer sein"/> <input type="submit" value="setzen"/></td>
                            </tr>
                            <tr>
                                <th>Vorname</th>
                                <td><input type="text" name="firstname" required placeholder="Darf nicht leer sein"/></td>
                            </tr>
                            <tr>
                                <th>Nachname</th>
                                <td><input type="text" name="lastname" required placeholder="Darf nicht leer sein"/></td>
                            </tr>
                            <tr>
                                <th>Neues Passwort</th>
                                <td><input type="password" name="passwd" required placeholder="Darf nicht leer sein"/></td>
                            </tr>
                            <tr>
                                <th>Emailadresse</th>
                                <td><input type="email" name="email" required placeholder="Darf nicht leer sein"/></td>
                            </tr>
                        </tbody>
                </table>
            </form>
        </div>
        {include file="header.tpl" args=$header}
    </body>
</html>