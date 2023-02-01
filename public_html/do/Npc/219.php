<?
	$response['name'] = 'Жемчужный Торговец';
	switch($npcStep){
		  case 1:
		 	 $response['question'] = '
		  	 Отлично! Смотри! Вот все, что есть.
		 	 <br><span class="bgPok" onclick=openDex("396")><img src="/img/pokemons/anim/normal/396.gif"> #396 Старли</span> за <b>10 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,2,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("453")><img src="/img/pokemons/anim/normal/453.gif"> #453 Кроуганк</span> за <b>12 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,3,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("179")><img src="/img/pokemons/anim/normal/179.gif"> #179 Марип</span> за <b>12 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,4,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("543")><img src="/img/pokemons/anim/normal/543.gif"> #543 Венипед</span> за <b>14 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,5,event);">Приобрести</a>
		 	 <br><span class="bgPok" onclick=openDex("102")><img src="/img/pokemons/anim/normal/102.gif"> #102 Экзекут</span> за <b>16 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,6,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("120")><img src="/img/pokemons/anim/normal/120.gif"> #120 Старью</span> за <b>18 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,7,event);">Приобрести</a>
		 	 <br><span class="bgPok" onclick=openDex("280")><img src="/img/pokemons/anim/normal/280.gif"> #280 Ральтс</span> за <b>120 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,8,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("359")><img src="/img/pokemons/anim/normal/359.gif"> #359 Абсол</span> за <b>22 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,9,event);">Приобрести</a>
		 	 <br><span class="bgPok" onclick=openDex("559")><img src="/img/pokemons/anim/normal/559.gif"> #559 Скрагги</span> за <b>25 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,10,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("214")><img src="/img/pokemons/anim/normal/214.gif"> #214 Геракросс</span> за <b>90 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,11,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("355")><img src="/img/pokemons/anim/normal/355.gif"> #355 Даскулл</span> за <b>40 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,12,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("133")><img src="/img/pokemons/anim/normal/133.gif"> #133 Иви</span> за <b>60 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,13,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("704")><img src="/img/pokemons/anim/normal/704.gif"> #704 Гуми</span> за <b>200 Жемчуга.</b> - <a href="#" onclick="NpcDialog(219,14,event);">Приобрести</a>
		 	 <br><i>~Все покемоны вылупятся с генами по 28, уникальным окрасом (Шайни или Шедоу), неспаренными, но непередаваемыми.~</i>
		   	 ';
		  break;
		  case 2:
		   	 if(item_isset(43,10)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (10 шт.)';
				 $response['question'] = 'Спасибо за покупку!';
		  		 plusEgg('28,28,28,28,28,28',false,1,false,false,396,false);
		 		 minus_item(43,10);
		   	 }else{
		 		 $response['question'] = 'Недостаточно денег!';
		   	 }
		  break;
		    case 3:
		 	 if(item_isset(43,12)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (12 шт.)';
		  		 $response['question'] = 'Спасибо за покупку!';
		 		 plusEgg('28,28,28,28,28,28',false,1,false,false,453,false);
		   		 minus_item(43,12);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 4:
		   	 if(item_isset(43,12)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (12 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,179,false);
		 		 minus_item(43,12);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 5:
		   	 if(item_isset(43,14)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (14 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,543,false);
		 		 minus_item(43,14);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 6:
		   	 if(item_isset(43,16)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (16 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,102,false);
		 		 minus_item(43,16);
		   	 }else{
		 		 $response['question'] = 'Недостаточно денег!';
		   	 }
		  break;
		    case 7:
		 	 if(item_isset(43,18)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (18 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
		 		 plusEgg('28,28,28,28,28,28',false,1,false,false,120,false);
		   		 minus_item(43,18);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 8:
		   	 if(item_isset(43,120)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (120 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
		 		 plusEgg('28,28,28,28,28,28',false,1,false,false,280,false);
		   		 minus_item(43,120);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 9:
		   	 if(item_isset(43,22)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (22 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,359,false);
		 		 minus_item(43,22);
		   	 }else{
		 		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 10:
		   	 if(item_isset(43,25)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (25 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,559,false);
		 		 minus_item(43,25);
		   	 }else{
				 $response['question'] = 'Недостаточно денег!';
		   	 }
		  break;
		    case 11:
		 	 if(item_isset(43,90)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (90 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,214,false);
		   		 minus_item(43,90);
			 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		    	case 12:
		 	 if(item_isset(43,40)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (40 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,355,false);
		   		 minus_item(43,40);
			 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		    	case 13:
		 	 if(item_isset(43,60)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (60 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,133,false);
		   		 minus_item(43,60);
			 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		    	case 14:
		 	 if(item_isset(43,200)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (200 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,704,false);
		   		 minus_item(43,200);
			 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		default:
			$response['question'] = 'Весь товар распродан! Приходи в другой раз.';
			  $response['question'] = 'Стой! Не проходи мимо! Яйца экзотических покемонов ты найдешь только у меня!';
			  $response['answer'] = array(
			   	 1 => "Я хочу осмотреть ваш ассортимент."
			  );
		break;
	}
?>
