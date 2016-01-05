{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr><th class="new"><a href="timeline.php"><-</a></th><th class="new" colspan="7"></th></tr>
                    <tr>
                        <th>#</th>
                        <th>Anzeigedatum</th>
                        <th>Titel</th>
                        <th>Link</th>
                        <th>Author</th>
                        <th>Geändert</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <tr>
                            <td>{$version}</td>
                            <td>{$date}</td>
                            <td>{$title}</td>
                            <td>{if $linkTo == ""}<i>keiner</i>{else}Extern{/if}</td>
                            <td>{$lastEditAuthor}</td>
                            <td>{$lastEdit}</td>
                            <td class="{$stateCSS}">{$stateText}</td>
                            <td><a {if $index == 0}class="disabled"{else}href="timeline.php?action=jumpTo&vID={$vId}" class="version"{/if}>ZURÜCKSPRINGEN</a></td>
                        </tr>
                    {/loop}
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>