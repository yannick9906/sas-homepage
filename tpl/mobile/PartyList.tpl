7            <!-- Main Content -->
            <div tool icon="menu">Wahlen</div>

            <paper-shadow z="1" class="listcard">
                <a href="#p=11&id=14"><img style="height: 64px; width: 64px; color: black;" src="img/other/chart-bar.png"/></a>
                <a href="#p=11&id=14"><h2>Wahlergebnisse Parteien</h2></a>
                <a href="#p=11&id=14"></a>
            </paper-shadow>
            <paper-shadow z="1" class="listcard">
                <a href="#p=11&id=15"><img style="height: 64px; width: 64px; color: black;" src="img/other/chart-bar.png"/></a>
                <a href="#p=11&id=15"><h2>Wahlergebnisse Monarch</h2></a>
                <a href="#p=11&id=15"></a>
            </paper-shadow>
            {foreach $page.items item}
                <paper-shadow z="1" class="listcard" style="min-height: 80px;">
                    <a href="#p=6&id={$item.id}"><img style="height: 64px; width: 64px; color: black;" src="{$item.icon}"/></a>
                    <a href="#p=6&id={$item.id}"><h2>{$item.name}</h2></a>
                    <a href="#p=6&id={$item.id}"><p>{$item.info}</p></a>
                </paper-shadow>
            {/foreach}
            {if false}
                <paper-shadow z="1" class="listcard">
                    Du m&ouml;chtest eine Partei gr&uuml;nden?<br/>
                    <a href="pdf/Parteigruendung.pdf">Hier ist das Formular</a>
                </paper-shadow>
                <paper-shadow z="2" class="listcard">
                    Hier kannst du als Direktmandat kandidieren.<br/>
                    <a href="pdf/Direktmandat.pdf">Formular</a>
                </paper-shadow>
                <paper-shadow z="3" class="listcard">
                    Oder willst du gleich als Monarch kandidieren?<br/>
                    <a href="pdf/Monarch.pdf">Dann ist hier das Formular</a>
                </paper-shadow>
            {/if}

            {include("counter.tpl")}