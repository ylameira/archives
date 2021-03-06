<?php
	date_default_timezone_set('Europe/Paris');
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title> Liste d'amis </title>	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" xml:lang="fr-FR">
	<link rel="stylesheet" type="text/css" href="../css/layout.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<script type=text/javascript src="../js/jquery-1.9.1.min.js"></script>
	<script type=text/javascript src="../js/search_con.js"></script>
</head>
<body>
	<?php include("../elements/head.php"); ?>
	
	<div id="content">
		<?php include("../elements/menu.php"); ?>

		<div id="corps">
			<div id="recherche_ami">
				<p style="margin-left: 30%">Ajouter un contact <input type=text name="add_con" id="id_add_con" placeholder="Rechercher un contact..." /></p><br/>
				<?php	
					try
					{
					    $bdd = new PDO('mysql:host=localhost;dbname=socialnet', 'root', 'root');
		
					}
					catch (Exception $e)
					{
					        die('Erreur : ' . $e->getMessage());
					}	
						
					$search_con_ami=$bdd->query("select * from user, profil where user.id_u=profil.id_user and user.id_u not in (select friend.id_u FROM user as utilisateur, user as friend, ami where utilisateur.id_u=ami.id_u AND friend.id_u=ami.id_ami and utilisateur.id_u=".$_SESSION['id'].") and user.id_u!=".$_SESSION['id']."") or die (print_r($bdd->errorInfo()));
					
					while($datas1 =$search_con_ami->fetch()){
						echo "<div class='users'><a href='../profil/friend_profil.php?id_profil=".$datas1['id_user']."'><img src='../".$datas1['photo_path']."' alt=\"Erreur lors de l'affichage de la photo de profil de ".$datas1['nom_u']." ".$datas1['prenom_u']."\" title='Photo de profil de ".$datas1['nom_u']." ".$datas1['prenom_u']."' width='120px' height='150px' /></a><br/><img class='img_plus' src='../medias/images/contact_plus.png' /> <span id='user_".$datas1['id_u']."'></span><div class='users_nom' id='users_".$datas1['nom_u']."' />".$datas1['nom_u']."</div> <div class='users_prenom' id='users_".$datas1['prenom_u']."'>".$datas1['prenom_u']."</div></div><br/>";
					}
				?>
			</div>
		
			<div id="affichage_ami">
				<?php			
					$have_friend=false;
					
					$search_ami = $bdd->query('SELECT user1.nom_u AS nom, user1.prenom_u AS prenom, user1.mail_u AS mail_u, user2.nom_u AS nomA, user2.prenom_u AS prenomA, profil.id_user, profil.photo_path, user2.id_u AS id FROM user AS user1, user AS user2, ami, profil WHERE user1.id_u=ami.id_u AND user2.id_u=ami.id_ami AND profil.id_user=user2.id_u ') or die (print_r($bdd->errorInfo()));
					
					while($datas = $search_ami->fetch()){
						if($_SESSION['mail']==$datas['mail_u']){
							echo "<div class='amis'><a href='../profil/friend_profil.php?id_profil=".$datas['id']."'><img name='id_img_ami' src='../".$datas['photo_path']."' alt=\"Erreur lors de l'affichage de la photo de profil de ".$datas['nomA']." ".$datas['prenomA']." \" title='Photo de profil de ".$datas['nomA']." ".$datas['prenomA']."' width='120px' height='150px' /></a><br/>".$datas['nomA']." ".$datas['prenomA']."</div><br/>";
							$have_friend=true;
						}
					}
					?>
			</div>
		</div>
	</div>
	<?php include("../elements/foot.php") ?>
</body>
</html>