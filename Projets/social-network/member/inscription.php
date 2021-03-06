<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title> Inscription </title>	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" xml:lang="fr-FR">
	<link rel="stylesheet" type="text/css" href="../css/layout.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<script type=text/javascript src="../js/jquery-1.9.1.min.js"></script>
	<script type=text/javascript src="../js/form.js"></script>
	<script type=text/javascript src="../js/connect.js"></script>	

</head>
<body>
	<?php include("../elements/head.php"); ?>
	
	<div id="content">
		<?php include("../elements/menu.php"); ?>
	
		<div id="corps">
			<span id="message_erreur"></span>
			<span id="message_succes"></span>
			<fieldset>
				<legend> <h2>Formulaire d'inscription </h2><legend>
				<form method=post >
					<input type=text class="form_insc" id="nom_inscr" name="nom_inscr" placeholder="Nom" /> * <br/> <br/>
					<input type=text class="form_insc" id="prenom_inscr" name="prenom_inscr" placeholder="Prénom" /> * <br/><br/>
					<input type=email class="form_insc" id="mail_inscr" name="mail_inscr" placeholder="Adresse mail" /> * <br/><br/>
					<input type=password class="form_insc" id="passwd_inscr" name="passwd_inscr" placeholder="Mot de passe" /> * <br/><br/>
					<input type=password class="form_insc" id="passwdr_inscr" name="passwdr_inscr" placeholder="Répéter" /> * <br/><br/>
					<input type=button onclick="request();" name="sub_inscr" value="Valider" />
				</form>
			
				<br/><br/>* <i>Champ obligatoire</i>
			</fieldset>
		</div>
	</div>
	
	<?php include("../elements/foot.php") ?>
	
</body>
</html>