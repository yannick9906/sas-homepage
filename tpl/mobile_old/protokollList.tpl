<!DOCTYPE html>
<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=3)}

            <!-- Main Content -->
            <div tool icon="menu">Protokolle</div>

            {foreach $page.items item}
                <paper-shadow z="1" class="listcard">
                    <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                    <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                    <a href="{$item.dl}"><p>{$item.info}</p></a>
                </paper-shadow>
            {/foreach}


            {include("counter.tpl")}

        </core-scaffold>
    </body>
</html>