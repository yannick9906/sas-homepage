<html>
    {include(file="header.tpl", args=$header)}
    <body fullbleed unresolved {if $page.i == 1}onload="show();" {/if}>
        <core-scaffold>

            {include(file="drawer_panel.tpl", args=7)}

            <div tool icon="menu">Fragen</div>

            <paper-tabs selected="0">
		<paper-tab>Häufige Fragen (FAQ)</paper-tab>
		<paper-tab>Neue Frage</paper-tab>
	</paper-tabs>
	<core-pages selected="0">
		<div>
			{foreach $page.items item}
				<paper-shadow z="1" class="card">
					<h2 style="font-size: 20px;">{$item.ques}</h2>
					<p>{$item.answ}</p>
				</paper-shadow>
			{/foreach}
		</div>
		<div>
			<form action="action.php?p=1" method="post">
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
    <paper-toast id="toast" text="Frage eingesendet"></paper-toast>
	<script>
		var tabs = document.querySelector('paper-tabs');
        var pages = document.querySelector('core-pages');

        tabs.addEventListener('core-select',function(){
            pages.selected = tabs.selected;
        });

        function show() {
            var toast = document.querySelector('#toast');
            toast.show();
        }
	</script>

        </core-scaffold>
    </body>
</html>