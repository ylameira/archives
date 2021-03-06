<?php
	date_default_timezone_set('Europe/Paris');
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title> Profil </title>	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" xml:lang="fr-FR">
	<link rel="stylesheet" type="text/css" href="../css/layout.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<script type=text/javascript src="../js/calendarDateInput.js"></script>
</head>
<body>
	<?php include("../elements/head.php"); ?>
	
	<div id="content">
	
		<?php include("../elements/menu.php"); ?>

		<div id="corps">
			<form method=post action="profil_post.php" enctype="multipart/form-data">
				<?php
					try
					{
					    $bdd = new PDO('mysql:host=localhost;dbname=socialnet', 'root', 'root');
					}
					catch (Exception $e)
					{
						die('Erreur : ' . $e->getMessage());
					}
					
					$profil = $bdd->query("SELECT id_user,photo_path, text_desc, DAY(date_naissance) AS jour, MONTH(date_naissance) AS mois, YEAR(date_naissance) AS an, lieu_naissance,lieu_residence, travail, lieu_travail FROM profil") or die(print_r($bdd->errorInfo()));
					while($datas=$profil->fetch()){
						if($datas['id_user']==$_SESSION['id']){
							echo '<div id="affiche_profil">';
							echo '<div id="affiche_profil"><h2>'.$_SESSION['nom'].' '.$_SESSION['prenom'].'</h2>';
							//recuperation mois de naissance en lettre, jour en double chiffres
							$jour;
							$mois;
							$an=$datas['an'];
							switch($datas['jour']){
								case 0:$jour="01";break; case 1:$jour="01";break;case 2:$jour="02";break;case 3:$jour="03";break;case 4:$jour="04";break;case 5:$jour="05";break;case 6:$jour="06";break;case 7:$jour="07";break;case 8:$jour="08";break;case 9:$jour="09";break;default:$jour=$datas['jour'];break;
							}
							switch($datas['mois']){
								case 0:$mois="JAN";break; case 1:$mois="JAN";break; case 2:$mois="FEV";break; case 3:$mois="MAR";break; case 4:$mois="AVR";break; case 5:$mois="MAI";break; case 6:$mois="JUN";break; case 7:$mois="JUI";break; case 8:$mois="AOU";break; case 9:$mois="SEP";break; case 10:$mois="OCT";break; case 11:$mois="NOV";break; case 12:$mois="DEC";break; default:break; 
							}
							
							if (empty($datas['photo_path'])){
								echo " Aucune photo de profil.<br/>";
							}
							else{
								echo "Votre photo de profil <br/>";
								echo "<a href='../".$datas['photo_path']."'> <img id='id_img' src='../".$datas['photo_path']."' width='120px' height='150px' alt=\"Erreur lors de l'affichage de la photo de profil\" title=\"Photo de profil de ".$_SESSION['nom']." ".$_SESSION['prenom']." \" /> </a><br/>";
							}
							echo "Sélectionnez une photo de profil... <input type=file name='photo' />";
							echo "<br/> <br/>";
							echo "Description <textarea rows='3' cols='30' name='desc'>".$datas['text_desc']."</textarea><br/><br/>";
							echo "Date de naissance";
							echo "<script>DateInput('orderdate', true,'DD-MON-YYYY', '".$jour."-".$mois."-".$an."')</script><br/>";
							echo "Lieu de naissance <input type='text' value='".$datas['lieu_naissance']."' name='lieu_nais' /><br/><br/>";
							echo "Où vivez vous <input type='text' value='".$datas['lieu_residence']."' name='lieu_res' /><br/><br/>";
							echo "Quel travail faites vous  <input type='text' value='".$datas['travail']."' name='travail' /><br/><br/>";
							echo "Où travaillez vous <input type='text' value='".$datas['lieu_travail']."' name='lieu_travail' /><br/><br/>";
							echo "<input type=submit value='Valider' /></div>";
							echo "</div>";
						}
					}
				?>
			</form>
		</div>
	</div>
	
	<?php include("../elements/foot.php") ?>
</body>
</html>