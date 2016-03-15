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
            <form class="col s12 m7" method="post" action="" id="live-search">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">search</i>
                        <input id="filter" type="text" class="validate">
                        <label for="filter">In Protokollen suchen ...</label>
                    </div>
                </div>
            </form>
            <div class="col offset-s4 s4 offset-m1 m2 right-align">
                <br class="hide-on-small-only"/>
                            <!-- Dropdown Trigger -->
                <a class='dropdown-button btn indigo' href='#' data-activates='dropdown0'><i class="mdi mdi-sort"></i> {$page.sort}</a>

                            <!-- Dropdown Structure -->
                <ul id='dropdown0' class='dropdown-content'>
                    <li><a href="#!">{$page.sort}</a></li>
                    <li class="divider"></li>
                    {if $page.sort != "ascName"} <li><a href="?filter={$page.filter}&sort=ascName"> <i class="mdi mdi-sort-ascending"> </i> Name</a></li>{/if}
                    {if $page.sort != "descName"}<li><a href="?filter={$page.filter}&sort=descName"><i class="mdi mdi-sort-descending"></i> Name</a></li>{/if}
                    {if $page.sort != "ascID"}   <li><a href="?filter={$page.filter}&sort=ascID">   <i class="mdi mdi-sort-ascending"> </i> ID</a></li>{/if}
                    {if $page.sort != "descID"}  <li><a href="?filter={$page.filter}&sort=descID">  <i class="mdi mdi-sort-descending"></i> ID</a></li>{/if}
                    {if $page.sort != "ascDate"} <li><a href="?filter={$page.filter}&sort=ascDate"> <i class="mdi mdi-sort-ascending"> </i> Datum</a></li>{/if}
                    {if $page.sort != "descDate"}<li><a href="?filter={$page.filter}&sort=descDate"><i class="mdi mdi-sort-descending"></i> Datum</a></li>{/if}
                </ul>
            </div>
            <div class="col s4 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a class='dropdown-button btn indigo' href='#' data-activates='dropdown'><i class="mdi mdi-filter"></i> {replace $page.filter "%2B" "+"}</a>

                <!-- Dropdown Structure -->
                <ul id='dropdown' class='dropdown-content'>
                    <li><a href="#!">{replace $page.filter "%2B" "+"}</a></li>
                    <li class="divider"></li>
                    {if $page.filter != "Alle"}<li>       <a href="?sort={$page.sort}&filter=Alle"      >Alle      </a></li>{/if}
                    {if $page.filter != "Orgateam"}<li>   <a href="?sort={$page.sort}&filter=Orgateam"  >Orgateam  </a></li>{/if}
                    {if $page.filter != "Parlament"}<li>  <a href="?sort={$page.sort}&filter=Parlament" >Parlament </a></li>{/if}
                    {if $page.filter != "Wirtschaft"}<li> <a href="?sort={$page.sort}&filter=Wirtschaft">Wirtschaft</a></li>{/if}
                    {if $page.filter != "Öffentl."}<li>   <a href="?sort={$page.sort}&filter=Öffentl."  >Öffentl.  </a></li>{/if}
                    {if $page.filter != "Politik"}<li>    <a href="?sort={$page.sort}&filter=Politik"   >Politik   </a></li>{/if}
                    {if $page.filter != "Finanzen"}<li>   <a href="?sort={$page.sort}&filter=Finanzen"  >Finanzen  </a></li>{/if}
                    {if $page.filter != "Sonstige"}<li>   <a href="?sort={$page.sort}&filter=Sonstige"  >Sonstige  </a></li>{/if}
                </ul>
            </div>
            <ul class="collection col s12">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="mdi mdi-book circle indigo"></i>
                        <span class="title">{$title}</span>
                        <p>{$type} | {$date} | {$author}<br/>
                            Letzte &Auml;nderung: {$lastEditAuthor}, {$lastEdit} (#{$version}) <i class="mdi mdi-{$stateText} {$stateCSS}"></i>
                        </p>
                        <span class="secondary-content">
                            {if (!$state == 0 and $_.perm.protocols_approve == 1)}
                                <a class="waves-effect waves-circle waves-green" href="protocols.php?action=approve&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons green-text text-darken-1">check</i>
                            </a>
                                <a class="waves-effect waves-circle waves-red" href="protocols.php?action=deny&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons red-text text-darken-1">close</i>
                            </a>
                            {/if}
                            {if $_.perm.protocols_newVersion == 1}
                                <a class="waves-effect waves-circle" href="protocols.php?action=edit&prID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">create</i>
                            </a>
                            {/if}
                            {if $_.perm.protocols_view == 1}
                                <a class="waves-effect waves-circle" href="protocols.php?action=vers&prID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">history</i>
                            </a>
                            {/if}
                            {if $_.perm.admin_protocols_del == 1}
                                <a class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                            {/if}
                            <div id="modal{$id}" class="modal">
                                <div class="modal-content black-text">
                                    <h4>L&ouml;schen</h4>
                                    <p>M&ouml;chtest Du das Protokol "{$title}" wirklich l&ouml;schen?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                    <a href="protocols.php?action=del&vID={$vId}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
                                </div>
                            </div>
                        </span>
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
      $("#filter").keyup(function(){

          // Retrieve the input field text and reset the count to zero
          var filter = $(this).val(), count = 0;

          // Loop through the comment list
          $("ul.collection li").each(function(){

              // If the list item does not contain the text phrase fade it out
              if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                  $(this).fadeOut();

                  // Show the list item if the phrase matches and increase the count by 1
              } else {
                  $(this).show();
                  count++;
              }
          });

          // Update the count
          var numberItems = count;
      });
  });
</script>
{include file="newEnd.tpl"}