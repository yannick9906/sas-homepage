{include file="base.tpl"}
<div class="content">
        <form action="sites.php?action=postEdit&pID={$edit.id}" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th>
                            Seite bearbeiten
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="title">Name</label>
                                    <input id="name" value="{$edit.name}" required type="text" name="name" required length="255"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="title">Titel</label>
                                    <input id="title" value="{$edit.title}" required type="text" name="title" required length="1023"/>
                                </div>
                                <div class="input-field col s12">
                                    <textarea id="text" name="text" required class="materialize-textarea" length="64501">{$edit.text}</textarea>
                                    <label for="textarea1">Text [GitHub flavored Markdown supported]</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
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