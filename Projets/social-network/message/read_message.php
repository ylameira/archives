<script type=text/javascript>
	//window.setTimeout("window.location.reload();", 5000);
</script>

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
	
	//afficher ses propres messages
	$req = $bdd->query("SELECT photo_path,nom_u, prenom_u, id_u, contenu, id_m, aime, aime_pas, YEAR(date_message) AS an, MONTH(date_message) AS mois, DAY(date_message) AS jour, HOUR(date_message) AS heure, MINUTE(date_message) AS minutes FROM message, user, profil WHERE user.id_u=message.id_user AND user.id_u=".$_SESSION['id']." AND profil.id_user=user.id_u ORDER BY minutes,heure,jour,mois,an") or die (print_r($bdd->errorInfo()));
	while($datas=$req->fetch()){
		if($datas['aime']==0){
			$aime=NULL;
		}
		else{$aime=$datas['aime'];}
		if($datas['aime_pas']==0){
			$aime_pas=NULL;
		}
		else{$aime_pas=$datas['aime_pas'];}
		echo "<div id='affiche_message'><img class='affichage_profil' id='profil_".$datas['id_u']."' src='/projetWeb/".$datas['photo_path']."' width='60px' height='75px' title='Votre profil' /> <b>".$datas['nom_u']." ".$datas['prenom_u']." a dit</b><br/><div class='info_message'>".$datas['contenu']."<br/><i><span style='font-size:13'>".$datas['jour']."/".$datas['mois']."/".$datas['an']." à ".$datas['heure'].":".$datas['minutes']."</span></i><br/><span class='aime_mess' id='mess_".$datas['id_m']."'><b>".$aime."</b> J'aime</span> - <span class='aime_pas_mess' id='mess_".$datas['id_m']."'><b>".$aime_pas."</b> Je n'aime pas</span><br/><textarea rows='1' cols='40' name='message_rep' placeholder=\"Réagissez...\"></textarea><br/><br/></div></div><br/>";
	}
	
	//afficher les messages de ses amis
	$req_ami =$bdd->query("SELECT photo_path,friend.nom_u as nomA,id_m, aime, aime_pas, friend.prenom_u as prenomA, friend.id_u as idA, contenu, YEAR(date_message) AS an, MONTH(date_message) AS mois, DAY(date_message) AS jour, HOUR(date_message) AS heure, MINUTE(date_message) AS minutes FROM message, user as friend, user as utilisateur, ami, profil WHERE friend.id_u=ami.id_ami AND utilisateur.id_u=ami.id_u AND message.id_user=friend.id_u AND utilisateur.id_u=".$_SESSION['id']." AND profil.id_user=friend.id_u ORDER BY minutes,heure,jour,mois,an") or die (print_r($bdd->errorInfo()));
	
	while($datas1=$req_ami->fetch()){
		if($datas1['aime']==0){
			$aime1=NULL;
		}
		else{$aime1=$datas1['aime'];}
		if($datas1['aime_pas']==0){
			$aime_pas1=NULL;
		}
		else{$aime_pas1=$datas1['aime_pas'];}

		echo "<div id='affiche_message'><img class='affichage_profil' id='profil_".$datas1['idA']."' src='/projetWeb/".$datas1['photo_path']."' width='60px' height='75px' title='Profil de ".$datas1['nomA']." ".$datas1['prenomA']."' /> <b>".$datas1['nomA']." ".$datas1['prenomA']." a dit</b><br/><div class='info_message'>".$datas1['contenu']."<br/><i><span style='font-size:13'>".$datas1['jour']."/".$datas1['mois']."/".$datas1['an']." à ".$datas1['heure'].":".$datas1['minutes']."</span></i><br/><span class='aime_mess' id='mess_".$datas1['id_m']."'><b>".$aime1."</b> J'aime</span> - <span class='aime_pas_mess' id='mess_".$datas1['id_m']."'><b>".$aime_pas1."</b> Je n'aime pas</span><br/><textarea rows='1' cols='40' name='message_rep' placeholder=\"Réagissez...\"></textarea><br/><br/></div></div><br/>";

	}
?>