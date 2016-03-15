{include file="newbase.tpl" args=$header}
<main>
    {if $_.perm.timeline_create == 1}
        <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neuen Timeline erstellen">
        <i class="large mdi mdi-calendar-plus"></i>
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
                        <label for="filter">In Timeline suchen ...</label>
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
                    {if $page.filter != "Alle"}<li>  <a href="?sort={$page.sort}&filter=Alle">Alle</a></li>{/if}
                    {if $page.filter != "%2B30T"}<li> <a href="?sort={$page.sort}&filter=%2B30T">+30T</a></li>{/if}
                    {if $page.filter != "Neue"}<li><a href="?sort={$page.sort}&filter=Neue">Neue</a></li>{/if}
                </ul>
            </div>
            <ul class="collection col s12">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="mdi mdi-calendar-text circle indigo"></i>
                        <span class="title">{$title}</span>
                        <p>{$date} | {$author}<br/>
                            Letzte &Auml;nderung: {$lastEditAuthor}, {$lastEdit} (#{$version}) <i class="mdi mdi-{$stateText} {$stateCSS}"></i>
                        </p>
                        <span class="secondary-content">
                            {if (!$state == 0 and $_.perm.timeline_approve == 1)}
                                <a class="waves-effect waves-circle waves-green" href="timeline.php?action=approve&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons green-text text-darken-1">check</i>
                            </a>
                                <a class="waves-effect waves-circle waves-red" href="news.php?action=deny&vID={$vId}">
                                <i style="margin: 0px 5px;" class="material-icons red-text text-darken-1">close</i>
                            </a>
                            {/if}
                            {if $_.perm.timeline_newVersion == 1}
                                <a class="waves-effect waves-circle" href="timeline.php?action=edit&tID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">create</i>
                            </a>
                            {/if}
                            {if $_.perm.timeline_view == 1}
                                <a class="waves-effect waves-circle" href="timeline.php?action=vers&tID={$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">history</i>
                            </a>
                            {/if}
                            {if $_.perm.admin_timeline_del == 1}
                                <a class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$id}">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                            {/if}
                        </span>
                        <div id="modal{$id}" class="modal">
                            <div class="modal-content black-text">
                                <h4>L&ouml;schen</h4>
                                <p>M&ouml;chtest Du den Timeline Eintrag "{$title}" wirklich l&ouml;schen?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="timeline.php?action=del&vID={$vId}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
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

  $('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: false, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true, // Displays dropdown below the button
      alignment: 'right' // Displays dropdown with edge aligned to the left of button
  });

</script>
{include file="newEnd.tpl"}