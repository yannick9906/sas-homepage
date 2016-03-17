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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="libs/vertical-timeline/js/main.js"></script> <!-- Resource jQuery -->
<link rel="stylesheet" href="libs/vertical-timeline/css/reset.css"> <!-- CSS reset -->
<link rel="stylesheet" href="css/vert-timeline.css" type="text/css"/>