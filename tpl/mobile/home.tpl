<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved onload="countdown()">
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=0)}

            <div tool icon="menu">Schlopolis</div>

            <!-- Main Content -->
            <paper-shadow>
                <video width="100%" controls autoplay>
                    <source src="mp4/trailer.mp4" type="movie/mp4">
                    <source src="mp4/trailer-hd.mp4" type="movie/mp4">
                </video>
            </paper-shadow>
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
        </core-scaffold>

        <script src="javascript/main.js"></script>
    </body>
</html>