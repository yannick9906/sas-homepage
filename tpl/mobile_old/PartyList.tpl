<!DOCTYPE html>
<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=6)}

            <!-- Main Content -->
            <div tool icon="menu">Wahlen</div>

            {loop $page.items}
                <paper-shadow z="1" class="listcard" style="min-height: 40px; height: 50%">
                    <a href="index.php?p=6&id={$id}"><core-icon style="height: 64px; width: 64px; color: black;" icon="{$icon}"></core-icon></a>
                    <a href="index.php?p=6&id={$id}"><h2>{$name}</h2></a>
                    <a href="index.php?p=6&id={$id}"><p>{$info}</p></a>
                </paper-shadow>
            {/loop}
            {if $page.ok == 1}
                <paper-shadow z="1" class="listcard">
                    Du m&ouml;chtest eine Partei gr&uuml;nden?<br/>
                    <a href="pdf/Parteigründung.pdf">Hier ist das Formular</a>
                </paper-shadow>
                <paper-shadow z="2" class="listcard">
                    Hier kannst du als Direktmandat kandidieren.<br/>
                    <a href="pdf/Direktmandat.pdf">Formular</a>
                </paper-shadow>
                <paper-shadow z="3" class="listcard">
                    Oder willst du gleich als Monarch kandidieren?<br/>
                    <a href="pdf/Monarch.pdf">Dann ist hier das Formular</a>
                </paper-shadow>
            {/if}

            {include("counter.tpl")}

        </core-scaffold>
    </body>
</html>