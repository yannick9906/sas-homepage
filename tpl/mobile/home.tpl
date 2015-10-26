<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved onload="countdown()">
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=0)}

            <div tool icon="menu">Schlopolis 2.0</div>

            <!-- Main Content -->
            <paper-shadow z="2" id="countdown" class="card"></paper-shadow>

            <paper-shadow z="1" class="card">
                <a href="index.php?p=1"><h2>Nächster Termin</h2></a>
                <p>{$page.evDate} - {$page.evTitle}</p>
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