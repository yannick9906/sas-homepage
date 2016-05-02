{include file="newbase.tpl" args=$header}
<main>
    {if $_.perm.application_create == 1}
        <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
            <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neuen Antrag erstellen">
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
                        <label for="filter">In Anträgen suchen ...</label>
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
                    {if $page.filter != "Alle"}<li>       <a href="?sort={$page.sort}&filter=Alle"      >Alle       </a></li>{/if}
                    {if $page.filter != "Offen"}<li>      <a href="?sort={$page.sort}&filter=Offen"     >Offen      </a></li>{/if}
                    {if $page.filter != "Angenommen"}<li> <a href="?sort={$page.sort}&filter=Angenommen">Angenommen </a></li>{/if}
                    {if $page.filter != "Abgelehnt"}<li>  <a href="?sort={$page.sort}&filter=Abgelehnt" >Abgelehnt  </a></li>{/if}
                </ul>
            </div>
            <ul class="collection col s12">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="circle indigo" style="font-style: normal; font-size: {if $font == "big"}12px{else}8px{/if};">{$aNum}</i>
                        <span class="title">{$tags} {$title}</span>
                        <p>{$fileName} | {$username}<br/>
                            {$date} |  Antragsteller: {$name}<span class="bg badge {$stateColor}">{$stateText}</span>
                        </p>
                        <span class="secondary-content">
                            {if $_.perm.application_edit == 1}
                                {if $state == 0}
                                    <a class="waves-effect waves-circle waves-green tooltipped" href="applications.php?action=accept&aID={$aID}" data-position="top" data-delay="50" data-tooltip="Annehmen">
                                        <i style="margin: 0px 5px;" class="material-icons green-text text-darken-1">check</i>
                                    </a>
                                    <a class="waves-effect waves-circle waves-red tooltipped" href="applications.php?action=deny&aID={$aID}" data-position="top" data-delay="50" data-tooltip="Ablehnen">
                                        <i style="margin: 0px 5px;" class="material-icons red-text text-darken-1">close</i>
                                    </a>
                                {else}
                                    <a class="waves-effect waves-circle waves-green tooltipped" href="applications.php?action=reopen&aID={$aID}" data-position="top" data-delay="50" data-tooltip="Wiederaufnehmen">
                                        <i style="margin: 0px 5px;" class="material-icons green-text text-darken-1">lock_open</i>
                                    </a>
                                {/if}
                                <a class="waves-effect waves-circle tooltipped" href="applications.php?action=edit&aID={$aID}" data-position="top" data-delay="50" data-tooltip="Bearbeiten">
                                    <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">create</i>
                                </a>
                            {/if}
                            {if $_.perm.application_view == 1}
                                <a class="waves-effect waves-circle tooltipped" target="_blank" href="{$filePath}" data-position="top" data-delay="50" data-tooltip="Antrag ansehen (in neuem Tab)">
                                    <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">visibility</i>
                                </a>
                            {/if}
                            {if $_.perm.application_del == 1}
                                <a class="waves-effect waves-circle waves-red modal-trigger tooltipped" href="#modal{$aID}" data-position="top" data-delay="50" data-tooltip="Löschen">
                                    <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">delete</i>
                                </a>
                            {/if}
                            <div id="modal{$aID}" class="modal">
                                <div class="modal-content black-text">
                                    <h4>L&ouml;schen</h4>
                                    <p>M&ouml;chtest Du den Antrag "{$title}" wirklich l&ouml;schen? Nicht machen, wenn der Antrag abgeschlossen wurde!</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                    <a href="applications.php?action=del&aID={$aID}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
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