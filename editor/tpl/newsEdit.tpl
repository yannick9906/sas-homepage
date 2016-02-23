{include file="base.tpl"}
<div class="content">
        <form action="news.php?action=postEdit&nID={$edit.id}" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th>
                            News Beitrag bearbeiten
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="title">Titel</label>
                                    <input id="title" value="{$edit.title}" required type="text" name="title" required length="255"/>
                                </div>
                                <div class="input-field col s12">
                                    <textarea id="text" name="text" required class="materialize-textarea" length="65355">{$edit.text}</textarea>
                                    <label for="textarea1">Text</label>
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
                                    </select>
                                    <label for="selInt">Interner Link</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Neue Version erstellen"/></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <script src="../vertical-timeline/js/modernizr.js"></script> <!-- Modernizr -->
        <div>
            <section id="cd-timeline" class="cd-container" style="position:relative; top: 550px;">
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture">
                        <img src="../vertical-timeline/img/cd-icon-voting.svg" alt="Picture">
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>Titel</h2>
                        <p>Text<a href="" class="cd-read-more">Mehr ...</a></p>
                        <span class="cd-date">Datum</span>
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
            </section> <!-- cd-timeline -->
        </div>
        <link rel="stylesheet" href="../vertical-timeline/css/reset.css"> <!-- CSS reset -->
        <link rel="stylesheet" href="../style/vert-timeline.css" type="text/css"/>
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


                $(".cd-timeline-img img").attr("src", "../vertical-timeline/img/" + icon);
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
</div>
{include file="header.tpl" args=$header}
</body>
</html>