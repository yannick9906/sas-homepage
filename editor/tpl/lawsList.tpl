{include file="newbase.tpl" args=$header}
<main>
    {if $_.perm.laws_create == 1}
        <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
            <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neues Gesetz erstellen">
                <i class="large mdi mdi-plus"></i>
            </a>
        </div>
    {/if}
    <div class="container">
        <div class="row">
            <form class="col s12 m8" method="post" action="" id="live-search">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">search</i>
                        <input id="filter" type="text" class="validate">
                        <label for="filter">In Gesetzen suchen ...</label>
                    </div>
                </div>
            </form>
            <div class="col s12 offset-m1 m3 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a class='dropdown-button btn indigo' href='#' data-activates='dropdown0'><i class="mdi mdi-sort"></i> {$page.sort}</a>

                <!-- Dropdown Structure -->
                <ul id='dropdown0' class='dropdown-content'>
                    <li><a href="#!">{$page.sort}</a></li>
                    <li class="divider"></li>
                    {if $page.sort != "ascName"} <li><a href="?sort=ascName"> <i class="mdi mdi-sort-ascending"> </i> Name</a></li>{/if}
                    {if $page.sort != "descName"}<li><a href="?sort=descName"><i class="mdi mdi-sort-descending"></i> Name</a></li>{/if}
                    {if $page.sort != "ascID"}   <li><a href="?sort=ascID">   <i class="mdi mdi-sort-ascending"> </i> ID</a></li>{/if}
                    {if $page.sort != "descID"}  <li><a href="?sort=descID">  <i class="mdi mdi-sort-descending"></i> ID</a></li>{/if}
                    {if $page.sort != "ascDate"} <li><a href="?sort=ascDate"> <i class="mdi mdi-sort-ascending"> </i> Datum</a></li>{/if}
                    {if $page.sort != "descDate"}<li><a href="?sort=descDate"><i class="mdi mdi-sort-descending"></i> Datum</a></li>{/if}
                </ul>
            </div>
            <ul class="collection col s12">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="circle indigo" style="font-style: normal; font-size: {if $font == "big"}12px{else}8px{/if};">{$lwNum}</i>
                        <span class="title">{$tags} {$title}</span>
                        <p>{$fileName} | {$username}<br/>
                            {$date}
                        </p>
                        <span class="secondary-content">
                            {if $_.perm.laws_edit == 1}
                                <a class="waves-effect waves-circle tooltipped" href="laws.php?action=edit&lwID={$lwID}" data-position="top" data-delay="50" data-tooltip="Bearbeiten">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">create</i>
                            </a>
                            {/if}
                            {if $_.perm.laws_view == 1}
                                <a class="waves-effect waves-circle tooltipped" target="_blank" href="{$filePath}" data-position="top" data-delay="50" data-tooltip="Gesetz ansehen (in neuem Tab)">
                                    <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">visibility</i>
                                </a>
                            {/if}
                            {if $_.perm.laws_del == 1}
                                <a class="waves-effect waves-circle waves-red modal-trigger tooltipped" href="#modal{$lwID}" data-position="top" data-delay="50" data-tooltip="Löschen">
                                    <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">delete</i>
                                </a>
                            {/if}
                            <div id="modal{$lwID}" class="modal">
                                <div class="modal-content black-text">
                                    <h4>L&ouml;schen</h4>
                                    <p>M&ouml;chtest Du das Gesetz "{$title}" wirklich l&ouml;schen? Nicht machen, wenn der Antrag abgeschlossen wurde!</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                    <a href="laws.php?action=del&lwID={$lwID}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
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