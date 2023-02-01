<?
	$response['name'] = 'Старый рыбак';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 38;
			break;
			default: 
				$response['question'] = 'Добро пожаловать. Что вас интересует?';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>38]
				);
			break;
		}
?>