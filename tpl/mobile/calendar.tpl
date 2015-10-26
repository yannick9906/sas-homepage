<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved onload="countdown()">
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=1)}

            <div tool icon="menu">Schlopolis 2.0</div>

            <!-- Main Content -->
            <div tool>Kalender</div>

            {foreach $page.items item}
                <paper-shadow z="1" class="card">
                    <h2>{$item.title}</h2>
                    <p>{$item.date} - {$item.text}</p>
                </paper-shadow>
            {/foreach}


            {include("counter.tpl")}

        </core-scaffold>
    </body>
</html>