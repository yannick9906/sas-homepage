{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr><th colspan="8" class="new">{if $_.perm.sites_create == 1}<a href="?action=new">Neuer Timeline Eintrag</a>{/if}</th></tr>
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
                                <a {if !(!$state == 0 and $_.perm.sites_approve == 1)}class="disabled"{else}href="timeline.php?action=approve&vID={$vId}" class="edit"{/if}>GENEHMIGEN</a> | <a {if !(!$state == 0 and $_.perm.sites_approve == 1)}class="disabled"{else}href="timeline.php?action=deny&vID={$vId}" class="delete"{/if}>ABLEHNEN</a><br/>
                                <a {if $_.perm.sites_newVersion == 1}href="timeline.php?action=edit&tID={$id}" class="edit"{else}class="disabled"{/if}>BEARBEITEN</a> | <a {if $_.perm.sites_view == 1}href="timeline.php?action=vers&tID={$id}" class="version" {else} class="disabled"{/if}>VERSIONEN</a> | <a {if $_.perm.admin_sites_del == 1}href="timeline.php?action=del&vID={$vId}" class="delete"{else}class="disabled"{/if}>LÖSCHEN</a>
                            </td>
                        </tr>
                    {/loop}
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>