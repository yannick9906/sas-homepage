{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr><th colspan="8" class="new">{if $_.perm.site_create == 1}<a href="?action=new">Neue Seite</a>{/if}</th></tr>
                    <tr>
                        <th>#</th>
                        <th>Typ</th>
                        <th>Name</th>
                        <th style="min-width: 200px;">Author</th>
                        <th style="min-width: 250px;">Version</th>
                        <th>Status</th>
                        <th style="min-width: 310px;"></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <tr>
                            <td>{$id}</td>
                            <td>{$type}</td>
                            <td>{$title}</td>
                            <td>{$author}</td>
                            <td>#{$version} von {$lastEditAuthor}<br/>am {$lastEdit}</td>
                            <td class="{$stateCSS}">{$stateText}</td>
                            <td>
                                <a {if !(!$state == 0 and $_.perm.site_approve == 1)}class="disabled"{else}href="sites.php?action=approve&vID={$vId}" class="edit"{/if}>GENEHMIGEN</a> | <a {if !(!$state == 0 and $_.perm.site_approve == 1)}class="disabled"{else}href="sites.php?action=deny&vID={$vId}" class="delete"{/if}>ABLEHNEN</a><br/>
                                <a {if $_.perm.site_newVersionAll == 1 or ($_.perm.site_newVersionOwn and $author == $_.header.uID)}href="sites.php?action=edit&pID={$id}" class="edit"{else}class="disabled"{/if}>BEARBEITEN</a> | <a {if $_.perm.site_view == 1}href="sites.php?action=vers&pID={$id}" class="version" {else} class="disabled"{/if}>VERSIONEN</a> | <a {if $_.perm.admin_site_del == 1}href="sites.php?action=del&vID={$vId}" class="delete"{else}class="disabled"{/if}>LÖSCHEN</a>
                            </td>
                        </tr>
                    {/loop}
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>