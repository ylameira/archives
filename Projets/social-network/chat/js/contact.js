/* 
	* contact.js 
	*
	* Fichier permettant de (de)plier la liste des contacts, de faire une recherche dynamique
	* des contacts, de selectionner un ou plusieurs contacts/groupes
	* Inclus dans chat.js
*/

function check_box_item(parentBox, childBox){
	$(parentBox).change(function(index){
		if ($(this).is(":checked")){
			$(childBox).each(function(){
				$(this).prop('checked', true);
			});
		}
	});
}

function uncheck_box_item(parentBox, childBox){
	$(parentBox).change(function(index){
		if ($(this).is(":not(:checked)")){
			$(childBox).each(function(){
				$(this).prop('checked', false);
			});
		}
	});
}

function check_box_all(){
	$('#select_all_items').change(function(){
		if ($(this).is(':checked')){
			$('.check_con').each(function(){
				$(this).prop('checked',true);
				$('.check_item_ami').each(function(){
					$(this).prop('checked',true);
				});
				$('.check_item_fav').each(function(){
					$(this).prop('checked',true);
				});
			});
		}
	});
}

function uncheck_box_all(){
	$('#select_all_items').change(function(){
		if ($(this).is(':not(:checked)')){
			$('.check_con').each(function(){
				$(this).prop('checked',false);
				$('.check_item_ami').each(function(){
					$(this).prop('checked',false);
				});
				$('.check_item_fav').each(function(){
					$(this).prop('checked',false);
				});
			});
		}
	});
}
function contact_init(){
		//On cache le contenu des listes au chargement de la page
       	$('.trigger').toggleClass('active').next().next().slideUp(0);

        $('.trigger').click(function(){      
		$(this).toggleClass('active').next().next().slideToggle(300,'linear');
	        
			/* Permet le changement d'image quand une liste se déroule ou s'enroule
			 */
			var img_list = $(this).children('img');
			if($(img_list[0]).is(':visible')) {
			  $(img_list[0]).hide();
			  $(img_list[1]).show();
			}
			else {
			  $(img_list[1]).hide();
			  $(img_list[0]).show();
			}
		});
	 
	var searched=false;
	//SYSTEME DE RECHERCHE
	$('#search').keyup(function(){
		//sert a plier/deplier les listes lors de la recherche.
		var search_result = $('#search').val();		

		$('.item').each(function(index){			
			var lastName='';
			var firstName='';
			var j=0;
			while($(this).text().charCodeAt(j) != 32){
				lastName+=$(this).text().charAt(j);
				j++;
			}
			firstName = $(this).text().replace(lastName+' ','');

			if (search_result.length==0){
				$('.trigger').toggleClass('active').next().next().slideUp(300,'linear');
				$(this).toggleClass('active').slideDown(300, 'linear');
			}			
			else if (search_result.toLowerCase() ==$(this).text().substr(0, search_result.length).toLowerCase()){
				$(this).parents(".wrap").children().toggleClass('active').next().next().slideDown(300,'linear');
				$(this).toggleClass('active').slideDown(300, 'linear');
			}
			else if (search_result.toLowerCase() == firstName.substr(0, search_result.length).toLowerCase()){
				$(this).parents(".wrap").children().toggleClass('active').next().next().slideDown(300,'linear');
				$(this).toggleClass('active').slideDown(300, 'linear');
			}
			else{
				if (index == ($('.item').length)-1 ){
					$(this).parents(".wrap").children().toggleClass('active').next().next().slideUp(300,'linear');
				}
				$(this).toggleClass('active').slideUp(300, 'linear');
			}
			
		});
	});
	
	//LORSQU'ON CHECK UNE CHECKBOX AMI  OU FAV : COCHE TOUTES LES CHILD CASES
	check_box_item('#check_ami', '.check_item_ami');
	check_box_item('#check_fav', '.check_item_fav');
	check_box_all();
	
	//LORSQU'ON UNCHECK UNE CHECKBOX AMI OU FAV : DECOCHE TOUTES LES CHILD CASES
	uncheck_box_item('#check_ami', '.check_item_ami');
	uncheck_box_item('#check_fav', '.check_item_fav');
	uncheck_box_all();
}