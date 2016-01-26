{include file="base.tpl"}
<div class="content">
        <form action="sites.php?action=postEdit&pID={$edit.id}" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th colspan="2">
                            Seitenversionsunterschiede anzeigen
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr><th></th><td>Unterschied zwischen #{$diff.v1} und #{$diff.v2}</td></tr>
                    <tr>
                        <th>Name</th>
                        <td>{$diff.name}</td>
                    </tr>
                    <tr>
                        <th>Titel</th>
                        <td>{$diff.header}</td>
                    </tr>
                    <tr>
                        <th>Text [Markdown Support]</th>
                        <td>{$diff.text}</td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div>

        </div>
    </div>
{include file="header.tpl" args=$header}
</body>
</html>