<?
	$response['name'] = 'Торговец Яиц';
	switch($npcStep){
		  case 1:
		 	 $response['question'] = '
		  	 Отлично! Смотри! Вот все, что есть.
		 	 <br><span class="bgPok" onclick=openDex("396")><img src="/img/pokemons/anim/normal/396.gif"> #396 Старли</span> за <b>1.000.000 мон.</b> - <a href="#" onclick="NpcDialog(211,2,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("453")><img src="/img/pokemons/anim/normal/453.gif"> #453 Кроуганк</span> за <b>1.200.000 мон.</b> - <a href="#" onclick="NpcDialog(211,3,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("179")><img src="/img/pokemons/anim/normal/179.gif"> #179 Марип</span> за <b>1.200.000 мон.</b> - <a href="#" onclick="NpcDialog(211,4,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("543")><img src="/img/pokemons/anim/normal/543.gif"> #543 Венипед</span> за <b>1.400.000 мон.</b> - <a href="#" onclick="NpcDialog(211,5,event);">Приобрести</a>
		 	 <br><span class="bgPok" onclick=openDex("102")><img src="/img/pokemons/anim/normal/102.gif"> #102 Экзекут</span> за <b>1.600.000 мон.</b> - <a href="#" onclick="NpcDialog(211,6,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("120")><img src="/img/pokemons/anim/normal/120.gif"> #120 Старью</span> за <b>1.800.000 мон.</b> - <a href="#" onclick="NpcDialog(211,7,event);">Приобрести</a>
		 	 <br><span class="bgPok" onclick=openDex("280")><img src="/img/pokemons/anim/normal/280.gif"> #280 Ральтс</span> за <b>2.000.000 мон.</b> - <a href="#" onclick="NpcDialog(211,8,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("359")><img src="/img/pokemons/anim/normal/359.gif"> #359 Абсол</span> за <b>2.200.000 мон.</b> - <a href="#" onclick="NpcDialog(211,9,event);">Приобрести</a>
		 	 <br><span class="bgPok" onclick=openDex("559")><img src="/img/pokemons/anim/normal/559.gif"> #559 Скрагги</span> за <b>2.500.000 мон.</b> - <a href="#" onclick="NpcDialog(211,10,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("214")><img src="/img/pokemons/anim/normal/214.gif"> #214 Геракросс</span> за <b>3.000.000 мон.</b> - <a href="#" onclick="NpcDialog(211,11,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("355")><img src="/img/pokemons/anim/normal/355.gif"> #355 Даскулл</span> за <b>4.000.000 мон.</b> - <a href="#" onclick="NpcDialog(211,12,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("196")><img src="/img/pokemons/anim/normal/196.gif"> #196 Эспеон</span> за <b>5.000.000 мон.</b> - <a href="#" onclick="NpcDialog(211,13,event);">Приобрести</a>
		   	 <br><span class="bgPok" onclick=openDex("704")><img src="/img/pokemons/anim/normal/704.gif"> #704 Гуми</span> за <b>10.000.000 мон.</b> - <a href="#" onclick="NpcDialog(211,14,event);">Приобрести</a>
		 	 <br><i>~Все покемоны вылупятся с генами по 28, уникальным окрасом (Шайни или Шедоу), неспаренными, но непередаваемыми.~</i>
		   	 ';
		  break;
		  case 2:
		   	 if(item_isset(1,1000000)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
				 $response['question'] = 'Спасибо за покупку!';
		  		 plusEgg('28,28,28,28,28,28',false,1,false,false,396,false);
		 		 minus_item(1,1000000);
		   	 }else{
		 		 $response['question'] = 'Недостаточно денег!';
		   	 }
		  break;
		    case 3:
		 	 if(item_isset(1,1200000)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1200000 шт.)';
		  		 $response['question'] = 'Спасибо за покупку!';
		 		 plusEgg('28,28,28,28,28,28',false,1,false,false,453,false);
		   		 minus_item(1,1200000);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 4:
		   	 if(item_isset(1,1200000)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1200000 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,179,false);
		 		 minus_item(1,1200000);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 5:
		   	 if(item_isset(1,1400000)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1400000 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,543,false);
		 		 minus_item(1,1400000);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 6:
		   	 if(item_isset(1,1600000)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1600000 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,102,false);
		 		 minus_item(1,1600000);
		   	 }else{
		 		 $response['question'] = 'Недостаточно денег!';
		   	 }
		  break;
		    case 7:
		 	 if(item_isset(1,1800000)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1800000 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
		 		 plusEgg('28,28,28,28,28,28',false,1,false,false,120,false);
		   		 minus_item(1,1800000);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 8:
		   	 if(item_isset(1,2000000)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (2000000 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
		 		 plusEgg('28,28,28,28,28,28',false,1,false,false,280,false);
		   		 minus_item(1,2000000);
		 	 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 9:
		   	 if(item_isset(1,2200000)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (2200000 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,359,false);
		 		 minus_item(1,2200000);
		   	 }else{
		 		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		  case 10:
		   	 if(item_isset(1,2500000)){
		 		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		   		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (2500000 шт.)';
		 		 $response['question'] = 'Спасибо за покупку!';
		   		 plusEgg('28,28,28,28,28,28',false,1,false,false,559,false);
		 		 minus_item(1,2500000);
		   	 }else{
				 $response['question'] = 'Недостаточно денег!';
		   	 }
		  break;
		    case 11:
		 	 if(item_isset(1,3000000)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (3000000 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,214,false);
		   		 minus_item(1,3000000);
			 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		    	case 12:
		 	 if(item_isset(1,4000000)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (4000000 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,355,false);
		   		 minus_item(1,4000000);
			 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		    	case 13:
		 	 if(item_isset(1,5000000)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (5000000 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,196,false);
		   		 minus_item(1,5000000);
			 }else{
		   		 $response['question'] = 'Недостаточно денег!';
		 	 }
		    break;
		    	case 14:
		 	 if(item_isset(1,10000000)){
		   		 $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		 		 $response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (10000000 шт.)';
		   		 $response['question'] = 'Спасибо за покупку!';
				 plusEgg('28,28,28,28,28,28',false,1,false,false,704,false);
		   		 minus_item(1,10000000);
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
