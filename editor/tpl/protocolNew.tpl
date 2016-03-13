{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="card-panel row">
            <br/>
            <form action="protocols.php?action=postNew" method="post" id="form">
                <div class="input-field col s12">
                    <label for="title">Name</label>
                    <input id="title" value="" required type="text" name="title" required length="65535"/>
                </div>
                <div class="input-field col s6">
                    <select id="type" title="Type" name="type">
                        <option value="" disabled selected>W&auml;hle eine Gruppe</option>
                        <option value="1">Orgateam</option>
                        <option value="2">Parlament</option>
                        <option value="3">AK Wirtschaft</option>
                        <option value="4">AK &Ouml;ffentlichkeitsarbeit</option>
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
                        <option value="" disabled selected>W&auml;hle eine Datei aus der Liste</option>
                        <optgroup label="Dateien">
                            {loop $files}
                                <option value="{$id}">{$title}</option>
                            {/loop}
                        </optgroup>
                    </select>
                    <label for="file">Datei ausw&auml;hlen</label>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {
        $('select').material_select();
    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 20, // Creates a dropdown of 15 years to control year
        // Strings and translations
        monthsFull: ['Januar', 'Februar', 'M&auml;rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        monthsShort: ['Jan', 'Feb', 'M&auml;r', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        weekdaysFull: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],

        today: 'Heute',
        clear: 'L&ouml;schen',
        close: 'X',

        labelMonthNext: 'N&auml;chster Monat',
        labelMonthPrev: 'Vorheriger Monat',
        labelMonthSelect: 'W&auml;hle einen Monat',
        labelYearSelect: 'W&auml;hle ein Jahr',

        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        hiddenPrefix: undefined,
        hiddenSuffix: '_submit',
        hiddenName: undefined,

        firstDay: 1
    });
</script>
{include file="newEnd.tpl"}