<div class="container">
    <div class="row">
		<div class="card-panel col s12">
			<br/>
			<b>Bei Fragen bitte an:</b> <a href="mailto:sas_schlossgymnasium@gmx.de">sas_schlossgymnasium@gmx.de</a>
			<br/><br/>
			<!--<form action="action.php?p=1&token={$page.token}" method="post">
				<h5 class="center">Du hast eine Frage? Dann schicke sie uns.</h5>
				<div class="input-field col s12">
                    <label for="email">Emailaddresse</label>
                    <input id="email" required type="email" name="email" required length="255"/>
                </div>
				<div class="input-field col s12">
                    <label for="subject">Betreff</label>
                    <input id="subject" required type="text" name="subject" required length="512"/>
                </div>
                <div class="input-field col s12">
                    <textarea id="text" name="text" required class="materialize-textarea" length="10000"></textarea>
                    <label for="text">Nachricht</label>
                </div>
				<div class="col s12">
					<button class="btn waves-effect waves-light indigo right" type="submit" name="action">Abschicken
						<i class="material-icons right">send</i>
					</button>
				</div>
				<br/>&nbsp;
			</form>-->
        </div>
		<div class="collection col s12">
			{foreach $page.items item}
				<li class="collection-item avatar">
				<i class="indigo circle mdi mdi-comment"></i>
					<span class="title">{$item.ques}</span>
				<p>{$item.answ}
				</p>
			</li>
			{/foreach}
		</div>
    </div>
</div>
<script>
	 $(document).ready(function() {
		 $('input#email, input#subject, textarea#text').characterCounter();
	 });
</script>