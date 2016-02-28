{include file="base.tpl"}
<div class="content">
        <form action="protocols.php?action=postEdit&prID={$edit.id}" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th>
                            Protokoll bearbeiten
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="title">Name</label>
                                    <input id="title" value="{$edit.title}" required type="text" name="title" required length="65535"/>
                                </div>
                                <div class="input-field col s6">
                                    <select id="type" title="Type" name="type">
                                        <option value="" disabled selected>Wähle eine Gruppe</option>
                                        <option{if $edit.typeNo == 1} selected{/if} value="1">Orgateam</option>
                                        <option{if $edit.typeNo == 2} selected{/if} value="2">Parlament</option>
                                        <option{if $edit.typeNo == 3} selected{/if} value="3">AK Wirtschaft</option>
                                        <option{if $edit.typeNo == 4} selected{/if} value="4">AK Öffentlichkeitsarbeit</option>
                                        <option{if $edit.typeNo == 5} selected{/if} value="5">AK Politik</option>
                                        <option{if $edit.typeNo == 6} selected{/if} value="6">AK Finanzen</option>
                                        <option{if $edit.typeNo == 7} selected{/if} value="7">Sonstige</option>
                                    </select>
                                    <label for="selInt">Gruppe</label>
                                </div>
                                <div class="input-field col s6">
                                    <input type="date" value="{$edit.date}" name="date" id="date" class="datepicker">
                                    <label for="date">Datum</label>
                                </div>
                                <div class="input-field col s12">
                                    <select id="file" title="Intern" name="fileID">
                                        <option value="" disabled selected>Wähle eine Datei aus der Liste</option>
                                        <optgroup label="Dateien">
                                            {loop $files}
                                                <option {if $id == $_.edit.fileID}selected{/if} value="{$id}">{$title}</option>
                                            {/loop}
                                        </optgroup>
                                    </select>
                                    <label for="file">Datei auswählen</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Neue Version erstellen"/></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <script>
            jQuery(document).ready(function($) {
                $('select').material_select();
            });

            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 15, // Creates a dropdown of 15 years to control year
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

                format: 'yyyy-m-d',
                formatSubmit: 'yyyy-m-d',
                hiddenPrefix: undefined,
                hiddenSuffix: '_submit',
                hiddenName: undefined,

                firstDay: 1
            });
        </script>

</div>
{include file="header.tpl" args=$header}
</body>
</html>