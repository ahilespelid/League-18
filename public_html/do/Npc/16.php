<? 
	$response['name'] = 'Эйс'; 
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}'; 
				$response['npc_id'] = 16;
			break; 
			default: 
				$response['question'] = 'Добрый день.'; 
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>16] 
				);
			break;
		}
?>