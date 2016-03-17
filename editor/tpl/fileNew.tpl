{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form method="post" action="files.php?action=postNew" enctype="multipart/form-data" id="form">
                <div class="input-field col s12 m6 offset-m3">
                    <label for="filename">Dateiname</label>
                    <input id="filename" required type="text" name="filename" length="255"/>
                </div>
                <div class="file-field input-field col s12 m6 offset-m3">
                    <div class="btn">
                        <span>Datei</span>
                        <input type="file" required name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
</script>
{include file="newEnd.tpl"}