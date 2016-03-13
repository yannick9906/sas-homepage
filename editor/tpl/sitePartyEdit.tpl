{include file="newbase.tpl" args=$header}
<main>
    <div class="container row">
        <div class="col s12 m6 card-panel row">
            <br/>
            <form action="sites.php?action=postEdit&pID={$edit.id}" method="post" id="form">
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
                    <label for="textarea1">Text <i class="mdi mdi-markdown"></i>[GitHub flavored Markdown supported]</label>
                </div>
            </form>
        </div>
        <div class="col s12 offset-m1 m5 card-panel row">
            <h5 class="center"><b>Vorschau</b></h5>
            <img class="prImg col s12"/>
            <div class="card-panel col offset-s1 s10" style="position:relative; top: -50px;">
                <h5 class="prHeader"></h5>
                <p class="prContent">

                </p>
            </div>
        </div>
    </div>
</main>
<style>
    img {
        width: 100%;
    }
    h2 {
        font-size: 24px;
        font-weight: bold;
    }
    h5 {
        font-size: 26px;
        font-weight: bold;
    }
    h6 {
        font-weight: bold;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        updateView();
    });

    function updateView() {

        $("img.prImg").attr("src", $("#image").val());
        $("h5.prHeader").html($("#title").val());
        $("p.prContent").html(markdown.toHTML($("#text").val()));

        window.setTimeout("updateView()", 500)
    }
</script>
{include file="newEnd.tpl"}