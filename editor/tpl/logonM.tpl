<!DOCTYPE html>
<html>
    <head>
        <title>ICMS SAS - Login</title>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../libs/materialize/css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="../css/style.css" />
        <link type="text/css" rel="stylesheet" href="../libs/mdi/css/materialdesignicons.min.css" media="all"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="manifest" href="manifest.json" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="theme-color" content="#3F51B5" />
    </head>
    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="../libs/materialize/js/materialize.min.js"></script>
        <script type="text/javascript" src="../libs/markdown.min.js"></script>

        <!-- Dropdown Structure -->
        <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper indigo">
                <a href="#!" class="brand-logo hide-on-med-and-down" style="padding-left: 250px;"><b>IC</b>MS - Login</a>
                <a href="#!" class="brand-logo hide-on-large-only" style=""><b>IC</b>MS - Login</a>
                <ul class="right"></ul>
            </div>
        </nav>
        </div>
        <main>
            <div class="container">
                <div class="card-panel row">
                    <br/>
                    <form action="logon.php" method="post">
                        <div class="input-field col s12">
                            <label for="usrname">Benutzername</label>
                            <input id="usrname" required type="text" name="usrname" length="255"/>
                            <span class="red-text">{if $err==1}Benutzername existiert nicht.{/if}{if $ses == 1}Keine gültige Session.{/if}</span>
                        </div>
                        <div class="input-field col s12">
                            <label for="password">Passwort</label>
                            <input id="password" required type="password" name="password" length="255"/>
                            <span class="red-text">{if $err==2}Passwort falsch{/if}</span>
                        </div>
                        <button class="btn waves-effect waves-light indigo col s12" type="submit" name="action">Login
                            <i class="material-icons right">send</i>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    <script>
    </script>
    <script>
        $(document).ready(function() {
            $(".dropdown-button").dropdown();

            // Initialize collapse button
            $(".button-collapse").sideNav();
            // Initialize collapsible (uncomment the line below if you use the dropdown variation)
            $('.collapsible').collapsible();
        });
    </script>
</body>
</html>