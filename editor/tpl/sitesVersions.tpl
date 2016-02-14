{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr><th class="new"><a href="sites.php"><-</a></th><th class="new" colspan="7"></th></tr>
                    <tr>
                        <th style="width: 30px; max-width: 30px;">#</th>
                        <th style="width: 90%; max-width: 90%;"></th>
                        <th style="width: 110px; max-width: 110px;"></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <!--<tr>
                            <td>{$version}</td>
                            <td>{$title}</td>
                            <td>{$lastEditAuthor}</td>
                            <td>{$lastEdit}</td>
                            <td class="{$stateCSS}">{$stateText}</td>
                            <td><a {if $index == 0}class="disabled"{else}href="sites.php?action=jumpTo&vID={$vId}" class="version"{/if}>ZURÜCKSPRINGEN</a> | <a {if $negIndex == 0}class="disabled"{else}href="sites.php?action=versDetail&vID={$vId}" class="edit"{/if}>DETAILS</a></td>
                        </tr>-->
                        <tr>
                            <td>{$version}</td>
                            <td>
                                <div class="list-name">{$title}</div>
                                <div class="list-type">von {$lastEditAuthor}, {$lastEdit} <span class="{$stateCSS}"><i class="mdi mdi-{$stateText}"></i></span></div>
                            </td>
                            <td style="">
                                <a {if $index == 0}class="disabled"{else}href="sites.php?action=jumpTo&vID={$vId}" class="normal"{/if}><i class="mdi mdi-backup-restore"></i></a><a {if $negIndex == 0}class="disabled"{else}href="sites.php?action=versDetail&vID={$vId}" class="normal"{/if}><i class="mdi mdi-information-outline"></i></a></td>
                            </td>
                        </tr>
                    {/loop}
            </table>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>