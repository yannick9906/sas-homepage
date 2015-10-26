<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved onload="countdown()">
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=2)}

            <div tool icon="menu">Schlopolis 2.0</div>

            <!-- Main Content -->
            <div tool>News</div>

                <paper-shadow z="1" class="card">
                    <h2>Seite noch nicht verfügbar</h2>
                </paper-shadow>


            {include("counter.tpl")}

        </core-scaffold>
    </body>
</html>