{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <br/>
            <div class="card-panel row col s12">
                <form method="post" action="users.php?action=postEdit&field=all&uID={$edit.id}">
                    <div class="input-field col s6">
                        <label for="firstname">Vorname</label>
                        <input id="firstname" {if $header.uID == $edit.id}disabled{else}required{/if} value="{$edit.firstname}" type="text" name="firstname" length="255"/>
                    </div>
                    <div class="input-field col s6">
                        <label for="lastname">Nachname</label>
                        <input id="lastname" {if $header.uID == $edit.id}disabled{else}required{/if} value="{$edit.lastname}" type="text" name="lastname" length="255"/>
                    </div>
                    <div class="input-field col s6">
                        <label for="usrname">Benutzername</label>
                        <input id="usrname" {if $header.uID == $edit.id}disabled{else}required{/if} value="{$edit.usrname}" type="text" name="usrname" length="255"/>
                    </div>
                    <div class="input-field col s6">
                        <select id="type" title="Type" name="lvl">
                            <option value="" disabled selected>Wähle einen Level</option>
                            <option {if $edit.lvl == 0}selected{/if} {if $header.level < 0}disabled{/if} value="0">User</option>
                            <option {if $edit.lvl == 1}selected{/if} {if $header.level < 1}disabled{/if} value="1">Partei</option>
                            <option {if $edit.lvl == 2}selected{/if} {if $header.level < 2}disabled{/if} value="2">AK</option>
                            <option {if $edit.lvl == 3}selected{/if} {if $header.level < 3}disabled{/if} value="3">Orga</option>
                            <option {if $edit.lvl == 4}selected{/if} {if $header.level < 4}disabled{/if} value="4">Lehrer</option>
                            <option {if $edit.lvl == 5}selected{/if} {if $header.level < 5}disabled{/if} value="5">Admin</option>
                        </select>
                        <label for="selInt">Level</label>
                    </div>
                    <div class="input-field col s12">
                        <label for="email">Email</label>
                        <input id="email" required value="{$edit.email}" type="email" name="email" length="65535"/>
                    </div>
                    <div class="col s12">
                        <button class="btn waves-effect waves-light btn-flat" type="submit" name="action">SETZTEN
                            <i class="material-icons left">done</i>
                        </button>
                    </div>
                </form>
                <br/>
            </div>
            <div class="card-panel row col s12">
                <form method="post" action="users.php?action=postEdit&field=passwd&uID={$edit.id}">
                    <div class="input-field col s6">
                        <label for="pw1">Passwort</label>
                        <input id="pw1" type="password" name="passwd" length="18446744073709551615"/>
                    </div>
                    <div class="input-field col s6">
                        <label for="pw2">Passwort wiederholen</label>
                        <input id="pw2" type="password" name="passwd2" length="18446744073709551615"/>
                    </div>
                    <div class="col s12">
                        <button class="btn waves-effect waves-light btn-flat" type="submit" name="action">SETZTEN
                            <i class="material-icons left">done</i>
                        </button>
                    </div>
                </form>
                <br/>
            </div>

            <div class="card-panel row col s12">
                <form action="users.php?action=updatePerms&uID={$edit.id}" method="post">
                    <table>
                        <tr><th>Rechte</th><th>{if $permU.users_perms == 1}
                            <button class="btn waves-effect waves-light btn-flat" type="submit" name="action">SETZTEN
                                <i class="material-icons left">done</i>
                            </button>{/if}
                        </th></tr>
                        <tr><td><b>Benutzer</b></td></tr>
                        <tr><td>Benutzer ansehen           </td><td><div class="switch"><label>Off<input type="checkbox" id="cb00" {if $perm.users_view   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh00" type="hidden" value="0" name="users.view"/>  </td></tr>
                        <tr><td>Benutzer erstellen         </td><td><div class="switch"><label>Off<input type="checkbox" id="cb01" {if $perm.users_create == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh01" type="hidden" value="0" name="users.create"/></td></tr>
                        <tr><td>Benutzer bearbeiten        </td><td><div class="switch"><label>Off<input type="checkbox" id="cb02" {if $perm.users_edit   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh02" type="hidden" value="0" name="users.edit"/>  </td></tr>
                        <tr><td>Benutzerrechte &auml;ndern </td><td><div class="switch"><label>Off<input type="checkbox" id="cb03" {if $perm.users_perms  == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh03" type="hidden" value="0" name="users.perms"/> </td></tr>
                        <tr><td>Benutzer l&ouml;schen      </td><td><div class="switch"><label>Off<input type="checkbox" id="cb04" {if $perm.users_del    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh04" type="hidden" value="0" name="users.del"/>   </td></tr>

                        <tr><td><b>Timeline</b></td></tr>
                        <tr><td>Timeline ansehen</td>     <td><div class="switch"><label>Off<input type="checkbox" id="cb05" {if $perm.timeline_view       == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh05" type="hidden" value="0" name="timeline.view"/>      </td></tr>
                        <tr><td>Timeline erstellen</td>   <td><div class="switch"><label>Off<input type="checkbox" id="cb06" {if $perm.timeline_create     == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh06" type="hidden" value="0" name="timeline.create"/>    </td></tr>
                        <tr><td>Timeline neue Version</td><td><div class="switch"><label>Off<input type="checkbox" id="cb07" {if $perm.timeline_newVersion == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh07" type="hidden" value="0" name="timeline.newVersion"/></td></tr>
                        <tr><td>Timeline akzeptieren</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb08" {if $perm.timeline_approve    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh08" type="hidden" value="0" name="timeline.approve"/>   </td></tr>
                        <tr><td>Timeline l&ouml;schen</td><td><div class="switch"><label>Off<input type="checkbox" id="cb09" {if $perm.admin_timeline_del  == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh09" type="hidden" value="0" name="admin.timeline.del"/> </td></tr>

                        <tr><td><b>Seiten</b></td></tr>
                        <tr><td>Seite ansehen</td>                  <td><div class="switch"><label>Off<input type="checkbox" id="cb10" {if $perm.site_view          == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh10" type="hidden" value="0" name="site.view"/>         </td></tr>
                        <tr><td>Seite erstellen</td>                <td><div class="switch"><label>Off<input type="checkbox" id="cb11" {if $perm.site_create        == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh11" type="hidden" value="0" name="site.create"/>       </td></tr>
                        <tr><td>Seite neue Version(Nur Eigene)</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb12" {if $perm.site_newVersionOwn == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh12" type="hidden" value="0" name="site.newVersionOwn"/></td></tr>
                        <tr><td>Seite neue Version(Alle)</td>       <td><div class="switch"><label>Off<input type="checkbox" id="cb13" {if $perm.site_newVersionAll == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh13" type="hidden" value="0" name="site.newVersionAll"/></td></tr>
                        <tr><td>Seite akzeptieren</td>              <td><div class="switch"><label>Off<input type="checkbox" id="cb14" {if $perm.site_approve       == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh14" type="hidden" value="0" name="site.approve"/>      </td></tr>
                        <tr><td>Seite l&ouml;schen</td>             <td><div class="switch"><label>Off<input type="checkbox" id="cb15" {if $perm.admin_site_del     == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh15" type="hidden" value="0" name="admin.site.del"/>    </td></tr>
                        <tr><td>Seite bearbeiten</td>               <td><div class="switch"><label>Off<input type="checkbox" id="cb16" {if $perm.admin_site_edit    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh16" type="hidden" value="0" name="admin.site.edit"/>   </td></tr>

                        <tr><td><b>News</b></td></tr>
                        <tr><td>News ansehen</td>      <td><div class="switch"><label>Off<input type="checkbox" id="cb17" {if $perm.news_view       == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh17" type="hidden" value="0" name="news.view"/>      </td></tr>
                        <tr><td>News erstellen</td>    <td><div class="switch"><label>Off<input type="checkbox" id="cb18" {if $perm.news_create     == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh18" type="hidden" value="0" name="news.create"/>    </td></tr>
                        <tr><td>News neue Version</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb19" {if $perm.news_newVersion == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh19" type="hidden" value="0" name="news.newVersion"/></td></tr>
                        <tr><td>News akzeptieren</td>  <td><div class="switch"><label>Off<input type="checkbox" id="cb20" {if $perm.news_approve    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh20" type="hidden" value="0" name="news.approve"/>   </td></tr>
                        <tr><td>News l&ouml;schen</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb21" {if $perm.admin_news_del  == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh21" type="hidden" value="0" name="admin.news.del"/> </td></tr>
                        <tr><td>News bearbeiten</td>   <td><div class="switch"><label>Off<input type="checkbox" id="cb22" {if $perm.admin_news_edit == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh22" type="hidden" value="0" name="admin.news.edit"/></td></tr>

                        <tr><td><b>Dateien</b></td></tr>
                        <tr><td>Datei ansehen</td>     <td><div class="switch"><label>Off<input type="checkbox" id="cb23" {if $perm.file_view       == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh23" type="hidden" value="0" name="file.view"/>      </td></tr>
                        <tr><td>Datei erstellen</td>   <td><div class="switch"><label>Off<input type="checkbox" id="cb24" {if $perm.file_create     == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh24" type="hidden" value="0" name="file.create"/>    </td></tr>
                        <tr><td>Datei l&ouml;schen</td><td><div class="switch"><label>Off<input type="checkbox" id="cb25" {if $perm.admin_file_del  == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh25" type="hidden" value="0" name="admin.file.del"/> </td></tr>
                        <tr><td>Datei bearbeiten</td>  <td><div class="switch"><label>Off<input type="checkbox" id="cb26" {if $perm.admin_file_edit == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh26" type="hidden" value="0" name="admin.file.edit"/></td></tr>

                        <tr><td><b>Protokolle</b></td></tr>
                        <tr><td>Protokolle ansehen</td>      <td><div class="switch"><label>Off<input type="checkbox" id="cb27" {if $perm.protocols_view       == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh27" type="hidden" value="0" name="protocols.view"/>      </td></tr>
                        <tr><td>Protokolle erstellen</td>    <td><div class="switch"><label>Off<input type="checkbox" id="cb28" {if $perm.protocols_create     == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh28" type="hidden" value="0" name="protocols.create"/>    </td></tr>
                        <tr><td>Protokolle neue Version</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb29" {if $perm.protocols_newVersion == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh29" type="hidden" value="0" name="protocols.newVersion"/></td></tr>
                        <tr><td>Protokolle akzeptieren</td>  <td><div class="switch"><label>Off<input type="checkbox" id="cb30" {if $perm.protocols_approve    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh30" type="hidden" value="0" name="protocols.approve"/>   </td></tr>
                        <tr><td>Protokolle l&ouml;schen</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb31" {if $perm.admin_protocols_del  == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh31" type="hidden" value="0" name="admin.protocols.del"/> </td></tr>
                        <tr><td>Protokolle bearbeiten</td>   <td><div class="switch"><label>Off<input type="checkbox" id="cb32" {if $perm.admin_protocols_edit == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh32" type="hidden" value="0" name="admin.protocols.edit"/></td></tr>

                        <tr><td><b>Sonstige</b></td></tr>
                        <tr><td>Datenbank</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb33" {if $perm.admin_database == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh33" type="hidden" value="0" name="admin.database"/></td></tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {
        $('select').material_select();
        checkBoxes();
    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 20, // Creates a dropdown of 15 years to control year
        // Strings and translations
        monthsFull: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        weekdaysFull: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],

        today: 'Heute',
        clear: 'Löschen',
        close: 'Schließen',

        labelMonthNext: 'Nächster Monat',
        labelMonthPrev: 'Vorheriger Monat',
        labelMonthSelect: 'Wähle einen Monat',
        labelYearSelect: 'Wähle ein Jahr',

        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        hiddenPrefix: undefined,
        hiddenSuffix: '_submit',
        hiddenName: undefined,

        firstDay: 1
    });

    function checkBoxes() {
        $("input[type=checkbox]").each(function(){
            if(this.checked) checked = 1;
            else checked = 0;
            console.log(this.id);

            str = this.id;
            id = str.replace("cb", "hh");
            document.getElementById(id).value = checked;
        });

        window.setTimeout("checkBoxes()", 50)
    }
</script>
{include file="newEnd.tpl"}