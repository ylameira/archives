<?php
	try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=socialnet', 'root', 'root');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	
	if(isset($_GET['id_mess_qu_on_a_dislike'])){
		$bdd->exec("UPDATE message SET aime_pas=aime_pas+1 WHERE id_m=".$_GET['id_mess_qu_on_a_dislike']);
	}
	
	header("Location: ../index/index.php");
?>