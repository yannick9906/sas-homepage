{include file="newbase.tpl" args=$header}
<main>
    {if $_.perm.protocols_create == 1}
        <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neues Protokol erstellen">
        <i class="large mdi mdi-plus"></i>
        </a>
    </div>
    {/if}
    <div class="container">
        <div class="row">
            <ul class="collection">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="mdi mdi-book circle indigo"></i>
                        <span class="title">{$title}</span>
                        <p>{$type} | {$date} | {$author}<br/>
                            Letzte &Auml;nderung: {$lastEditAuthor}, {$lastEdit} (#{$version}) <i class="mdi mdi-{$stateText} {$stateCSS}"></i>
                        </p>
                        <span class="secondary-content">
                            {if (!$state == 0 and $_.perm.protocols_approve == 1)}
                                <a href="news.php?action=approve&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons green-text text-darken-1">check</i>
                            </a>
                                <a href="news.php?action=deny&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons red-text text-darken-1">close</i>
                            </a>
                            {/if}
                            {if $_.perm.protocols_newVersion == 1}
                                <a href="news.php?action=edit&prID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">create</i>
                            </a>
                            {/if}
                            {if $_.perm.protocols_view == 1}
                                <a href="news.php?action=vers&prID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">history</i>
                            </a>
                            {/if}
                            {if $_.perm.admin_protocols_del == 1}
                                <a href="news.php?action=del&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                            {/if}
                        </span>
                    </li>
                {/loop}
            </ul>
        </div>
    </div>
</main>
{include file="newEnd.tpl"}