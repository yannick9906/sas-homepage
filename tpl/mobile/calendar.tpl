<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=1)}

            <!-- Main Content -->
            <div tool icon="menu">Kalender</div>

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