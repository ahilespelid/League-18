<? 
	$response['name'] = 'Хозяин мастерской'; 
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}'; 
				$response['npc_id'] = 108; 
			break; 
			default: 
				$response['question'] = 'Привет. Нужна мастерская? Пользуйся! Я разрешаю. Но будь осторожен.';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>108] 
				);
			break; 
		}
?>