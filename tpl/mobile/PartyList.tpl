<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=4)}

            <!-- Main Content -->
            <div tool icon="menu">Vorstellung der Parteien</div>

            {foreach $page.items item}
                <paper-shadow z="1" class="listcard">
                    <a href="index.php?p=6&id={$item.id}"><core-icon style="height: 64px; width: 64px; color: black;" icon="{$item.icon}"></core-icon></a>
                    <a href="index.php?p=6&id={$item.id}"><h2>{$item.name}</h2></a>
                    <p>{$item.info}</p>
                </paper-shadow>
            {/foreach}


            {include("counter.tpl")}

        </core-scaffold>
    </body>
</html>