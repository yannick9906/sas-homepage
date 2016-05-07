{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="laws.php?action=postEdit&lwID={$edit.lwID}" method="post" id="form">
                <div class="input-field col s4">
                    <label for="lwNum">Gesetz Nummer</label>
                    <input id="lwNum" type="text" value="{$edit.lwNum}" name="lwNum" disabled length="8"/>
                </div>
                    <input id="name" type="hidden" value="{$edit.name}" name="name" disabled length="64"/>
                <div class="input-field col s12">
                    <label for="title">Titel</label>
                    <input id="title" type="text" value="{$edit.title}" name="title" required length="256"/>
                </div>
                <div class="input-field col s12">
                    <textarea id="text" name="text" required class="materialize-textarea" length="65355">{$edit.shorttext}</textarea>
                    <label for="text">Kurzbeschreibung</label>
                </div>
                <div class="input-field col s6">
                    <select id="file" title="Datei" name="file">
                        <optgroup label="Dateien">
                            {loop $files}
                                <option {if $_.edit.fID == $id}selected {/if}value="f{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                    </select>
                    <label for="file">Datei</label>
                </div>
                <div class="input-field col s12">
                    Tags
                    <input id="ms" class="" name="tags[]" value="[{$i = 0}{foreach $edit.tagsList item}{if $_.i != 0},{/if}{$item}{$i = $i + 1}{/foreach}]"/>
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
        window.setTimeout("update()", 400);
    });

    function update() {
        Materialize.updateTextFields()
    }
</script>
{include file="newEnd.tpl"}