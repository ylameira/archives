<?php
/*
 * Vue principale pour le chat
 */

date_default_timezone_set('Europe/Paris');
session_start();	

$user=$_SESSION['id'];

if(isset($_GET['id_conversation']))
  $id_conversation = $_GET['id_conversation'];
else 
  $id_conversation=-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        
    <title>Chat</title>
    <link type="text/css" rel="stylesheet" href="../css/layout.css" />
    <link type="text/css" rel="stylesheet" href="css/chat.css" />
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script-->
    <script type="text/javascript" src="js/contact.js"></script>
    <script type="text/javascript" src="js/conversation.js"></script>
    <script type="text/javascript" src="js/chat.js"></script>

  </head>
  <body>
    <?php include("../elements/head.php"); ?>
    <div id="content">
      <?php include("../elements/menu.php"); ?>
      <div id="corps">
	<div id="bandeau">
	  <div id="liste_bandeau">
	  </div>
	</div>

	<div id="contacts">
	  <button id="creer_conversation" onClick="creer_conversation(<?php echo $user ?>);" >Créer une conversation</button>
	  <button id="ajouter_favoris" onClick="ajouter_favoris(<?php echo $user ?>);" >Ajouter aux favoris</button>
	  <hr/><input type="text" name="search" id="search" maxlength=20 placeholder="Rechercher..."/><hr/>
	  <span id="select_all">Sélectionner tout </span><input type=checkbox id="select_all_items" /><br/>
	  <div id="contacts_liste">
	    <?php include("php/contact.php"); ?>
	    <br/><br/><br/><br/>
	  </div>
	</div>

	<div id="conversations">
	  <div id="favoris_liste">
	    <?php include("php/favoris.php"); ?>
	  </div>
	  <div id="liste_conversation">
	    <?php include("php/liste_conversations.php"); ?>
	  </div>
	  <img src="images/conversation_logo.png" id="conversation_logo" />
	</div>

	<div id="zone_centre">
	  <div id="zone_affichage">
	    <?php include("php/refresh.php") ?> 
	  </div>
	  <div id="zone_saisie">
	    <img src="images/saisie_logo.png" id="saisie_logo" />
	    <form action="php/submit.php" method="post">
	      <p>
		<input type="hidden" name="id_conversation" id="form_conversation" value="<?php echo $id_conversation; ?>" />
		<input type="hidden" name="id_source" id="form_source" value="<?php echo $user; ?>" />
		<textarea name="message" id="form_message"></textarea>
		<input type="submit" value="Envoyer" />
	      </p>
	    </form>
	  </div>
	</div>
      </div>
    </div>
    <?php include("../elements/foot.php"); ?>
  </body>
</html>
