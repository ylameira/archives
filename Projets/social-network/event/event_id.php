<?php
	date_default_timezone_set('Europe/Paris');
	session_start();	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title> Evénement </title>	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" xml:lang="fr-FR">
	<link rel="stylesheet" type="text/css" href="../css/layout.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<script type=text/javascript src="../js/jquery-1.9.1.min.js"></script>
	<script type=text/javascript src="../js/calendarDateInput.js"></script>
</head>
<body>
	<?php include("../elements/head.php"); ?>
	
	<div id="content">
	
		<?php include("../elements/menu.php"); ?>
		
		<div id="corps">
			<?php
				try
				{
				    $bdd = new PDO('mysql:host=localhost;dbname=socialnet', 'root', 'root');
				}
				catch (Exception $e)
				{
					die('Erreur : ' . $e->getMessage());
				}
				
				$req = $bdd->query("SELECT id_e,id_hote,photo_path, user.nom_u, user.prenom_u, lieu, nom, description, id_participant, DAY(date) AS jour, MONTH(date) AS mois, YEAR(date) AS an FROM evenement, profil, user WHERE id_e=".$_GET['id_event']." AND profil.id_user=user.id_u AND profil.id_user=evenement.id_hote") or die (print_r($bdd->errorInfo()));
				
				$affiche=false;
				$participe=false;
				$even_ami=false;
				$affiche_nous=false;
				
				echo "<span id='id_participe' style='color:#06a706'></span><br/><br/>";
				while($datas=$req->fetch()){
					$date_e=$datas['an']."-".$datas['mois']."-".$datas['jour'];
					
					//si c'est notre evenement
					if ($datas['id_hote']==$_SESSION['id']){
						if (!$affiche_nous){
							$affiche_nous=true;
							echo "<form method=post action='event_post.php'><span name='id_e_".$datas['id_e']."'></span><a href='../menu/profil.php'><img src='../".$datas['photo_path']."' alt='Erreur d'affichage' title='Votre profil' class='img_event' width='120px' height='150px' /></a><br/><br/>Nom de l'événement <input name='nom_event_modif' type=text value='".$datas['nom']."' /><br/>Lieu de l'événement <input name='lieu_event_modif' type=text value='".$datas['lieu']."' /><br/>Date de l'événement <script>DateInput('orderdate', true,'DD-MON-YYYY','".$datas['jour']."-".$datas['mois']."-".$datas['an']."')</script><br/>Description de l'événement <textarea name='desc_event_modif' >".$datas['description']."</textarea><br/><br/>Participants : <ul>";
							
							$req_participant=$bdd->query("SELECT * FROM evenement, profil, user WHERE id_participant=profil.id_user AND profil.id_user=user.id_u AND id_e=".$datas['id_e']."") or die(print_r($bdd->errorInfo()));
							while($data1=$req_participant->fetch()){
								echo "<li>";
								if ($data1['id_participant']==$_SESSION['id']){
									echo "<a id='participant_liste' title='Votre profil' href='../menu/profil.php'>";
								}
								else{
									echo "<a id='participant_liste' title='Profil de ".$data1['nom_u']." ".$data1['prenom_u']."' href='../profil/friend_profil.php?id_profil=".$data1['id_participant']."'>";
								}
								echo "<img src='../".$data1['photo_path']."' class='img_event' width='30px' height='38px' /> <b>".$data1['nom_u']." ".$data1['prenom_u']."</b></a></li>";
							}
	
							echo "</ul><input type=submit value='Valider les changements' /> </form><br/><br/><br/>";
						}
					}
					//participer à l'événement d'un ami
					else {
						$even_ami=true;
						if($datas['id_participant']==$_SESSION['id']){
							$affiche=true;
							$participe=true;
							echo "<script>$('#id_participe').append('Vous participez à cet événement.');</script>";
						}
						if (!$affiche){
							$affiche=true;

							$id_e=$datas['id_e']; $id_hote=$datas['id_hote']; $nom_e=$datas['nom']; $lieu_e=$datas['lieu'];$desc_e=$datas['description'];
							echo "<a href='../profil/friend_profil.php?id_profil=".$datas['id_participant']."'><img src='../".$datas['photo_path']."' alt='Erreur d'affichage' title='Profil de ".$datas['nom_u']." ".$datas['prenom_u']."' class='img_event' width='120px' height='150px' /></a><br/><br/>Nom de l'événement <input readonly=readonly type=text  value='".$datas['nom']."' /><br/>Lieu de l'événement <input readonly=readonly type=text  value='".$datas['lieu']."' /><br/>Date de l'événement <input readonly=readonly type=text value='".$datas['jour']."-".$datas['mois']."-".$datas['an']."' /><br/>Description de l'événement <textarea readonly=readonly>".$datas['description']."</textarea><br/><br/>Participants : <ul type=square>";
							$req_participant1=$bdd->query("SELECT * FROM evenement, profil, user WHERE id_participant=profil.id_user AND profil.id_user=user.id_u AND id_e=".$datas['id_e']."") or die(print_r($bdd->errorInfo()));
							while($data2=$req_participant1->fetch()){
								echo "<li>";
								if ($data2['id_participant']==$_SESSION['id']){
									echo "<a id='participant_liste' title='Votre profil' href='../menu/profil.php'>";
								}
								else{
									echo "<a id='participant_liste' title='Profil de ".$data2['nom_u']." ".$data2['prenom_u']."' href='../profil/friend_profil.php?id_profil=".$data2['id_participant']."'>";
								}
								echo "<img src='../".$data2['photo_path']."' class='img_event' width='30px' height='38px' /> <b>".$data2['nom_u']." ".$data2['prenom_u']."</b></a></li>";
							}
							echo "</ul>";
						}
					}					
				}
				if($even_ami AND $affiche AND !$participe){
					echo "<br/><br/><a id='id_event_join' href='event_join.php?id_e=".$id_e."&id_hote=".$id_hote."&nom_e=".$nom_e."&lieu_e=".$lieu_e."&date_e=".$date_e."&desc_e=".$desc_e."'><img src='../medias/images/even_plus.gif' width='1%' /> Participer à l'événement</a><br/><br/>";
				}
			?>
		</div>
	</div>
	
	<?php include("../elements/foot.php") ?>
</body>
</html>