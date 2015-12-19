{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr><th colspan="10" class="new"><a href="?action=new">Neuer Timeline Eintrag</a></th></tr>
                    <tr>
                        <th>#</th>
                        <th>Anzeigedatum</th>
                        <th>Titel</th>
                        <th>Infotext</th>
                        <th>Typ</th>
                        <th>Link</th>
                        <th>Author</th>
                        <th>Version</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <tr>
                            <td>{$id}</td>
                            <td>{$date}</td>
                            <td>{$title}</td>
                            <td>{$text}</td>
                            <td>{$type}</td>
                            <td>{if $linkTo == ""}<i>keiner</i>{else}{$linkTo}{/if}</td>
                            <td>{$author}</td>
                            <td>#{$version} von {$lastEditAuthor}<br/>am {$lastEdit}</td>
                            <td class="{$stateCSS}">{$stateText}</td>
                            <td><a {if !(!$state == 0 and $permApprove == 1)}class="disabled"{else}href="timeline.php?action=approve&vID={$vId}" class="edit"{/if}>GENEHMIGEN</a> | <a {if !(!$state == 0 and $permApprove == 1)}class="disabled"{else}href="timeline.php?action=deny&vID={$vId}" class="delete"{/if}>ABLEHNEN</a><br/><a href="timeline.php?action=edit&vID={$vId}" class="edit">BEARBEITEN</a> | <a href="timeline.php?action=edit&vID={$vId}" class="version">VERSIONEN</a> | <a {if $permDel == 1}href="timeline.php?action=del&vID={$vId}" class="delete"{else}class="disabled"{/if}>LÖSCHEN</a></td>
                        </tr>
                    {/loop}
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>