0<div tool icon="menu">Schlopolis</div>

            <!-- Main Content -->
            <paper-shadow style="width:100%; height:0; padding-bottom: 51%" class="video">
                <iframe width="100%" height="auto" src="https://www.youtube.com/embed/ccRyW5vUJ10?autoplay=1&showinfo=0&modestbranding=1&rel=0" frameborder="0" allowfullscreen></iframe>
            </paper-shadow>
            <style>
                .video iframe {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    left: 0; top: 0;
                }
            </style>

            <section id="cd-timeline" class="cd-container">
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture">
                        <img src="vertical-timeline/img/cd-icon-picture.svg" alt="Picture">
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2 id="countdown"></h2>
                        <p></p>
                        <span class="cd-date">11 Jul 2016 - 08:00</span>
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
                {foreach $page.items item}
                    <div class="cd-timeline-block">
                            <div class="cd-timeline-img cd-location">
                                <img src="vertical-timeline/img/cd-icon-voting.svg" alt="Picture">
                            </div> <!-- cd-timeline-img -->

                            <div class="cd-timeline-content">
                                <h2>{$item.title}</h2>
                                <p>{$item.text}</p>
                                {if $item.link != null}<a href="{$item.link}" class="cd-read-more">Mehr ...</a>{/if}
                                <span class="cd-date">{$item.date}</span>
                            </div> <!-- cd-timeline-content -->
                        </div> <!-- cd-timeline-block -->
                {/foreach}
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-movie">
                        <img src="vertical-timeline/img/cd-icon-location.svg" alt="Picture">
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>Spruch der Woche</h2>
                        <p>{$page.spText}</p>
                        <span class="cd-date">Kalenderwoche {$page.spWeek}</span>
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture">
                        <img src="vertical-timeline/img/cd-icon-voting.svg" alt="Picture">
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>Nächster Termin</h2>
                        <p>{$page.evTitle}</p>
                        <a href="#p=1" class="cd-read-more">Mehr ...</a>
                        <span class="cd-date">{$page.evDate}</span>
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
            </section>

            {include("counter.tpl")}

            {"<!--<div class='send-message' layout horizontal>
                    <paper-input floatingLabel flex label='Type message...' id='input' value='{{input}}'></paper-input>
                    <paper-fab icon='send' id='sendButton' on-tap='{{sendMyMessage}}'></paper-fab>
                </div>-->"}
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="vertical-timeline/js/main.js"></script> <!-- Resource jQuery -->
            <link rel="stylesheet" href="vertical-timeline/css/reset.css"> <!-- CSS reset -->
            <link rel="stylesheet" href="style/vert-timeline.css" type="text/css"/>