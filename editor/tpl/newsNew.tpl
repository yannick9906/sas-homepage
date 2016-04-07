{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="news.php?action=postNew" method="post" id="form">
                <div class="input-field col s12">
                    <label for="title">Titel</label>
                    <input id="title" required type="text" name="title" required length="255"/>
                </div>
                <div class="input-field col s12">
                    <textarea id="text" name="text" required class="materialize-textarea" length="65355"></textarea>
                    <label for="textarea1">Text</label>
                </div>
                <div class="col s6">
                    <p>
                        <input name="lnkType" value="rdNo" type="radio" id="rdNo" checked class="with-gap" />
                        <label for="rdNo">Kein Link</label>
                    </p>
                    <p>
                        <input name="lnkType" value="rdExt" type="radio" id="rdExt" class="with-gap" />
                        <label for="rdExt">Externer Link</label>
                    </p>
                    <p>
                        <input name="lnkType" value="rdInt" type="radio" id="rdInt" class="with-gap" />
                        <label for="rdInt">Interner Link</label>
                    </p>
                </div>
                <div class="input-field col s6" id="divExt" style="display: none;">
                    <input id="inExt" value="{$edit.linkTo}" type="text" name="lnkExtern" length="65355"/>
                    <label for="inExt">Externe URL</label>
                </div>
                <div class="input-field col s6" id="divInt" style="display: none;">
                    <select id="selInt" title="Intern" name="lnkIntern">
                        <optgroup label="Seiten">
                            {loop $sites}
                                <option value="p{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                        <optgroup label="Protokolle">
                            {loop $protocols}
                                <option value="pr{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                        <optgroup label="Dateien">
                            {loop $files}
                                <option value="f{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                    </select>
                    <label for="selInt">Interner Link</label>
                </div>
            </form>
        </div>
        <div class="card-panel row">
            <h2><b>Vorschau</b></h2>
            <script src="../libs/vertical-timeline/js/main.js"></script> <!-- Resource jQuery -->
            <script src="../libs/vertical-timeline/js/modernizr.js"></script> <!-- Modernizr -->
            <div class="col s12">
                <section id="cd-timeline" class="cd-container" style="font-family: 'Roboto', sans-serif;">
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-picture">
                            <img src="../libs/vertical-timeline/img/cd-icon-voting.svg" alt="Picture">
                        </div> <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Titel</h2>
                            <p>Text<a href="" class="cd-read-more">Mehr ...</a></p>
                            <span class="cd-date">Datum</span>
                        </div> <!-- cd-timeline-content -->
                    </div> <!-- cd-timeline-block -->
                </section> <!-- cd-timeline -->
            </div>
            <link rel="stylesheet" href="../libs/vertical-timeline/css/reset.css"> <!-- CSS reset -->
            <link rel="stylesheet" href="../css/vert-timeline.css" type="text/css"/>

        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {
        updateView();
        $('select').material_select();
    });

    function updateView() {
        //$('select').material_select();
        // For todays date;
        Date.prototype.today = function () {
            return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
        }

        // For the time now
        Date.prototype.timeNow = function () {
            return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
        }

        var icon = "cd-icon-picture.svg";
        var clas = "cd-picture";
        var type = $("#type");
        if(type.val() == 1) { icon = "cd-icon-voting.svg"; clas = "cd-picture"; }
        else if(type.val() == 2) { icon = "cd-icon-down.svg"; clas = "cd-movie"; }
        else if(type.val() == 3) { icon = "cd-icon-up.svg"; clas = "cd-location"; }


        $(".cd-timeline-img img").attr("src", "../libs/vertical-timeline/img/" + icon);
        var imgClass = $(".cd-timeline-img")
        imgClass.removeClass("cd-picture");
        imgClass.removeClass("cd-movie");
        imgClass.removeClass("cd-location");
        imgClass.addClass(clas);
        $(".cd-timeline-content h2").html($("#title").val());
        $(".cd-timeline-content p").html($("#text").val() + '<a href="" class="cd-read-more">Mehr ...</a>');
        $(".cd-timeline-content .cd-date").html(new Date().today() + " " + new Date().timeNow());

        var lnkSel = $("input:radio[name=lnkType]:checked");
        var readMore = $(".cd-read-more");
        if(lnkSel.val() == "rdNo") {
            readMore.hide();
        } else {
            readMore.show();
        }

        window.setTimeout("updateView()", 100)
    }

    $("#rdExt").change(function(){
        console.log("Extern");
        $("#divInt").hide()
        $("#divExt").show();
        $("#inExt").attr('disabled', false);
        $("select").attr('disabled', false);
    });

    $("#rdInt").change(function(){
        console.log("Intern");
        $("#divInt").show();
        $("#divExt").hide();
        $("#inExt").attr('disabled', false);
        $("select").attr('disabled', false);
    });

    $("#rdNo").change(function(){
        console.log("None");
        $("#inExt").attr('disabled', true);
        $("select").attr('disabled', true);
    });
</script>
{include file="newEnd.tpl"}