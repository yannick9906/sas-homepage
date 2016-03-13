{include file="newbase.tpl" args=$header}
<main>
    {if $_.perm.site_create == 1}
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
    {/if}
    <div class="container">
        <div class="row">
            <ul class="collection">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="material-icons circle indigo">{if $type == "Normal"}insert_drive_file{elseif $type == "AK"}group{elseif $type == "Partei"}people_outline{/if}</i>
                        <span class="title">#{$version} von {$lastEditAuthor} <i class="mdi mdi-{$stateText} {$stateCSS}"></i></span>
                        <p>&Auml;nderung vom: {$lastEdit}<br/>
                            {$title}
                        </p>
                        <span class="secondary-content">
                            <a {if $negIndex != 0}class="waves-effect waves-circle" href="sites.php?action=diff&vID={$vId}"{/if}>
                                <i style="margin: 0px 5px;" class="material-icons grey-text {if $negIndex != 0}text-darken-1{else}text-lighten-2{/if}">compare_arrows</i>
                            </a>
                            <a {if $index != 0}class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$vId}"{/if}>
                                <i style="margin: 0px 5px;" class="material-icons grey-text {if $index !=0}text-darken-1{else}text-lighten-2{/if}">replay</i>
                            </a>
                        </span>
                        <div id="modal{$vId}" class="modal">
                            <div class="modal-content black-text">
                                <h4>Wiederherstellen</h4>
                                <p>M&ouml;chtest Du die Seite "{$title}" wirklich auf Version #{$version} zur&uuml;cksetzten?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="sites.php?action=jumpTo&vID={$vId}" class="modal-action modal-close waves-effect waves-green btn-flat blue-text">Zur&uuml;cksetzten</a>
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