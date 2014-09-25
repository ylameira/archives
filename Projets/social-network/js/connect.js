function request_connect() {
    var xhr = XMLHttpRequest();
    var xhr1 = XMLHttpRequest();
    
    var mail = encodeURIComponent(document.getElementById("mail_connect").value);
    var passwd = encodeURIComponent(document.getElementById("passwd_connect").value);

    xhr.onreadystatechange = function() {
    	$('#connect_erreur').empty();
    	$('.form_connect').removeAttr("style");
    	if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {    		
        	if(xhr.responseText=="miss_mail"){
	        	$('#connect_erreur').append("Veuillez entrer votre adresse mail.");
	        	$('#mail_connect').css("border","#df0c0c 2px solid");
        	}
        	else if(xhr.responseText=="miss_mdp"){
	        	$('#connect_erreur').append("Veuillez entrer votre mot de passe.");
	        	$('#passwd_connect').css("border","#df0c0c 2px solid");
        	}
        	else if (xhr.responseText=="fail_mail"){
	        	$('#connect_erreur').append("Cette adresse email n'est pas enregistrée sur le site.");
	        	$('#mail_connect').css("border","#df0c0c 2px solid");
        	}
        	else if(xhr.responseText=='fail_mdp'){
	        	$('#connect_erreur').append("Veuillez entrer le bon mot de passe.");
	        	$('#passwd_connect').css("border","#df0c0c 2px solid");
        	}
        	else{
        		//connection normale
	        	xhr1.open("POST", "../member/connection_post.php", true);
            	xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            	xhr1.send("mail_connect="+mail+"&passwd_connect="+passwd);
        	}
        }
    };
 	
 	xhr1.onreadystatechange = function() {
		if (xhr1.readyState == 4 && (xhr1.status == 200 || xhr1.status == 0)) {
				window.location='../index/index.php';
		}
    }
 	
    xhr.open("POST", "../member/connec_tmp.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("mail_connect="+mail+"&passwd_connect="+passwd);
}