<?php
	session_start();
	
	try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=socialnet', 'root', 'root');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	
	$img_folder_server="medias/upload_img/";
	$authorized_ext= array('.png','.gif','.jpeg','.jpg', '.JPG','.PNG','.GIF','.JPEG');
	$file_ext = ".".strtolower(substr(strrchr($_FILES['photo']['name'],'.'),1));
	
	$file_size = filesize($_FILES['photo']['tmp_name']);
	$max_size = 3000000; //Fichier max de 3 Mo
	
	$file_name=$_SESSION['id'].$file_ext;
	
	if(!in_array($file_ext, $authorized_ext)){
		echo "<script> alert('Cette extension de fichier n\'est pas autorisée.')</script>";
	}
	else if($file_size > $max_size){
		echo "<script> alert('Cette photo de profil est trop volumineuse.')</script>";
	}
	else if(!isset($_FILES['photo']) OR empty($_FILES['photo']['name'])){
		echo "<script> alert('Une erreur est survenue lors de l'envoi de la photo.')</script>";
	}
	else{
		//$file_name=strtr($_FILES['photo']['name'],'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		if(move_uploaded_file($_FILES['photo']['tmp_name'], "../".$img_folder_server.$file_name)){
			$bdd->exec("UPDATE profil SET photo_path='".$img_folder_server.$file_name."' WHERE profil.id_user=".$_SESSION['id']);
		}
		else{
			echo "<script> alert('Une erreur s'est produite lors du déplacment de l'image.')</script>";
		}
	}
	
	//concat jour mois an dans un string
	switch ($_POST['mois']){
		case "0" : 
			$_POST['mois']="01";
			break;
		case "1" : 
			$_POST['mois']="02";
			break;
		case "2" : 
			$_POST['mois']="03";
			break;
		case "3" : 
			$_POST['mois']="04";
			break;
		case "4" : 
			$_POST['mois']="05";
			break;
		case "5" : 
			$_POST['mois']="06";
			break;
		case "6" : 
			$_POST['mois']="07";
			break;
		case "7" : 
			$_POST['mois']="08";
			break;
		case "8" : 
			$_POST['mois']="09";
			break;
		case "9" : 
			$_POST['mois']="10";
			break;
		case "10" : 
			$_POST['mois']="11";
			break;		
		case "11" : 
			$_POST['mois']="12";
			break;
		default:
			break;
	}
	switch ($_POST['jour']){
		case "1" : 
			$_POST['jour']="01";
			break;
		case "2" : 
			$_POST['jour']="02";
			break;
		case "3" : 
			$_POST['jour']="03";
			break;
		case "4" : 
			$_POST['jour']="04";
			break;
		case "5" : 
			$_POST['jour']="05";
			break;
		case "6" : 
			$_POST['jour']="06";
			break;
		case "7" : 
			$_POST['jour']="07";
			break;
		case "8" : 
			$_POST['jour']="08";
			break;
		case "9" : 
			$_POST['jour']="09";
			break;
		default:
			break;
	}
	$date=$_POST['an']."-".$_POST['mois']."-".$_POST['jour'];
	
	$bdd->exec("UPDATE profil set text_desc='".$_POST['desc']."', date_naissance='".$date."', lieu_naissance='".$_POST['lieu_nais']."', lieu_residence='".$_POST['lieu_res']."',travail='".$_POST['travail']."',lieu_travail='".$_POST['lieu_travail']."'  WHERE profil.id_user=".$_SESSION['id']);
			
	//redirection
	header("Location: profil.php");
?>