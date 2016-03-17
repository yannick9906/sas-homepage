/**
 * Created by Yannick on 20.04.2015.
 */

// Ziel-Datum in MEZ
var jahr=2016, monat=7, tag=11, stunde=8, minute=00, sekunde=00;
var zielDatum=new Date(jahr,monat-1,tag,stunde,minute,sekunde);

function countdown() {
    startDatum=new Date(); // Aktuelles Datum

    // Countdown berechnen und anzeigen, bis Ziel-Datum erreicht ist
    if(startDatum<zielDatum)  {

        var jahre=0, monate=0, tage=0, stunden=0, minuten=0, sekunden=0;

        // Jahre
        while(startDatum<zielDatum) {
            jahre++;
            startDatum.setFullYear(startDatum.getFullYear()+1);
        }
        startDatum.setFullYear(startDatum.getFullYear()-1);
        jahre--;

        // Monate
        while(startDatum<zielDatum) {
            monate++;
            startDatum.setMonth(startDatum.getMonth()+1);
        }
        startDatum.setMonth(startDatum.getMonth()-1);
        monate--;

        // Tage
        while(startDatum.getTime()+(24*60*60*1000)<zielDatum) {
            tage++;
            startDatum.setTime(startDatum.getTime()+(24*60*60*1000));
        }

        // Stunden
        stunden=Math.floor((zielDatum-startDatum)/(60*60*1000));
        startDatum.setTime(startDatum.getTime()+stunden*60*60*1000);

        // Minuten
        minuten=Math.floor((zielDatum-startDatum)/(60*1000));
        startDatum.setTime(startDatum.getTime()+minuten*60*1000);

        // Sekunden
        sekunden=Math.floor((zielDatum-startDatum)/1000);

        // Anzeige formatieren
        if(sekunden<10) sekunden ="0" + sekunden;
        if(minuten<10)  minuten  ="0" + minuten;
        if(stunden<10)  stunden  ="0" + stunden;
        (jahre!=1)?jahre=jahre+" Jahre,  ":jahre=jahre+" Jahr,  ";
        (monate!=1)?monate=monate+" Monate,  ":monate=monate+" Monat,  ";
        (tage!=1)?tage=tage+" Tage,  ":tage=tage+" Tag,  ";
        (stunden!=1)?stunden=stunden+":":stunden=stunden+":";
        (minuten!=1)?minuten=minuten+":":minuten=minuten+":";
        (sekunden!=1)?sekunden=sekunden+"":sekunden=sekunden+"";

        document.getElementById('countdown').innerHTML ="noch "+monate+tage+stunden+minuten+sekunden + " bis Schlopolis";

        setTimeout('countdown()',200);
    }
    // Anderenfalls alles auf Null setzen
    else document.getElementById('countdown').innerHTML = "Es ist soweit! Schlopolis 2.0 hat begonnen";

}