<!DOCTYPE html>
<html>
    <head>
        <title>ICMS&trade; - Login</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../content/style/Editor-logon.css" type="text/css" />
    </head>
    <body>
        <div class="Head">
            <img src="../content/assets/icms-logo.png" alt="Logo" />&trade;
        </div>
        <div class="Login">
            <form action="auth.php?action=login" method="POST">

                <div class="fields">
                    <input type="text" maxlength="50" placeholder="Nutzername" name="username"/><br/>
                    <input type="password" placeholder="Passwort" name="passwd" /><br/>
                    <a href="../content/page.php?pID=0">> Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Anmelden" />
                </div>
                Login:
            </form>
        </div>
        {if $inf == 1}
            <div class="Information" style="display: block;">
                Erfolgreich abgemeldet.
            </div>
        {elseif $inf == 2}
            <div class="Error" style="display: block;">
                Falsches Passwort/Falscher Benutzername
            </div>
        {elseif $inf == 3}
            <div class="Information" style="display: block;">
                ..
            </div>
        {/if}
        <div class="Copyright">
            <b>ICMS&trade;</b> Alpha 3.0 <span class="alphaver">dwoo_test</span> - Design and Software by Yannick Félix - &copy; 2014 - 2015<br/>for Mainzer Eissport Club e.V.
        </div>
    </body>
</html>