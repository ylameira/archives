$().ready(function(){	
	//on cache tous les contacts
	$('.users').toggleClass('active').slideUp(0,'linear');
	$('#id_add_con').keyup(function(){
		var search_result = $(this).val();		
		$('.users').each(function(index){
			// prenom
			var nom_tmp=$(this).children('a').next().next().next().next().attr('id');
			var nom = nom_tmp.replace('users_', '');
			//nom
			var prenom_tmp=$(this).children('a').next().next().next().next().next().attr('id');
			var prenom = prenom_tmp.replace('users_', '');
			
			if (search_result.length==0){
				$(this).toggleClass('active').slideUp(300,'linear');
			}
			else if (search_result.toLowerCase() == nom.toLowerCase().substring(0, search_result.length)){
				$(this).toggleClass('active').slideDown(300,'linear');
			}
			else if (search_result.toLowerCase() == prenom.toLowerCase().substring(0, search_result.length)){
				$(this).toggleClass('active').slideDown(300,'linear');
			}
			else{
				$(this).toggleClass('active').slideUp(300,'linear');
			}
		});
	});
	
	//ajouter un contact
	$('.img_plus').click(function(){
		var id_contact=$(this).next().attr('id').replace('user_','');
		location.href='../menu/add_friend_tmp.php?id_con_a_ajouter_a_la_liste_d_amis_du_connecte='+id_contact;
	});
});
