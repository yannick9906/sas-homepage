{include file="base.tpl"}
<div class="content">
        <form action="timeline.php?action=postNew" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th colspan="2">
                            Timeline Eintrag erstellen
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Titel</th>
                        <td><input id="title" type="text" name="title" value="" required placeholder="Darf nicht leer sein"/></td>
                    </tr>
                    <tr>
                        <th>Text</th>
                        <td><textarea id="text" name="text" required placeholder="Darf nicht leer sein" cols="40" rows="8"></textarea></td>
                    </tr>
                    <tr>
                        <th>Datum</th>
                        <td><input id="date" type="datetime-local" name="date" value="" required placeholder="Darf nicht leer sein"/></td>
                    </tr>
                    <tr>
                        <th>Link</th>
                        <td style="word-spacing: normal; line-height: 30px;">
                            <input type="radio" value="rdNo"  id="rdNo"  name="lnkType" title="NoLink" checked/> Kein Link<br/>
                            <input type="radio" value="rdExt" id="rdExt" name="lnkType" title="Extern"/> <input id="inExt" type="url" name="lnkExtern" disabled placeholder="Extern"/><br/>
                            <input type="radio" disabled value="rdInt" id="rdInt" name="lnkType" title="Intern"/> Intern:
                            <select id="selInt" title="Intern" name="lnkIntern" size="1" disabled>
                                <option>Home</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Typ</th>
                        <td>
                            <select id="type" title="Type" name="type" size="1">
                                <option value="1">Abstimmung</option>
                                <option value="2">Start</option>
                                <option value="3">Ende</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input type="submit" value="Absenden"/></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <script src="../vertical-timeline/js/modernizr.js"></script> <!-- Modernizr -->
        <div>
            <section id="cd-timeline" class="cd-container" style="position:relative; top: 500px;">
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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="../vertical-timeline/js/main.js"></script> <!-- Resource jQuery -->
        <link rel="stylesheet" href="../vertical-timeline/css/reset.css"> <!-- CSS reset -->
        <link rel="stylesheet" href="../style/vert-timeline.css" type="text/css"/>
        <script>
            jQuery(document).ready(function($) {
                updateView();
            });

            function updateView() {
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
                $(".cd-timeline-content .cd-date").html(document.getElementById("date").value);

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
                $("#selInt").attr('disabled', true)
                $("#inExt").attr('disabled', false)
            });

            $("#rdInt").change(function(){
                console.log("Intern");
                $("#inExt").attr('disabled', true)
                $("#selInt").attr('disabled', false)
            });

            $("#rdNo").change(function(){
                console.log("None");
                $("#inExt").attr('disabled', true)
                $("#selInt").attr('disabled', true)
            });
        </script>
    </div>
{include file="header.tpl" args=$header}
</body>
</html>