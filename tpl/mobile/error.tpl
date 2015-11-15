{$page.highlight}            <div tool icon="menu">Fehler {$code}</div>

            <div class="top404">
                <div class="text404">{$code}</div>
            </div>
            <div class="text404d">
                {if $code == 403}
                    <b>Schade! :/</b><br/><br/>
                    Wegen Missbrauchs wurde diese IP gesperrt.<br/><br/>
                    Ich wars nich' :P
                {else}
                    <b>Hey! Du hast es kaputt gemacht!</b><br/><br/>
                    Jetzt m&uuml;ssen wir das wieder reparieren.<br/><br/>
                    Na toll :/
                {/if}
            </div>