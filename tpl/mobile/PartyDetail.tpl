<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=6)}

            <!-- Main Content -->
            <div tool icon="menu">Vorstellung der Parteien</div>

            <img src="group_people_icon.jpg" style="width: 100%; height: auto;"/>
            <paper-shadow z="1" class="detailcard">
                <h2>{$page.title}</h2>
                <p>{$page.text}</p>
            </paper-shadow>



            {include("counter.tpl")}

        </core-scaffold>
    </body>
</html>