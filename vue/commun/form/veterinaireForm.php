<img id="portraitPraticien" src="<?php echo Tools::getPraticienPhoto($form->getUtilisateur()) . '?' . time();  ?>"/>

<div id="uploader">
	Modifier Photo<br/>
	<span>(220px / 200px)</span>
	<input id="fileupload" type="file" name="file">
</div>

<div class="infosPraticien">
	<p>
		<label>Civilité :</label>
		<select name="civilite">
			<option value="<?php echo DOCTEUR; ?>" <?php if ($form->getCivilite() == DOCTEUR) : ?>selected <?php endif; ?>>Dr.</option>
		</select>
	</p>
	<p>
		<label>Nom : </label>
		<input name='nom' pattern=".{2,50}" required placeholder="2 à 50 caratères max." value="<?php echo $form->getNom(); ?>"/>
		<?php if (!$form->isValid('nom')) : ?>
			<span class="error">champ requis ( de 2 à 50 caratères max. )</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Prénom : </label>
		<input name='prenom' pattern=".{2,50}" required placeholder="2 à 50 caratères max." value="<?php echo $form->getPrenom(); ?>"/>
		<?php if (!$form->isValid('prenom')) : ?>
			<span class="error">champ requis ( de 2 à 50 caratères max. )</span>
		<?php endif; ?>
	</p>
	<p>
		<label>E-mail : </label>
		<input name='mail' pattern=".{5,100}" required placeholder="100 caratères max." type="email" value="<?php echo $form->getMail(); ?>"/>
		<?php if (!$form->isValid('mail')) : ?>
			<span class="error">
				<?php
					switch($form->getCodeError('mail')) {
						case ERROR_REGEX :
							echo "adresse email non conforme ";
							break;
						case ERROR_SIZE :
							echo "champ requis ";
							break;
						case ERROR_EXISTS :
							echo "cette adresse email est déjà utilisée ";
							break;
					}
				?>
			( 100 caratères max. )</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Téléphone : </label>
		<input name='tel' pattern=".{10}" required placeholder="numéro sur 10 chiffres" type="tel" value="<?php echo $form->getTel(); ?>"/>
		<?php if (!$form->isValid('tel')) : ?>
			<span class="error">numéro invalide</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Date d'arrivée : </label>
		<input name='date_arrivee' type="date" required value="<?php echo $form->getDateArrivee(); ?>"/>
		<?php if (!$form->isValid('date_arrive')) : ?>
			<span class="error">date non valide</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Code praticien : </label>
		<input name='code_praticien' pattern=".{1,16}" required placeholder="16 caratères max." value="<?php echo$form->getCodePraticien(); ?>"/>
		<?php if (!$form->isValid('code_praticien')) : ?>
			<span class="error">champ requis ( 16 caratères max. )</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Mot de passe : </label>
		<input id="pass" name='pass' <?php if (!$form->getHidden(MODIFIER)) : ?>pattern=".{8,100}" required placeholder="8 caractères min." <?php endif; ?> type='password'/>
		<?php if (!$form->isValid('password')) : ?>
			<span class="error">mot de passe non séurisé ( 8 caractères minimum )</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Confirmation : </label>
		<input id="conf" name='conf' <?php if (!$form->getHidden(MODIFIER)) : ?>pattern=".{8,100}" required placeholder="8 caractères min." <?php endif; ?> type='password'/>
		<span id="conf_error" class="error hide">Le mot de passe n'est pas identique.</span>
	</p>
	
	<!-- Javascript Upload Photo -->
	
	<script src="ressources/js/jquery.iframe-transport.js"></script>
	<script src="ressources/js/jquery.fileupload.js"></script>
	
	<script>
		$(function () {
			
		    'use strict';
		    <?php
		    	$dir = isset($_SESSION[SESSION_ADMIN]) ? 'admin-veterinaires' : 'veterinaire-informations';
		    ?>
		    var url = '?page=<?php echo $dir; ?>';

		 	// To extend siply-toast default options
		    $.extend(true, $.simplyToast.defaultOptions,
				    {
	            	   type: 'success',
	            	   align: 'center',
            		   offset:
            		   {
            		      from: "top",
            		      amount: 20
            		   }
	            	});
		    
		    $('#fileupload').fileupload({
		        url: url,
		        dataType: 'json',
		        done: function (e, data) {
		            /*$.each(data.result.files, function (index, file) {
		                $('<p/>').text(file.name).appendTo('#files');
		            });*/
		            if (typeof data.result.file != 'undefined') {
			            var img = data.result.file.url + '?' + new Date().getTime(); 
		            	$('#portraitPraticien').attr('src', img);
		            	$.simplyToast("Photo mise à jour", "success"); // toast
		            } else {
		            	var error = "erreur inconnue.";
			            switch(data.result) {
			            	case <?php echo ERROR_UPLOAD; ?> :
				            	error = "Impossible d'uploader l'image.";
				            	break;
			            	case <?php echo ERROR_SIZE; ?> :
				            	error = "la taille du fichier ne doit pas excéder 1Mo.";
				            	break;
			            	case <?php echo ERROR_EXTENSION; ?> :
				            	error = "Seul le fichiers de type .jpg sont authorisés.";
				            	break;
			            }
			            $.simplyToast(error, "warning"); // toast
		            }
		        },
		        fail: function() {
		        	$.simplyToast("Impossible d'obtenir des informations sur l'image.", "warning"); // toast
		        }
		    });
		    
		    $('#fileupload').hover(
			    function() {
		    		$('#uploader').addClass("hover");
		    	}, function() {
		    		$('#uploader').removeClass("hover");
		    });
		});
				
	</script>