{include file="newbase.tpl" args=$header}
<main>
            <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
                <a class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neue Seite erstellen">
                <i class="large material-icons">add</i>
                </a>
                <ul>
                    <li><a href="?action=new&type=1" class="btn-floating indigo tooltipped"  data-position="left" data-delay="10" data-tooltip="Neue normale Seite erstellen"><i class="material-icons">insert_drive_file</i></a></li>
                    <li><a href="?action=new&type=2" class="btn-floating indigo tooltipped"  data-position="left" data-delay="10" data-tooltip="Neue AK Seite erstellen">     <i class="material-icons">group</i></a></li>
                    <li><a href="?action=new&type=3" class="btn-floating indigo tooltipped"  data-position="left" data-delay="10" data-tooltip="Neue Partei Seite erstellen"> <i class="material-icons">people_outline</i></a></li>
                </ul>
            </div>
            <div class="container">
                <div class="row">
                    <ul class="collection">
                        {loop $page.items}
                            <li class="collection-item avatar">
                                <i class="material-icons circle indigo">{if $type == "Normal"}insert_drive_file{elseif $type == "AK"}group{elseif $type == "Partei"}people_outline{/if}</i>
                                <span class="title">{$title}</span>
                                <p>{$author} | {$email}<br/>
                                    Letzte &Auml;nderung: {$lastEditAuthor}, {$lastEdit} (#{$version}) <i class="material-icons {$stateCSS}">{$stateText}</i>
                                </p>
                                <span class="secondary-content">
                                    {if (!$state == 0 and $_.perm.site_approve == 1)}
                                    <a href="sites.php?action=approve&vID={$id}">
                                        <i style="margin: 0px 5px;" class="material-icons green-text text-darken-1">check</i>
                                    </a>
                                    <a href="sites.php?action=deny&vID={$id}">
                                        <i style="margin: 0px 5px;" class="material-icons red-text text-darken-1">close</i>
                                    </a>
                                    {/if}
                                    {if $_.perm.site_newVersionAll == 1 or ($_.perm.site_newVersionOwn and $author == $_.header.uID)}
                                    <a href="sites.php?action=edit&pID={$id}">
                                        <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">create</i>
                                    </a>
                                    {/if}
                                    {if $_.perm.site_view == 1}
                                    <a href="sites.php?action=vers&pID={$id}">
                                        <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">history</i>
                                    </a>
                                    {/if}
                                    {if $_.perm.admin_site_del == 1}
                                    <a href="sites.php?action=del&vID={$id}">
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