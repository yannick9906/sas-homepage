2<div class="container">
    <div class="row">
        <div class="card-panel col s12 m6">
            <iframe width="100%" height="250px" src="https://www.youtube.com/embed/ccRyW5vUJ10?showinfo=0&modestbranding=1&rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="card-panel col s12 m5 offset-m1">
            <h3>Countdown</h3>
            <p id="countdown">11 Jul 2016 - 08:00</p>
            <br/>
            <h3>Spruch der Woche {$page.spWeek}</h3>
            <p>{$page.spText}</p>
        </div>
        <div class="card-panel col s12 m23 grey lighten-4">
            <h3>Timeline</h3>
            <section id="cd-timeline" class="cd-container">
                {foreach $page.items item}
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img {$item.htmlclass}">
                            <img src="libs/vertical-timeline/img/{$item.imgpath}" alt="Picture">
                        </div> <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>{$item.title}</h2>
                            <p>{$item.text}{if $item.link != null}<a href="{$item.link}" class="cd-read-more">Mehr ...</a>{/if}</p>
                            <span class="cd-date">{$item.date}</span>
                        </div> <!-- cd-timeline-content -->
                    </div> <!-- cd-timeline-block -->
                {/foreach}
            </section>
            <a href="#p=1" class="btn-flat blue-text waves-effect">Mehr...</a>
        </div>
        <div class="card-panel col s12 m23">
            <h3>Was ist Schlopolis?</h3>
            <p>
                Schule als Staat (SaS) ist ein groß angelegtes Planspiel, bei dem die gesamte Schulgemeinschaft sich für einige Tage in einen Staat verwandelt. Alle Beteiligten, also alle Schüler und Lehrer, sind gleichberechtigte Bürger des Staates und übernehmen darin eine Rolle, zum Beispiel Staatsoberhaupt oder Regierungsmitglied, Arbeitgeber oder Arbeitnehmer, Mitglied der Verwaltung, Angestellter im öffentlichen Dienst oder ähnliches. Der Staat verfügt - wie in der Realität - über eine Regierung, Verwaltung, Gerichtsbarkeit, Vollzugsorgan, Wirtschaft, Kulturwesen, Banken, Währung, und Flagge sowie selbstverständlich eine große Zahl von Bürgern und Touristen.
            </p>
            <br/>
            <img src="img/other/lernziele.jpg" width="100%" height="auto"/>
        </div>
    </div>
</div>
<style>
    h3 {
        font-weight: bold;
        line-height: 35px;
        font-size: 30px;
    }
    .card-panel {
        padding: 20px !important;
    }
</style>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/main.js"></script>
<script src="libs/vertical-timeline/js/main.js"></script> <!-- Resource jQuery -->
<link rel="stylesheet" href="libs/vertical-timeline/css/reset.css"> <!-- CSS reset -->
<link rel="stylesheet" href="css/vert-timeline.css" type="text/css"/>