<?php
	//session_start();
	try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=socialnet', 'root', 'root');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	
	if (isset($_POST['message']) AND !empty($_POST['message'])){
		//ecrire dans la bdd le message
		$req=$bdd->query("INSERT INTO message(id_user, contenu, date_message, aime, aime_pas) VALUES (".$_SESSION['id'].", \"".$_POST['message']."\", NOW(), 0, 0)") or die(print_r($bdd->errorInfo()));
		
	}
?>

<!--Envoyer un message-->
<div id="envoi_message">
	<form method=post action="index.php">
		<textarea rows='3' cols='130' name='message' placeholder="Exprimez vous..."></textarea>
		<input type=submit value="Envoyer" />
	</form>
</div>
