{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="applications.php?action=postEdit&aID={$edit.aID}" method="post" id="form">
                <div class="input-field col s4">
                    <label for="aNum">Antrag Nummer</label>
                    <input id="aNum" type="text" value="{$edit.aNum}" name="aNum" disabled length="7"/>
                </div>
                <div class="input-field col s8">
                    <label for="name">Antragssteller</label>
                    <input id="name" type="text" value="{$edit.name}" name="name" disabled length="64"/>
                </div>
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
                <div class="input-field col s6">
                    <select id="state" title="Status" name="state">
                        <option value="0"{if $edit.state == 0} selected{/if}>In Bearbeitung</option>
                        <option value="1"{if $edit.state == 1} selected{/if}>Angenommen</option>
                        <option value="2"{if $edit.state == 2} selected{/if}>Abgelehnt</option>
                    </select>
                    <label for="state">Status</label>
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
            data: 'applications.php?action=getTags',
            valueField: 'id',
            displayField: 'name'
        });
    });
</script>
{include file="newEnd.tpl"}