{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="applications.php?action=postNew" method="post" id="form">
                <div class="input-field col s4">
                    <label for="aNum">Antrag Nummer</label>
                    <input id="aNum" type="text" value="#" name="aNum" required length="16"/>
                </div>
                <div class="input-field col s8">
                    <label for="name">Antragssteller</label>
                    <input id="name" type="text" name="name" required length="64"/>
                </div>
                <div class="input-field col s12">
                    <label for="title">Titel</label>
                    <input id="title" type="text" name="title" required length="256"/>
                </div>
                <div class="input-field col s12">
                    <textarea id="text" name="text" required class="materialize-textarea" length="65355"></textarea>
                    <label for="text">Kurzbeschreibung</label>
                </div>
                <div class="input-field col s6">
                    <select id="file" title="Datei" name="file">
                        <optgroup label="Dateien">
                            {loop $files}
                                <option value="f{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                    </select>
                    <label for="file">Datei</label>
                </div>
                <div class="input-field col s6">
                    <select id="state" title="Status" name="state">
                        <option value="0" selected>In Bearbeitung</option>
                        <option value="1">Angenommen</option>
                        <option value="2">Abgelehnt</option>
                    </select>
                    <label for="state">Status</label>
                </div>
                <div class="input-field col s12">
                    Tags
                    <input id="ms" class="" name="tags[]"/>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    $(document).ready(function($) {
        $('select').material_select();
        $('#ms').magicSuggest({
            data: 'applications.php?action=getTags',
            valueField: 'id',
            displayField: 'name'
        });
    });
</script>
{include file="newEnd.tpl"}