
<form name="connexion" class="connexion" method="post" action="?page=accueil">
	E-Mail : <input type="email" name="email" required/>
	Pass : <input type="password"  name="pass" pattern=".{8,100}" required "/>
	<input type="hidden" name="authentification"/>
	<input class="purple" name='bouton' type='submit' value='OK'/>
</form>
