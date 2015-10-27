<!-- Drawer Panel -->
<core-header-panel navigation flex>
    <core-toolbar style="background-color: #7986CB;">
        Schlopolis 2.0
    </core-toolbar>
    <core-menu selected="{$args}">
        <core-item icon="home" label="Home"><a href="index.php?p=0" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="event" label="Kalender"><a href="index.php?p=1" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="av:news" label="News"><a href="index.php?p=2" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="social:group" label="Arbeitskreise"><a href="index.php?p=3" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="social:people-outline" label="Parteien"><a href="index.php?p=5" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="announcement" label="Fragen"><a href="index.php?p=7" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="payment" label="SchlopoPay"><a href="bank/newbill.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="more-horiz" label="Impressum"><a href="index.php?p=9" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
        <core-item icon="account-circle" label="Login"><a href="user/login.php" target="_self"><paper-ripple fit></paper-ripple></a></core-item>
    </core-menu>
</core-header-panel>