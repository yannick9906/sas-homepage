{include file="newbase.tpl" args=$header}
<main>
    {if $_.perm.news_create == 1}
        <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neuen News Eintrag erstellen">
        <i class="large mdi mdi-newspaper"></i>
        </a>
    </div>
    {/if}
    <div class="container">
        <div class="row">
            <ul class="collection">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="mdi mdi-newspaper circle indigo"></i>
                        <span class="title">#{$version} von {$lastEditAuthor}<i class="mdi mdi-{$stateText} {$stateCSS}"></i></span>
                        <p>&Auml;nderung vom: {$lastEdit}<br/>
                            {$title} - {$date}
                        </p>
                        <span class="secondary-content">
                            <a {if $negIndex != 0}class="waves-effect waves-circle" href="timeline.php?action=diff&vID={$vId}"{/if}>
                                <i style="margin: 0px 5px;" class="material-icons grey-text {if $negIndex != 0}text-darken-1{else}text-lighten-2{/if}">compare_arrows</i>
                            </a>
                            <a {if $index != 0}class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$vId}"{/if}>
                                <i style="margin: 0px 5px;" class="material-icons grey-text {if $index !=0}text-darken-1{else}text-lighten-2{/if}">replay</i>
                            </a>
                        </span>
                        <div id="modal{$id}" class="modal">
                            <div class="modal-content black-text">
                                <h4>L&ouml;schen</h4>
                                <p>M&ouml;chtest Du den News Eintrag "{$title}" wirklich l&ouml;schen?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="news.php?action=del&vID={$vId}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
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