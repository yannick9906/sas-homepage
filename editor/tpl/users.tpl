{include file="newbase.tpl" args=$header}
<main>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neuen Benutzer erstellen">
        <i class="large material-icons">add</i>
        </a>
    </div>
    <div class="container">
        <div class="row">
            <ul class="collection">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="material-icons circle {if $lvl == 5}red{elseif $lvl == 0}grey{else}orange{/if}">person</i>
                        <span class="title">{$firstname} {$lastname}</span>
                        <p>{$prefix} {$usrname}<br/>{$email}
                        </p>
                        <span class="secondary-content">
                            <a class="waves-effect waves-circle" href="users.php?action=edit&uID={$id}">
                                <i class="material-icons grey-text text-darken-1">create</i>
                            </a>
                            <a class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$id}">
                                <i class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                        </span>
                        <div id="modal{$id}" class="modal">
                            <div class="modal-content black-text">
                                <h4>L&ouml;schen</h4>
                                <p>M&ouml;chtest Du den Benutzer "{$usrname}" wirklich l&ouml;schen?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="users.php?action=del&vID={$vId}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
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