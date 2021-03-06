<?php
//	date_default_timezone_set('Europe/Paris');
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title> Profil </title>	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" xml:lang="fr-FR">
	<link rel="stylesheet" type="text/css" href="../css/layout.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<!--script type=text/javascript src="../js/calendarDateInput.js"></script-->
</head>
<body>
	<?php include("../elements/head.php"); ?>
	
	<div id="content">
		<?php include("../elements/menu.php"); ?>

		<div id="corps">
			<?php
				if($_GET['id_profil']==$_SESSION['id']){
					echo "<script type=text/javascript>location.href='../menu/profil.php'</script>";
				}
				try
				{
				    $bdd = new PDO('mysql:host=localhost;dbname=socialnet', 'root', 'root');
				}
				catch (Exception $e)
				{
					die('Erreur : ' . $e->getMessage());
				}
	
				$req = $bdd->query("SELECT nom_u, prenom_u, photo_path, text_desc, lieu_naissance, DAY(date_naissance) AS jour, MONTH(date_naissance) AS mois, YEAR(date_naissance) AS an, lieu_residence, travail, lieu_travail FROM profil, user WHERE user.id_u=profil.id_user AND id_user=".$_GET['id_profil']) or die (print_r($bdd->errorInfo()));
				while($datas=$req->fetch()){
					echo "<div id='affiche_profil'><a href='../".$datas['photo_path']."'><img src='../".$datas['photo_path']."' width='120px' height='150px' /></a><br/><h2>".$datas['nom_u']." ".$datas['prenom_u']."</h2><br/><div id='desc_contact'><h3>Description</h3><div id='info_desc_contact'>".$datas['text_desc']."</div></div><br/>";
					echo "<div id='residence_contact'><h3>Lieu de résidence</h3><div id='info_residence_contact'>".$datas['lieu_residence']."</div></div><br/><div id='naissance_contact'><h3>Anniversaire</h3><div id='info_naissance_contact'>Lieu de naissance<br/><input type=text readonly=readonly value='".$datas['lieu_naissance']."' /><br/>";
					echo "<br/>Date de naissance<br/><input type=text readonly=readonly value='".$datas['jour']."/".$datas['mois']."/".$datas['an']."' /></div></div><br/>";
					echo "<div id='travail_contact'><h3>Travail</h3><div id='info_travail_contact'>Type de travail <input type=text readonly=readonly value='".$datas['travail']."' /><br/>Lieu du travail <input type=text readonly=readonly value='".$datas['lieu_travail']."' /></div></div></div>";
				}
			?>
		</div>
	</div>
	
	<?php include("../elements/foot.php") ?>
</body>
</html>