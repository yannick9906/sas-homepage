3            <!-- Main Content -->
            <div tool icon="menu">Protokolle</div>

            {foreach $page.items item}
                <paper-shadow z="1" class="listcard">
                    <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                    <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                    <a href="{$item.dl}"><p>{$item.info}</p></a>
                </paper-shadow>
            {/foreach}


            {include("counter.tpl")}