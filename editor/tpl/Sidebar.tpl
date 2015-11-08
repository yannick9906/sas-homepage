<div class="sidebar">
    <img src="../content/assets/icms-logo.png" class="sidebar-ICMSLogo"  alt="ICMS" />
    <div class="sidebar-menu">
        <div class="sidebar-menu-item-s"><a href="index.php" class="sidebar-menu-item-s">Home</a></div>
        <div class="sidebar-menu-item"><a href="search.php" class="sidebar-menu-item">Seiten</a></div>
        <div class="sidebar-menu-item"><a href="new.php?type=0" class="sidebar-menu-item">Neu</a></div>
        {if $rights == 3}<div class="sidebar-menu-item-sub"><a href="new.php?type=1" class="sidebar-menu-item-sub">Home</a></div>{/if}
        <div class="sidebar-menu-item-sub"><a href="new.php?type=2" class="sidebar-menu-item-sub">Kategorie</a></div>
        <div class="sidebar-menu-item-sub"><a href="new.php?type=4" class="sidebar-menu-item-sub"><b>Artikel</b></a></div>
        {if $rights == 3} <div class="sidebar-menu-item-sub"><a href="new.php?type=3" class="sidebar-menu-item-sub">Kontakt</a></div>{/if}
        {if $rights == 3} <div class="sidebar-menu-item-sub"><a href="new.php?type=5" class="sidebar-menu-item-sub">Termine</a></div>{/if}
        <div class="sidebar-menu-item"><a href="events.php" class="sidebar-menu-item">Termine</a></div>
        {if $rights == 3} <div class="sidebar-menu-item"><a href="users.php" class="sidebar-menu-item">Benutzerverwaltung</a></div>{/if}
        {if $rights == 3} <div class="sidebar-menu-item"><a href="FileManager.php" class="sidebar-menu-item">Dateienverwaltung</a></div>{/if}
        {if $rights == 3} <div class="sidebar-menu-item"><a href="downloads.php" class="sidebar-menu-item">Downloads</a></div>{/if}
    </div>
    <div class="sidebar-me">
        Willkommen, {$usrname}
        <a class="sidebar-me-bottom" href="editMe.php">Account</a> | <a class="sidebar-me-bottom" href="auth.php?action=logout">Logout</a>
    </div>
</div>