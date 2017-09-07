
<div class="defaultForm">

	<div class="bestiaire">
		<form>
			<label>Espèce : </label>
			<select name="especes" id="especes">
				<option></option>
			</select> <br />
			<input type='text' name='new_espece' id="new_espece" pattern=".{2,30}" required placeholder="30 caratères max." />
			<input type="button" value="Ajouter" id="add_espece" />
			<input type="button" value="Modifier" id="alter_espece" />
			<input type="button" value="Supprimer" id="del_espece" />
		
			<div class="photo">
				<img id="portraitAnimal" src="ressources/images/animaux/default/default.jpg"/>
				
				<div id="uploader">
					Modifier Photo<br/>
					<span>(220px / 200px)</span>
					<input id="fileupload" type="file" name="file">
				</div>
			</div>
		</form>
	</div>
	
	<div class="bestiaireLink">&nbsp;</div>

	<div class="bestiaire">
		<label>Race : </label>
		<select name="races" id="races">
			<option></option>
		</select> <br />
		<input type='text' name='new_race' id="new_race" pattern=".{2,30}" required placeholder="30 caratères max." />
		<input type="button" value="Ajouter" id="add_race" />
		<input type="button" value="Modifier" id="alter_race" />
		<input type="button" value="Supprimer" id="del_race" />
	</div>

</div>

<script src="ressources/js/jquery.iframe-transport.js"></script>
<script src="ressources/js/jquery.fileupload.js"></script>

<script type="text/javascript">

	function displayPhoto()
	{
		var photo = $("#especes option:selected").attr('photo') + '?' + new Date().getTime();
		$('#portraitAnimal').attr('src', photo);
	}
	
	function getJsonRaces()
	{
		var id = $("#especes option:selected").val();
		
		$.getJSON("?page=veterinaire-bestiaire&races=" + id, function(result) {
			var options = $("#races");
			options.empty();
			$.each(result, function() {
			    options.append($("<option />").val(this.id).text(this.name));
			});

			$("#new_race").val("");
		});
	}

	function getJsonEspeces()
	{
		$.getJSON("?page=veterinaire-bestiaire&especes", function(result) {
			// affichage de la liste
			var options = $("#especes");
			options.empty();
			$.each(result, function() {
			    options.append($("<option />").val(this.id).text(this.name).attr('photo', this.photo));
			});
			// mise à jour de la photo
			displayPhoto();
			// Recherche des races associées
			getJsonRaces();
			$("#new_espece").val("");
		});

	}

	function alterEspece()
	{
		var id = $("#especes option:selected").val();
		var nom = $("#new_espece").val();

		$.getJSON("?page=veterinaire-bestiaire&alter_espece=" + id + "&nom=" + nom, function(result) {
			if (parseInt(result) === <?php echo NO_ERROR; ?>) {
				$.simplyToast("Le nom de l'espece a été modifié.", "success"); // toast
				getJsonEspeces();
			} else {
				$.simplyToast("Une espece du même nom existe déjà.", "warning"); // toast
			}
		});
	}

	function addEspece()
	{
		var nom = $("#new_espece").val();
		
		$.getJSON("?page=veterinaire-bestiaire&new_espece=" + nom, function(result) {
			if (parseInt(result) === <?php echo NO_ERROR; ?>) {
				$.simplyToast("L'espece a été ajoutée.", "success"); // toast
				getJsonEspeces();
			} else {
				$.simplyToast("Une espece du même nom existe déjà.", "warning"); // toast
			}
		});
	}

	function addRace()
	{
		var id = $("#especes option:selected").val();
		var nom = $("#new_race").val();
		
		$.getJSON("?page=veterinaire-bestiaire&new_race=" + id +"&nom=" + nom, function(result) {
			if (parseInt(result) === <?php echo NO_ERROR; ?>) {
				$.simplyToast("La race a été ajoutée.", "success"); // toast
				getJsonRaces();
			} else {
				$.simplyToast("Une race du même nom existe déjà.", "warning"); // toast
			}
		});
	}

	function alterRace()
	{
		var id = $("#races option:selected").val();
		var nom = $("#new_race").val();

		$.getJSON("?page=veterinaire-bestiaire&alter_race=" + id + "&nom=" + nom, function(result) {
			if (parseInt(result) === <?php echo NO_ERROR; ?>) {
				$.simplyToast("Le nom de la race a été modifié.", "success"); // toast
				getJsonRaces();
			} else {
				$.simplyToast("Une race du même nom existe déjà.", "warning"); // toast
			}
		});
	}

	function delRace()
	{
		var count = $('#races option').size();
		
		if (count > 1) {
			var id = $("#races option:selected").val();
	
			$.getJSON("?page=veterinaire-bestiaire&del_race=" + id, function(result) {
				if (parseInt(result) === <?php echo NO_ERROR; ?>) {
					$.simplyToast("La race a été supprimée.", "success"); // toast
					getJsonRaces();
				} else {
					$.simplyToast("Impossible de supprimer cette race : patients existants.", "warning"); // toast
				}
			});
			
		} else {
			$.simplyToast("Suppression annulée : une espèce doit toujours avoir une race.", "warning"); // toast
		}
			
	}


	function delEspece()
	{
		var id = $("#especes option:selected").val();

		$.getJSON("?page=veterinaire-bestiaire&del_espece=" + id, function(result) {
			if (parseInt(result) === <?php echo NO_ERROR; ?>) {
				$.simplyToast("L'espèce et les races associées ont été supprimées.", "success"); // toast
				getJsonEspeces();
			} else {
				$.simplyToast("Impossible de supprimer cette espèce : patients existants.", "warning"); // toast
			}
		});
	}
	

	/*
	 * Main script
	 */

	 $(function () {
		 
		 'use strict';
		 getJsonEspeces(); // initialisation

		 /*
		  * Event listeners
		  */
		 $("#especes").change(function() {
			 $("#new_espece").val("");
			 displayPhoto();
			 getJsonRaces();
		 });
	
		 $("#races").change(function() {
			 $("#new_race").val("");
		 });
	
		 $("#add_espece").click(function() {
			 addEspece();
		 });
	
		 $("#alter_espece").click(function() {
			 alterEspece();
		 });
	
		 $("#add_race").click(function() {
			 addRace();
		 });
	
		 $("#alter_race").click(function() {
			 alterRace();
		 });

		 $("#del_race").click(function() {
			 delRace();
		 });

		 $("#del_espece").click(function() {
			 delEspece();
		 });

		// To extend simply-toast default options
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

		/*
		 * File Upload
		 */

		 var url = '?page=veterinaire-bestiaire';
		 
		 $('#fileupload').fileupload({
		        url: url,
		        dataType: 'json',
		        done: function (e, data) {  
		            if (typeof data.result.file != 'undefined') {
			            
			            var img = data.result.file.url + '?' + new Date().getTime();
			            var option = $("#especes option:selected");
			            
		            	$.simplyToast("Photo mise à jour", "success"); // toast
		            	option.attr('photo', img);
		            	displayPhoto();
		            		
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