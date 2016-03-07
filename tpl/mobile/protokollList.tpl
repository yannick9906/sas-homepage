3            <!-- Main Content -->
            <div tool icon="menu">Protokolle</div>

            <paper-tabs selected="0" scrollable>
                <paper-tab>Orgateam</paper-tab>
                <paper-tab>Parlament</paper-tab>
                <paper-tab>AK Wirtschaft</paper-tab>
                <paper-tab>AK Öffentlichkeitsarbeit</paper-tab>
                <paper-tab>AK Finanzen</paper-tab>
                <paper-tab>AK Politik</paper-tab>
                <paper-tab>Sonstige</paper-tab>
            </paper-tabs>
            <core-pages selected="0">
                <div>
                    {foreach $page.items item}
                        {if $item.typeNo == 1}
                        <paper-shadow z="1" class="listcard">
                            <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                            <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                            <a href="{$item.dl}"><p>{$item.info}</p></a>
                        </paper-shadow>
                        {/if}
                    {/foreach}
                </div>
                <div>
                    {foreach $page.items item}
                        {if $item.typeNo == 2}
                        <paper-shadow z="1" class="listcard">
                            <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                            <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                            <a href="{$item.dl}"><p>{$item.info}</p></a>
                        </paper-shadow>
                        {/if}
                    {/foreach}
                </div>
                <div>
                    {foreach $page.items item}
                        {if $item.typeNo == 3}
                            <paper-shadow z="1" class="listcard">
                            <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                            <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                            <a href="{$item.dl}"><p>{$item.info}</p></a>
                        </paper-shadow>
                        {/if}
                    {/foreach}
                </div>
                <div>
                    {foreach $page.items item}
                        {if $item.typeNo == 4}
                            <paper-shadow z="1" class="listcard">
                            <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                            <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                            <a href="{$item.dl}"><p>{$item.info}</p></a>
                        </paper-shadow>
                        {/if}
                    {/foreach}
                </div>
                <div>
                    {foreach $page.items item}
                        {if $item.typeNo == 5}
                            <paper-shadow z="1" class="listcard">
                            <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                            <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                            <a href="{$item.dl}"><p>{$item.info}</p></a>
                        </paper-shadow>
                        {/if}
                    {/foreach}
                </div>
                <div>
                    {foreach $page.items item}
                        {if $item.typeNo == 6}
                            <paper-shadow z="1" class="listcard">
                            <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                            <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                            <a href="{$item.dl}"><p>{$item.info}</p></a>
                        </paper-shadow>
                        {/if}
                    {/foreach}
                </div>
                <div>
                    {foreach $page.items item}
                        {if $item.typeNo == 7}
                            <paper-shadow z="1" class="listcard">
                            <a href="{$item.dl}"><core-icon style="height: 64px; width: 64px; color: black;" icon="assignment"></core-icon></a>
                            <a href="{$item.dl}"><h2>{$item.name}</h2></a>
                            <a href="{$item.dl}"><p>{$item.info}</p></a>
                        </paper-shadow>
                        {/if}
                    {/foreach}
                </div>
            </core-pages>
	<script>
		var tabs = document.querySelector('paper-tabs');
        var pages = document.querySelector('core-pages');

        tabs.addEventListener('core-select',function(){
            pages.selected = tabs.selected;
        });

        function show() {
            var toast = document.querySelector('#toast');
            toast.show();
        }
	</script>

            {include("counter.tpl")}