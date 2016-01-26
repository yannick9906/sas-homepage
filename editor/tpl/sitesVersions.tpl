{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr><th class="new"><a href="sites.php"><-</a></th><th class="new" colspan="7"></th></tr>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
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
                            <td>{$title}</td>
                            <td>{$lastEditAuthor}</td>
                            <td>{$lastEdit}</td>
                            <td class="{$stateCSS}">{$stateText}</td>
                            <td><a {if $index == 0}class="disabled"{else}href="sites.php?action=jumpTo&vID={$vId}" class="version"{/if}>ZURÜCKSPRINGEN</a> | <a {if $negIndex == 0}class="disabled"{else}href="sites.php?action=versDetail&vID={$vId}" class="edit"{/if}>DETAILS</a></td>
                        </tr>
                    {/loop}
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>