{include file="base.tpl"}
<div class="content">
        <form action="protocols.php?action=postNew" method="post">
            <table class="edit">
                <thead>
                    <tr>
                        <th>
                            Protokoll erstellen
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="title">Name</label>
                                    <input id="title" value="" required type="text" name="title" required length="65535"/>
                                </div>
                                <div class="input-field col s6">
                                    <select id="type" title="Type" name="type">
                                        <option value="" disabled selected>Wähle eine Gruppe</option>
                                        <option value="1">Orgateam</option>
                                        <option value="2">Parlament</option>
                                        <option value="3">AK Wirtschaft</option>
                                        <option value="4">AK Öffentlichkeitsarbeit</option>
                                        <option value="5">AK Politik</option>
                                        <option value="6">AK Finanzen</option>
                                        <option value="7">Sonstige</option>
                                    </select>
                                    <label for="selInt">Gruppe</label>
                                </div>
                                <div class="input-field col s6">
                                    <input type="date" name="date" id="date" class="datepicker">
                                    <label for="date">Datum</label>
                                </div>
                                <div class="input-field col s12">
                                    <select id="file" title="Intern" name="fileID">
                                        <option value="" disabled selected>Wähle eine Datei aus der Liste</option>
                                        <optgroup label="Dateien">
                                            {loop $files}
                                                <option value="{$id}">{$title}</option>
                                            {/loop}
                                        </optgroup>
                                    </select>
                                    <label for="file">Datei auswählen</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Neues Protokoll erstellen"/></td>
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

                format: 'd. mmmm yyyy',
                formatSubmit: undefined,
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