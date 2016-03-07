{include file="base.tpl"}
<div class="content">
        <form action="sites.php?action=postNew" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th>
                            Seite erstellen
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="title">Titel</label>
                                    <input id="title" value="{$edit.title}" required type="text" name="name" required length="255"/>
                                </div>
                                <div class="input-field col s12">
                                    <select id="type" title="Type" name="type">
                                        <option value="" disabled selected>Wähle einen Typ</option>
                                        <option value="normal">Normale Seite</option>
                                        <option value="party">Partei</option>
                                        <option value="ak">AK</option>
                                    </select>
                                    <label for="selInt">Typ</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Neue Seite erstellen"/></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div>

        </div>
    </div>
{include file="header.tpl" args=$header}
<script>
            jQuery(document).ready(function($) {
                $('select').material_select();
            });
</script>
</body>
</html>