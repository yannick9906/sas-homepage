6            <div tool icon="menu">Vorstellung der Arbeitskreise</div>

            {foreach $page.items item}
                <paper-shadow z="1" class="listcard" style="min-height: 80px;">
                    <a href="#p=4&id={$item.id}"><core-icon style="height: 64px; width: 64px; color: black;" icon="{$item.icon}"></core-icon></a>
                    <a href="#p=4&id={$item.id}"><h2>{$item.name}</h2></a>
                    <a href="#p=4&id={$item.id}"><p>{$item.info}</p></a>
                </paper-shadow>
            {/foreach}


            {include("counter.tpl")}