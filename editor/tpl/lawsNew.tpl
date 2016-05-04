{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="laws.php?action=postNew" method="post" id="form">
                <div class="input-field col s4">
                    <label for="lwNum">Gesetz Nummer</label>
                    <input id="lwNum" type="text" value="" name="lwNum" required length="8"/>
                </div>
                <div class="input-field col s8">
                    <label for="name">Gesetzsteller</label>
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
            data: 'laws.php?action=getTags',
            valueField: 'id',
            displayField: 'name'
        });
    });
</script>
{include file="newEnd.tpl"}