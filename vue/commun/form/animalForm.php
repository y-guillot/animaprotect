<img id="portraitAnimal" src="<?php echo Tools::getAnimalPhoto($form->getAnimal()) . '?' . time();  ?>"/>

<div id="uploader">
	Modifier Photo<br/>
	<span>(220px / 200px)</span>
	<input id="fileupload" type="file" name="file">
</div>

<div id="files" class="files"></div>
    
<div class="infosAnimal">
	<p>
		<label>Nom : </label>
		<input name='nom' pattern=".{2,30}" required placeholder="2 à 30 caratères max." value="<?php echo $form->getNom(); ?>"/>
		<?php if (!$form->isValid('nom')) : ?>
			<span class="error">champ requis ( de 2 à 30 caratères max. )</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Race : </label>
		<select name='race' required>
			<?php foreach ($form->getRaces() as $race) :?>
				<option value="<?php echo $race->getId(); ?>" <?php if ($form->getIdRace() == $race->getId()) : ?> selected <?php endif; ?> >
					<?php echo $race->getNom(); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label>N° de puce : </label>
		<input name='puce' maxlength="15" placeholder="15 caratères max." value="<?php echo $form->getPuce(); ?>"/>
		<?php if (!$form->isValid('puce')) : ?>
			<span class="error">ne doit pas excéder 15 caratères</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Date de naissance : </label>
		<input type='date' name='dob' required value="<?php echo $form->getDateNaissance(); ?>"/>
		<?php if (!$form->isValid('date')) : ?>
			<span class="error">date non valide</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Signes distinctifs : </label>
		<textarea name="signe" maxlength="255" placeholder="255 caratères max." rows=7 ><?php echo $form->getSigneDistinctif(); ?></textarea>
		<?php if (!$form->isValid('signe')) : ?>
			<br/><span class="error">ne doit pas excéder 255 caratères</span>
		<?php endif; ?>
	</p>
	<p>
		<label>Commentaires : </label>
		<textarea name="commentaire" maxlength="255" placeholder="255 caratères max." rows=7 ><?php echo $form->getCommentaire(); ?></textarea>
		<?php if (!$form->isValid('commentaire')) : ?>
			<br/><span class="error">ne doit pas excéder 255 caratères</span>
		<?php endif; ?>
	</p>

	<!-- Javascript Upload Photo -->
	
	<script src="ressources/js/jquery.iframe-transport.js"></script>
	<script src="ressources/js/jquery.fileupload.js"></script>
	
	<script>
		$(function () {
			
		    'use strict';
		    <?php
		    	$dir = isset($_SESSION[SESSION_VETERINAIRE]) ? 'veterinaire-animaux' : 'proprietaire-animaux';
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
		            	$('#portraitAnimal').attr('src', img);
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
	            	alert('fail');
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