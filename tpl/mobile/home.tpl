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
            <paper-shadow z="2" id="countdown" class="card"></paper-shadow>

            <paper-shadow z="1" class="card">
                <a href="index.php?p=1"><h2>Nächster Termin</h2></a>
                <p>{$page.evTitle}<br/>{$page.evDate}</p>
            </paper-shadow>

            <paper-shadow z="1" class="card">
                <h2>Spruch der Woche {$page.spWeek}</h2>
                <p>{$page.spText}</p>
            </paper-shadow>

            {include("counter.tpl")}

            {"<!--<div class='send-message' layout horizontal>
                    <paper-input floatingLabel flex label='Type message...' id='input' value='{{input}}'></paper-input>
                    <paper-fab icon='send' id='sendButton' on-tap='{{sendMyMessage}}'></paper-fab>
                </div>-->"}