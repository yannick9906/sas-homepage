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
                        <p>{$type} | {$author}<br/>
                            Letzte &Auml;nderung: {$lastEditAuthor}, {$lastEdit} (#{$version}) <i class="mdi mdi-{$stateText} {$stateCSS}"></i>
                        </p>
                        <span class="secondary-content">
                            {if (!$state == 0 and $_.perm.site_approve == 1)}
                            <a class="waves-effect waves-circle waves-green" href="sites.php?action=approve&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons green-text text-darken-1">check</i>
                            </a>
                            <a class="waves-effect waves-circle waves-red" href="sites.php?action=deny&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons red-text text-darken-1">close</i>
                            </a>
                            {/if}
                            {if $_.perm.site_newVersionAll == 1 or ($_.perm.site_newVersionOwn and $author == $_.header.uID)}
                            <a class="waves-effect waves-circle" href="sites.php?action=edit&pID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">create</i>
                            </a>
                            {/if}
                            {if $_.perm.site_view == 1}
                            <a class="waves-effect waves-circle" href="sites.php?action=vers&pID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">history</i>
                            </a>
                            {/if}
                            {if $_.perm.admin_site_del == 1}
                            <a class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                            {/if}
                        </span>
                        <div id="modal{$id}" class="modal">
                            <div class="modal-content black-text">
                                <h4>L&ouml;schen</h4>
                                <p>M&ouml;chtest Du die Seite "{$title}" wirklich l&ouml;schen?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="sites.php?action=del&vID={$vId}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
                            </div>
                        </div>
                    </li>
                {/loop}
            </ul>
        </div>
    </div>
</main>
<script>
  $(document).ready(function(){
      // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
      $('.modal-trigger').leanModal();
  });
</script>
{include file="newEnd.tpl"}