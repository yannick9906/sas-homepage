{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="timeline.php?action=postEdit&tID={$edit.id}" method="post" id="form">
                <div class="input-field col s12">
                    <label for="title">Titel</label>
                    <input id="title" value="{$edit.title}" required type="text" name="title" required length="65535"/>
                </div>
                <div class="input-field col s12">
                    <textarea id="text" name="text" required class="materialize-textarea" length="65535">{$edit.text}</textarea>
                    <label for="textarea1">Text</label>
                </div>
                <div class="input-field col s12">
                    <!--<input type="date" id="date" class="datepicker">-->
                    <input id="date" value="{$edit.date}" type="datetime-local" name="date" required/>
                    <label for="date">Datum</label>
                </div>
                <div class="input-field col s12">
                    <select id="type" title="Type" name="type">
                        <option value="" disabled selected>Wähle einen Typ</option>
                        <option {if $edit.type == 1}selected{/if} data-icon="../libs/vertical-timeline/img/cd-icon-voting-bg.svg" class="left circle" value="1">Abstimmung</option>
                        <option {if $edit.type == 2}selected{/if} data-icon="../libs/vertical-timeline/img/cd-icon-down-bg.svg" class="left circle" value="2">Start</option>
                        <option {if $edit.type == 3}selected{/if} data-icon="../libs/vertical-timeline/img/cd-icon-up-bg.svg" class="left circle" value="3">Ende</option>
                    </select>
                    <label for="selInt">Typ</label>
                </div>
                <div class="col s6">
                    <p>
                        <input name="lnkType" value="rdNo" type="radio" id="rdNo" {if $edit.linkType == "lnkNo"}checked{/if} class="with-gap" />
                        <label for="rdNo">Kein Link</label>
                    </p>
                    <p>
                        <input name="lnkType" value="rdExt" type="radio" id="rdExt" {if $edit.linkType == "lnkExt"}checked{/if} class="with-gap" />
                        <label for="rdExt">Externer Link</label>
                    </p>
                    <p>
                        <input name="lnkType" value="rdInt" type="radio" id="rdInt" {if $edit.linkType == "lnkInt"}checked{/if} class="with-gap" />
                        <label for="rdInt">Interner Link</label>
                    </p>
                </div>
                <div class="input-field col s6" id="divExt" {if $edit.linkType != "lnkExt"}style="display: none;"{/if}>
                    <input id="inExt" value="{$edit.linkTo}" type="text" name="lnkExtern" length="65355"/>
                    <label for="inExt">Externe URL</label>
                </div>
                <div class="input-field col s6" id="divInt" {if $edit.linkType != "lnkInt"}style="display: none;"{/if}>
                    <select id="selInt" title="Intern" name="lnkIntern">
                        <optgroup label="Seiten">
                            {loop $sites}
                                <option {if $id == $_.edit.lnkVal}selected{/if} value="{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                        <optgroup label="Protokolle">
                            {loop $protocols}
                                <option {if $id == $_.edit.lnkVal}selected{/if} value="{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                        <optgroup label="Dateien">
                            {loop $files}
                                <option {if $id == $_.edit.lnkVal}selected{/if} value="{$id}">{$title}</option>
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

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 20, // Creates a dropdown of 15 years to control year
        // Strings and translations
        monthsFull: ['Januar', 'Februar', 'M&auml;rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        monthsShort: ['Jan', 'Feb', 'M&auml;r', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        weekdaysFull: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],

        today: 'Heute',
        clear: 'L&ouml;schen',
        close: 'X',

        labelMonthNext: 'N&auml;chster Monat',
        labelMonthPrev: 'Vorheriger Monat',
        labelMonthSelect: 'W&auml;hle einen Monat',
        labelYearSelect: 'W&auml;hle ein Jahr',

        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        hiddenPrefix: undefined,
        hiddenSuffix: '_submit',
        hiddenName: undefined,

        firstDay: 1
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
        var imgClass = $(".cd-timeline-img");
        imgClass.removeClass("cd-picture");
        imgClass.removeClass("cd-movie");
        imgClass.removeClass("cd-location");
        imgClass.addClass(clas);
        $(".cd-timeline-content h2").html($("#title").val());
        $(".cd-timeline-content p").html($("#text").val() + '<a href="" class="cd-read-more">Mehr ...</a>');
        var date = new Date(document.getElementById("date").value);
        date.setHours(date.getHours() - 2);
        $(".cd-timeline-content .cd-date").html(date.toLocaleDateString("de-DE", {"{day: 'numeric', month: 'short', year: 'numeric'}"})+" - "+date.toLocaleTimeString("de-DE", {"{hour: 'numeric', minute: 'numeric'}"}));

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