<? 
	$response['name'] = 'Флорист'; 
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 122; 
			break; 
			case 10:
				if(item_isset(167,60)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,170,true);
					minus_item(167,60);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 11:
				if(item_isset(167,60)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,684,true);
					minus_item(167,60);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 12:
				if(item_isset(167,40)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,211,true);
					minus_item(167,40);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 13:
				if(item_isset(167,150)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,123,true);
					minus_item(167,150);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 14:
				if(item_isset(167,200)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,449,true);
					minus_item(167,200);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 15:
				if(item_isset(167,150)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,328,true);
					minus_item(167,150);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 16:
				if(item_isset(167,60)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,307,true);
					minus_item(167,60);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 17:
				if(item_isset(167,200)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,451,true);
					minus_item(167,200);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 18:
				if(item_isset(167,60)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,54,true);
					minus_item(167,60);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 19:
				if(item_isset(167,150)){
					$response['question'] = 'Спасибо за обмен!';
					plusEgg(false,false,true,false,false,213,true);
					minus_item(167,150);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break;
			case 20:
				if(item_isset(167,100)){
					$rand = rand(1,5);
					if($rand == 1){
						$response['question'] = 'Тебе выпало яйцо <b>#010 Катерпи</b>.';
						plusEgg(false,false,true,false,false,10,true);
					}elseif($rand == 2){
						$response['question'] = 'Тебе выпало яйцо <b>#370 Лавдиск</b>.';
						plusEgg(false,false,true,false,false,370,true);
					}elseif($rand == 3){
						$response['question'] = 'Тебе выпало яйцо <b>#585 Дирлинг</b>.';
						plusEgg(false,false,true,false,false,585,true);
					}elseif($rand == 4){
						$response['question'] = 'Тебе выпало яйцо <b>#517 Мунна</b>.';
						plusEgg(false,false,true,false,false,517,true);
					}else{
						$response['question'] = 'Тебе выпало яйцо <b>#669 Флабэбэ</b>.';
						plusEgg(false,false,true,false,false,669,true);
					}
					minus_item(167,100);
				}else{
					$response['question'] = 'Не хватает больших букетов.';
				}
			break; 
			case 2:
				$response['question'] = '
				Яйца покемонов:
				<br><br><b>По 40 больших букетов:</b>
				<br><img src="/img/pokemons/anim/normal/211.gif"> #211 Квилфиш <a href="#" onclick="NpcDialog(122,12,event);">Купить...</a>
				<br><br><b>По 60 больших букетов:</b>
				<br><img src="/img/pokemons/anim/normal/54.gif"> #054 Псидак <a href="#" onclick="NpcDialog(122,18,event);">Купить...</a>
				<br><img src="/img/pokemons/anim/normal/170.gif"> #170 Чинчоу <a href="#" onclick="NpcDialog(122,10,event);">Купить...</a>
				<br><img src="/img/pokemons/anim/normal/684.gif"> #684 Свирликс <a href="#" onclick="NpcDialog(122,11,event);">Купить...</a>
				<br><img src="/img/pokemons/anim/normal/307.gif"> #307 Медитайт <a href="#" onclick="NpcDialog(122,16,event);">Купить...</a>
				<br><br><b>По 150 больших букетов:</b>
				<br><img src="/img/pokemons/anim/normal/123.gif"> #123 Сайтер <a href="#" onclick="NpcDialog(122,13,event);">Купить...</a>
				<br><img src="/img/pokemons/anim/normal/213.gif"> #213 Шакл <a href="#" onclick="NpcDialog(122,19,event);">Купить...</a>
				<br><img src="/img/pokemons/anim/normal/328.gif"> #328 Трапинч <a href="#" onclick="NpcDialog(122,15,event);">Купить...</a>
				<br><br><b>По 200 больших букетов:</b>
				<br><img src="/img/pokemons/anim/normal/449.gif"> #449 Гиппопотас <a href="#" onclick="NpcDialog(122,14,event);">Купить...</a>
				<br><img src="/img/pokemons/anim/normal/451.gif"> #451 Скорупи <a href="#" onclick="NpcDialog(122,17,event);">Купить...</a>
				<br><br><b>100 больших букетов - случайное яйцо из списка:</b>
				<br><img src="/img/pokemons/anim/normal/10.gif"> #010 Катерпи
				<br><img src="/img/pokemons/anim/normal/370.gif"> #370 Лавдиск
				<br><img src="/img/pokemons/anim/normal/585.gif"> #585 Дирлинг
				<br><img src="/img/pokemons/anim/normal/517.gif"> #517 Мунна
				<br><img src="/img/pokemons/anim/normal/669.gif"> #669 Флабэбэ
				<br><a href="#" onclick="NpcDialog(122,20,event);">Купить...</a>
				<br><br>После вылупления спаренные, непередаваемые, гены 25-30, уникальный окрас.
				'; 
			break; 
			default: 
				$response['question'] = 'Доброго времени суток! Не желаете приобрести чего-нибудь за букетики? Уж очень люблю цветы...'; 
				$response['answer'] = array(
					'by' => ['title'=>'Обменять букеты на предметы', 'npc_id'=>122],
					2 => 'Обменять букеты на яйца покемонов'
				);
			break; 
		}
?>