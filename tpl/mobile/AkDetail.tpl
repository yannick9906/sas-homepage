<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=3)}

            <div tool icon="menu">Schlopolis 2.0</div>

            <!-- Main Content -->
            <div tool>Vorstellung der Arbeitskreise</div>

            <img src="group_people_icon.jpg" style="width: 100%; height: auto;"/>
            <paper-shadow z="1" class="card">
                <h2>$row->Name</h2>
                <p>$row->textlong</p>
            </paper-shadow>



            {include("counter.tpl")}

        </core-scaffold>
    </body>
</html>