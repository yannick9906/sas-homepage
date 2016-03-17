2<div class="container">
    <div class="row">
        <div class="card-panel col s12 m6">
            <iframe width="100%" height="auto" src="https://www.youtube.com/embed/ccRyW5vUJ10?showinfo=0&modestbranding=1&rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="card-panel col s12 m5 offset-m1">
            <h3>Countdown</h3>
            <p id="countdown">11 Jul 2016 - 08:00</p>
            <br/>
            <h3>Spruch der Woche {$page.spWeek}</h3>
            <p>{$page.spText}</p>

        </div>
        <div class="card-panel col s12 m12 grey lighten-4">
            <h3>News</h3>
            <section id="cd-timeline" class="cd-container">
                {foreach $page.items item}
                    <div class="cd-timeline-block">
                            <div class="cd-timeline-img cd-location">
                                <img src="libs/vertical-timeline/img/cd-icon-voting.svg" alt="Picture">
                            </div> <!-- cd-timeline-img -->

                            <div class="cd-timeline-content">
                                <h2>{$item.title}</h2>
                                <p>{$item.text}</p>
                                {if $item.link != null}<a href="{$item.link}" class="cd-read-more">Mehr ...</a>{/if}
                                <span class="cd-date">{$item.date}</span>
                            </div> <!-- cd-timeline-content -->
                        </div> <!-- cd-timeline-block -->
                {/foreach}
            </section>
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