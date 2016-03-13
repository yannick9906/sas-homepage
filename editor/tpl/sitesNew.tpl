{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="sites.php?action=postNew" method="post" id="form">
                <div class="input-field col s12 m6 offset-m3">
                    <label for="title">Titel</label>
                    <input id="title" value="{$edit.title}" required type="text" name="name" required length="255"/>
                </div>
                <div class="input-field col s12 m6 offset-m3">
                    <select id="type" title="Type" name="type">
                        <option value="" disabled selected>W&auml;hle einen Typ</option>
                        <option {if $page.type == 1}selected{/if} value="normal">Normale Seite</option>
                        <option {if $page.type == 1}selected{/if} value="party">Partei</option>
                        <option {if $page.type == 1}selected{/if} value="ak">AK</option>
                    </select>
                    <label for="selInt">Typ</label>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {
        $('select').material_select();
    });
</script>
{include file="newEnd.tpl"}