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
                    <label for="title">Titel</label>
                    <input id="title" value="{$edit.title}" required type="text" name="title" required length="1023"/>
                </div>
                <div class="input-field col s12">
                    <textarea id="text" name="text" required class="materialize-textarea" length="64501">{$edit.text}</textarea>
                    <label for="textarea1">Text <i class="mdi mdi-markdown">[GitHub flavored Markdown supported]</label>
                </div>
            </form>
        </div>
    </div>
</main>
<script>

</script>
{include file="newEnd.tpl"}