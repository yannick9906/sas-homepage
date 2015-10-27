<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=5)}

            <div tool icon="menu">Fragen</div>

            <paper-tabs selected="0">
		<paper-tab>Häufige Fragen (FAQ)</paper-tab>
		<paper-tab>Neue Frage</paper-tab>
	</paper-tabs>
	<core-pages selected="0">
		<div>
			<paper-shadow z="4" class="card">
				<core-icon style="height: 64px; width: 64px;" icon="warning"></core-icon>
				<h2 style="font-size: 20px;">Diese Seite ist noch in Arbeit</h2>
				<p>:/ Versuche es später erneut</p>
			</paper-shadow>
		</div>
		<div>
			<form action="" method="post">
				<paper-shadow class="card" z="1">
						<paper-input-decorator floatingLabel flex label="Emailadresse" error="Muss eine Emailadresse sein" autoValidate><input type="email" name="email"/></paper-input-decorator>
						<paper-input-decorator floatingLabel flex label="Betreff"><input type="text" name="subject" /></paper-input-decorator>
						<paper-input-decorator floatingLabel flex label="Nachricht"><paper-autogrow-textarea><textarea id="i1" name="text" maxlength="10000"></textarea></paper-autogrow-textarea><paper-char-counter class="counter" target="i1"></paper-char-counter></paper-input-decorator>
				</paper-shadow>
				<paper-button raised flex style="top: 20px; position: relative; width: 95%; left: 5px;" onclick="document.getElementById('submit').click();">Einschicken</paper-button>
				<input type="submit" id="submit" style="display: none;"/>
			</form>
		</div>
	</core-pages>
	<script>
		var tabs = document.querySelector('paper-tabs');
        var pages = document.querySelector('core-pages');

        tabs.addEventListener('core-select',function(){
            pages.selected = tabs.selected;
        });
	</script>

        </core-scaffold>
    </body>
</html>