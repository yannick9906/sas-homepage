{include file="base.tpl"}
<div class="content">
        <form action="sites.php?action=postEdit&pID={$edit.id}" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th colspan="2">
                            Seite bearbeiten
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><input id="name" value="{$edit.name}" type="text" name="name" required placeholder="Darf nicht leer sein"/></td>
                    </tr>
                    <tr>
                        <th>Image</th>
                        <td><input id="image" value="{$edit.image}" type="text" name="image" required placeholder="Darf nicht leer sein"/></td>
                    </tr>
                    <tr>
                        <th>Logo</th>
                        <td><input id="icon" value="{$edit.icon}" type="text" name="icon" required placeholder="Darf nicht leer sein"/></td>
                    </tr>
                    <tr>
                        <th>Kurz Info</th>
                        <td><input id="info" value="{$edit.short}" type="text" name="info" required placeholder="Darf nicht leer sein"/></td>
                    </tr>
                    <tr>
                        <th>Text [Markdown Support]</th>
                        <td><textarea id="text" name="text" required cols="40" rows="8">{$edit.text}</textarea></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input type="submit" value="Neue Version erstellen"/></td>
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