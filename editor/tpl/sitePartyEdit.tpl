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
                                    <label for="title">Bild</label>
                                    <input id="image" value="{$edit.image}" required type="text" name="image" required length="1023"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="title">Logo</label>
                                    <input id="icon" value="{$edit.icon}" required type="text" name="icon" required length="1023"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="title">Kurz Info</label>
                                    <input id="title" value="{$edit.short}" required type="text" name="short" required length="1023"/>
                                </div>
                                <div class="input-field col s12">
                                    <textarea id="text" name="text" required class="materialize-textarea" length="62337">{$edit.text}</textarea>
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

{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="sites.php?action=postEdit" method="post" id="form">
                <div class="input-field col s12">
                    <label for="title">Name</label>
                    <input id="name" value="{$edit.name}" required type="text" name="name" required length="255"/>
                </div>
                <div class="input-field col s12">
                    <label for="title">Bild</label>
                    <input id="image" value="{$edit.image}" required type="text" name="image" required length="1023"/>
                </div>
                <div class="input-field col s12">
                    <label for="title">Logo</label>
                    <input id="icon" value="{$edit.icon}" required type="text" name="icon" required length="1023"/>
                </div>
                <div class="input-field col s12">
                    <label for="title">Kurz Info</label>
                    <input id="title" value="{$edit.short}" required type="text" name="short" required length="1023"/>
                </div>
                <div class="input-field col s12">
                    <textarea id="text" name="text" required class="materialize-textarea" length="62337">{$edit.text}</textarea>
                    <label for="textarea1">Text <i class="mdi mdi-markdown">[GitHub flavored Markdown supported]</label>
                </div>
            </form>
        </div>
    </div>
</main>
<script>

</script>
{include file="newEnd.tpl"}