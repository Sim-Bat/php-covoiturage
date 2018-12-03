<?php
	$_SESSION["user"] = false;
	echo "Déconnexion en cours, vous allez être redirigé vers la page d'accueil !";

	//redirection
	header("Location: index.php?page=0");
	exit;
?>
