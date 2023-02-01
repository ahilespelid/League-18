<?
	$response['name'] = 'Полоса препятствий';
	$wait = time()+1800;
	switch($npcStep){
		case 1:
			if(quest_step(2318,1)){
				if(!npc_time_check($npcId)){
					$response['question'] = 'Перед вами стена, через которую можно пролезть. Есть несколько вариантов ее пройти. Какой из вариантов вы выберите?';
					$response['answer'] = array(
						101 => "Перелезть стену",
						102 => "Прорыть яму под стеной, чтобы переползти на другую сторону"
					);
				}
			}
		break;
		case 101:
			if(quest_step(2318,1)){
				if(!npc_time_check($npcId)){
					if(mt_rand(1,2) == 1){
						quest_update(2318,2);
						$response['question'] = 'Казалось бы, огромная стена, но вы ее осилили. Первое испытание позади.<br>На вашем пути два Чармандера, дышащие огненным пламенем. Необходимо как-то пройти через них, при этом не обжечься. Что вы предпримите?';
						$response['answer'] = array(
							201 => "Пробежать через огненное пламя",
							202 => "Отвлечь Чармандеров, кинув небольшой камень за их спины"
						);
					}else{
						$response['question'] = 'Вы... просто... упали. Ничего страшного, продолжить испытания можно через 30 минут.';
						$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					}	
				}
			}
		break;
		case 102:
			if(quest_step(2318,1)){
				if(!npc_time_check($npcId)){
					if(mt_rand(1,2) == 1){
						quest_update(2318,2);
						$response['question'] = 'Вам удалось прокопать небольшой тоннель и проползти через него. Удивительно. Первое испытание позади.<br>На вашем пути два Чармандера, дышащие огненным пламенем. Необходимо как-то пройти через них, при этом не обжечься. Что вы предпримите?';
						$response['answer'] = array(
							201 => "Пробежать через огненное пламя",
							202 => "Отвлечь Чармандеров, кинув небольшой камень за их спины"
						);
					}else{
						$response['question'] = 'Большое количество песка упало на вас, вы ели выбрались назад... Вам не удалось прорыть тоннель на другую сторону. Испытание можно будет продолжить через 30 минут.';
						$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					}
				}
			}
		break;
		case 201:
			if(quest_step(2318,2)){
				if(!npc_time_check($npcId)){
					if(mt_rand(1,2) == 1){
						quest_update(2318,3);
						$response['question'] = 'Вы едва не поджарились, но благодаря вашей храбрости, вы прошли второе испытание.<br>Перед вами опасный лабиринт с многочисленными ловушками. Решитесь ли вы его пройти?';
						$response['answer'] = array(
							301 => "Пройти лабиринт",
							302 => "Привлечь внимание Чармандеров из прошлого испытания, чтобы они разрушили лабиринт своим огнем..."
						);
					}else{
						$response['question'] = 'Вас окутал страх перед огнем... Вы не решились этого делать...<br>Соберитесь! Возвращайтесь через 30 минут, может быть страх пропадет.';
						$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					}	
				}
			}
		break;
		case 202:
			if(quest_step(2318,2)){
				if(!npc_time_check($npcId)){
					if(mt_rand(1,2) == 1){
						quest_update(2318,3);
						$response['question'] = 'Чармандеры отвлеклись на камень, и вы пробежали мимо них. Второе испытание пройдено!<br>Перед вами опасный лабиринт с многочисленными ловушками. Решитесь ли вы его пройти?';
						$response['answer'] = array(
							301 => "Пройти лабиринт",
							302 => "Привлечь внимание Чармандеров из прошлого испытания, чтобы они разрушили лабиринт своим огнем..."
						);
					}else{
						$response['question'] = 'Чармандеры заметили вас и побежали в вашу сторону. Вы начали убегать от них и удачно выбежали за пределы поля испытаний. Продолжить испытания можно через 30 минут.';
						$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					}
				}
			}
		break;
		case 301:
			if(quest_step(2318,3)){
				if(!npc_time_check($npcId)){
					if(mt_rand(1,2) == 1){
						quest_update(2318,4);
						Work::_itemPlus(95,3);
						$response['question'] = 'Вы успешно прошли лабиринт. Это было последнее испытание, организаторы дарят вам <div class="itemIsset" onclick="issetAll(95,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> (3 шт.) и благодарят вас за участие.';
					}else{
						$response['question'] = 'Вы заблудились в лабиринте. Вас спасли спасатели Военного Городка. Через 30 минут можно будет вновь вернуться к испытаниям.';
						$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					}
				}
			}
		break;
		case 302:
			if(quest_step(2318,3)){
				if(!npc_time_check($npcId)){
					if(mt_rand(1,2) == 1){
						quest_update(2318,4);
						Work::_itemPlus(95,3);
						$response['question'] = 'Лабиринт уничтожен огнем Чармандеров... Вы использовали смекалку и прошли испытание. Это было последнее испытание, организаторы дарят вам <div class="itemIsset" onclick="issetAll(95,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> (3 шт.) и благодарят вас за участие.';
					}else{
						$response['question'] = 'Чармандеры погнались за вами. Вы попытались направить их пламя на лабиринт, но все бестолку. Необходимо было отступать... Испытание можно будет пройти снова через 30 минут.';
						$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					}
				}
			}
		break;
		default:
		if(!quest_isset(2318)){
			quest_update(2318,1);
			$response['question'] = 'Перед вами огромное поле с различными препятствиями. Пройдя их, вы получите приз. Положитесь на свою храбрость и интуицию!';
			$response['answer'] = array(
				1 => "Пройти первое препятствие"
			);
		}elseif(quest_step(2318,1)){
			if(!npc_time_check($npcId)){
				$mysqli->query('DELETE FROM `base_npc_data` WHERE `userID` = '.$_SESSION['id'].' AND `npcID` = '.$npcId);
				$response['question'] = 'Перед вами стена, через которую можно пролезть. Есть несколько вариантов ее пройти. Какой из вариантов вы выберите?';
				$response['answer'] = array(
					101 => "Перелезть стену",
					102 => "Прорыть яму под стеной, чтобы переползти на другую сторону"
				);
			}else{
				$response['question'] = '30 минут еще не прошли. Возвращайтесь позже.';
			}
		}elseif(quest_step(2318,2)){
			if(!npc_time_check($npcId)){
				$mysqli->query('DELETE FROM `base_npc_data` WHERE `userID` = '.$_SESSION['id'].' AND `npcID` = '.$npcId);
				$response['question'] = 'На вашем пути два Чармандера, дышащие огненным пламенем. Необходимо как-то пройти через них, при этом не обжечься. Что вы предпримите?';
				$response['answer'] = array(
					201 => "Пробежать через огненное пламя",
					202 => "Отвлечь Чармандеров, кинув небольшой камень за их спины"
				);
			}else{
				$response['question'] = '30 минут еще не прошли. Возвращайтесь позже.';
			}
		}elseif(quest_step(2318,3)){
			if(!npc_time_check($npcId)){
				$mysqli->query('DELETE FROM `base_npc_data` WHERE `userID` = '.$_SESSION['id'].' AND `npcID` = '.$npcId);
				$response['question'] = 'Перед вами опасный лабиринт с многочисленными ловушками. Решитесь ли вы его пройти?';
				$response['answer'] = array(
					301 => "Пройти лабиринт",
					302 => "Привлечь внимание Чармандеров из прошлого испытания, чтобы они разрушили лабиринт своим огнем..."
				);
			}else{
				$response['question'] = '30 минут еще не прошли. Возвращайтесь позже.';
			}
		}else{
			$response['question'] = 'Испытание уже пройдено вами.';
		}
		break;
	}
?>