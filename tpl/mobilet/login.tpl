9           <!-- Main Content -->
            <div tool icon="menu">Login</div>

            <form action="?action=1" method="post">
                <paper-shadow z="2" class="card">
                    Dieser Login ist f&uuml;r den Administrator, Aks und Parteien.<br/>
                    {$page.err}
                    <paper-input-decorator floatingLabel flex label="Benutzername"><input type="text" name="usrname" title="username"/></paper-input-decorator>
                    <paper-input-decorator floatingLabel flex label="Passwort"><input type="password" name="passwd" title="password"/></paper-input-decorator>
                    <paper-button raised flex onclick="document.getElementById('submit').click();">Login</paper-button>
                </paper-shadow>
                <input type="submit" id="submit" style="display: none;"/>
            </form>

            {include("counter.tpl")}