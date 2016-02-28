{include file="base.tpl"}
<div class="content">
            <form method="post" action="files.php?action=postNew" enctype="multipart/form-data">
                <table class="edit">
                    <thead>
                        <tr>
                            <th>
                                Datei hochladen
                            </th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr><td>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <label for="firstname">Dateiname</label>
                                            <input id="firstname" required type="text" name="filename" length="255"/>
                                        </div>
                                        <div class="file-field input-field col s12">
                                            <div class="btn">
                                                <span>Datei</span>
                                                <input type="file" required name="file">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text">
                                            </div>
                                        </div>
                                    </div>
                            </td></tr>
                            <tr><td><input type="submit" value="Datei hochladen"/></td></tr>
                        </tbody>
                </table>
            </form>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>