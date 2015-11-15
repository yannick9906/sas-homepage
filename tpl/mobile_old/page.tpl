<!DOCTYPE html>
<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved onload="countdown()">
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=$page.highlight)}

            <div tool icon="menu">{$header.title}</div>

            <paper-shadow z="1" class="card">
                {$page.text}
            </paper-shadow>
        </core-scaffold>
    </body>
</html>