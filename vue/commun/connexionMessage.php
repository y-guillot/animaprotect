<script>
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

	<?php
			if ($_SESSION[SESSION_ERROR] == NO_ERROR) {
				echo '$.simplyToast("Vous êtes désormais connecté(e).", "success");'; // toast
			} else {
				echo '$.simplyToast("vos identifiants sont incorrects.", "warning");'; // toast
			}
			unset($_SESSION[SESSION_ERROR]);
	?>

</script>	