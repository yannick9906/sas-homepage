{include file="newbase.tpl" args=$header}
<main>
    {if $_.perm.file_create == 1}
        <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Datei hochladen">
        <i class="large mdi mdi-upload"></i>
        </a>
    </div>
    {/if}
    <div class="container">
        <div class="row">
            <ul class="collection">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="mdi mdi-file circle indigo"></i>
                        <span class="title">{$title}</span>
                        <p>{$date} | {$author}<br/>
                            {$filename}
                        </p>
                        <span class="secondary-content">
                            {if $_.perm.file_create == 1}
                                <a> <!--href="file.php?action=edit&fID={$id}"-->
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-lighten-1">create</i>
                            </a>
                            {/if}
                            {if $_.perm.admin_file_del == 1}
                                <a href="file.php?action=del&fID={$id}">
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