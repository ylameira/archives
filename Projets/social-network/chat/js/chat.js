/* Fichier principal appelant tous les script JQuery après chargement complet du DOM.
 */

$(document).ready(function() {
    /* Ecouteur permettant le submit du textarea via la touche "enter" (13)
     */
    $('textarea#form_message').keydown(function(event) {
      if (event.keyCode == 13 && $(this).val()!="") {
        this.form.submit();
        return false;
      }
      //Place automatiquement la scroll bar en bas
      scrollDown();
    });
    
    /* Ecouteur empêchant l'envoi de message vide
     */
    $('textarea#form_message').keyup(function(event) {
      if (event.keyCode == 13)
        if($(this).val()=='\n')
          $(this).val("");
    });
    
    //Place les écouteurs de la liste de contacts
    contact_init();
    
    //Redonne le focus par défaut à la zone de saisie
    $('textarea#form_message').focus();
    
    //Rafraîchit le chat
    refresh();
    refresh_fav();
        
    //Place automatiquement la scroll bar en bas
    scrollDown();
});

/* Fonction de rafaîchissement des messages et conversations
 */
function refresh(id_conversation) {
  if (typeof id_conversation != "undefined") { //Si le paramètre existe
    $('#form_conversation').val(id_conversation);
  } 
  else { //Si le paramètre n'existe pas, on est toujours sur la même conversation
    var id_conversation = document.getElementById("form_conversation").value;
  }
  
  //Rafraîchissement de le zone d'affichage des messages
  var data_refresh = "id_conversation="+id_conversation;
  var xhr_refresh = null;
  if(window.XMLHttpRequest) 
    xhr_refresh = new XMLHttpRequest(); 
  else if(window.ActiveXObject)
    xhr_refresh = new ActiveXObject("Microsoft.XMLHTTP");
  else { 
    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
    return; 
  }
  xhr_refresh.open("POST", "php/refresh.php", true);
  xhr_refresh.onreadystatechange = function() {
    if(xhr_refresh.readyState == 4) {
      //Recharge uniquement le contenu de la zone des messages
      $('div#zone_affichage').html(xhr_refresh.responseText);
      //Place automatiquement la scroll bar en bas
      scrollDown();
    }
    return xhr_refresh.readyState;
  } 
  xhr_refresh.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr_refresh.send(data_refresh);
  
  //Rafraîchissement de le zone d'affichage des messages
  var data_bandeau = "id_conversation="+id_conversation;
  var xhr_bandeau = null;
  if(window.XMLHttpRequest) 
    xhr_bandeau = new XMLHttpRequest(); 
  else if(window.ActiveXObject)
    xhr_bandeau = new ActiveXObject("Microsoft.XMLHTTP");
  else { 
    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
    return; 
  }
  xhr_bandeau.open("POST", "php/bandeau.php", true);
  xhr_bandeau.onreadystatechange = function() {
    if(xhr_bandeau.readyState == 4) {
      var recv = xhr_bandeau.responseText.split("-");
      var send = recv[0];
      var i = 1;
      while(send.length < 130 && i < recv.length) {
	send = send+"-"+recv[i];
	i++;
      }
      if(xhr_bandeau.responseText.length > 150)
	send = send+"...";
      if(id_conversation!=-1)
	send = send+'<img src="images/delete.gif" id="delete_bandeau" onclick="supprimer_conv('+id_conversation+')" style="float: right" />';
      //Recharge uniquement le contenu du bandeau
      $('div#liste_bandeau').html(send);
      
      //Place automatiquement la scroll bar en bas
      scrollDown();
    }
    return xhr_bandeau.readyState;
  } 
  xhr_bandeau.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr_bandeau.send(data_bandeau);

  //Rafraîchissement de la liste des conversations
  data_conversation = "id_user="+document.getElementById("form_source").value;
  var xhr_conversation = null;
  if(window.XMLHttpRequest) 
    xhr_conversation = new XMLHttpRequest(); 
  else if(window.ActiveXObject)
    xhr_conversation = new ActiveXObject("Microsoft.XMLHTTP");
  else { 
    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
    return; 
  }
  
  xhr_conversation.open("POST", "php/liste_conversations.php", true);
  xhr_conversation.onreadystatechange = function() {
    if(xhr_conversation.readyState == 4) {
      //Recharge uniquement le contenu de la liste des conversations
      $('div#liste_conversation').html(xhr_conversation.responseText);
      
      //Place la conversation sélectionnée
      $('.conv').each(function() {
        if($(this).attr("value") == id_conversation)
          $(this).css('background-color','#ffffff'); 
      });
    
      /* Ecouteur permettant le changement de conversation
       */
      $('.conv').click(function() {
        $('.conv').css('background','none');
        $(this).css('background-color','#ffffff');
        refresh($(this).attr("value"));
        $('textarea#form_message').focus();
      });
    }
    return xhr_conversation.readyState;
  } 
  xhr_conversation.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr_conversation.send(data_conversation);
}

//Appelle refresh() toutes les 5 secondes
setInterval(refresh,5000);

/* Fonction de rafaîchissement des favoris
 */
function refresh_fav() {
  //Rafraîchissement de la liste des favoris
  data_favoris = "id_user="+document.getElementById("form_source").value;
  var xhr_favoris = null;
  if(window.XMLHttpRequest) 
    xhr_favoris = new XMLHttpRequest(); 
  else if(window.ActiveXObject)
    xhr_favoris = new ActiveXObject("Microsoft.XMLHTTP");
  else { 
    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
    return; 
  }
  
  xhr_favoris.open("POST", "php/liste_favoris.php", true);
  xhr_favoris.onreadystatechange = function() {
    if(xhr_favoris.readyState == 4) {
      //Recharge uniquement le contenu de la liste des favoris
      $('div#select_fav').html(xhr_favoris.responseText);
    }
    return xhr_favoris.readyState;
  } 
  xhr_favoris.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr_favoris.send(data_favoris);
}

/* Fonction descendant la scroll bar de la zone d'affichage en bas
 */
function scrollDown() {
  var element = document.getElementById('zone_affichage');
  element.scrollTop = element.scrollHeight;
  $("html, body").css('scrollTop', $(document).height());
}
