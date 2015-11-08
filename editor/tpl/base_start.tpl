<!DOCTYPE html>
<html>
<head>
    <title>ICMS - {$args.title}</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style/Editor-icms.css" type="text/css" />
    <script src="http://use.edgefonts.net/overlock:i7,i9,n7,i4,n4,n9:all.js"></script>
</head>
<body>
<div class="sidebar">
    <img src="style/icms-logo.png" class="sidebar-ICMSLogo"  alt="ICMS" />
    <div class="sidebar-menu">
        <div class="sidebar-menu-item"><a href="index.php" class="sidebar-menu-item">Home</a></div>
        <div class="sidebar-menu-item"><a href="list.php" class="sidebar-menu-item">Seiten</a></div>
        <div class="sidebar-menu-item"><a href="new.php?type=0" class="sidebar-menu-item">Neu</a></div>
        {if $args.rights == 3}<div class="sidebar-menu-item-sub"><a href="new.php?type=1" class="sidebar-menu-item-sub">Home</a></div>{/if}
        <div class="sidebar-menu-item-sub"><a href="new.php?type=2" class="sidebar-menu-item-sub">Kategorie</a></div>
        <div class="sidebar-menu-item-sub"><a href="new.php?type=4" class="sidebar-menu-item-sub"><b>Artikel</b></a></div>
        {if $args.rights == 3} <div class="sidebar-menu-item-sub"><a href="new.php?type=3" class="sidebar-menu-item-sub">Kontakt</a></div>{/if}
        {if $args.rights == 3} <div class="sidebar-menu-item-sub"><a href="new.php?type=5" class="sidebar-menu-item-sub">Termine</a></div>{/if}
        <div class="sidebar-menu-item"><a href="events.php" class="sidebar-menu-item">Termine</a></div>
        {if $args.rights == 3} <div class="sidebar-menu-item"><a href="users.php" class="sidebar-menu-item">Benutzerverwaltung</a></div>{/if}
        {if $args.rights == 3} <div class="sidebar-menu-item"><a href="FileManager.php" class="sidebar-menu-item">Dateienverwaltung</a></div>{/if}
        {if $args.rights == 3} <div class="sidebar-menu-item"><a href="downloads.php" class="sidebar-menu-item">Downloads</a></div>{/if}
    </div>
    <div class="sidebar-me">
        Willkommen, {$args.usrname}
        <a class="sidebar-me-bottom" href="editMe.php">Account</a> | <a class="sidebar-me-bottom" href="auth.php?action=logout">Logout</a>
    </div>
</div>
<div class="content-wrapper">