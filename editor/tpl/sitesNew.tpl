{include file="base.tpl"}
<div class="content">
        <form action="sites.php?action=postNew" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th colspan="2">
                            Seite erstellen
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><input id="title" type="text" name="title" value="" required placeholder="Darf nicht leer sein"/></td>
                    </tr>
                    <tr>
                        <th>Typ</th>
                        <td><select title="Typ Auswählen" name="type">
                                <option value="normal">Normale Seite</option>
                                <option value="party">Partei</option>
                                <option value="ak">AK</option>
                            </select></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input type="submit" value="Neue Seite erstellen"/></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div>

        </div>
    </div>
{include file="header.tpl" args=$header}
</body>
</html>