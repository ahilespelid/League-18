<? 
	$response['name'] = 'Дэн'; 
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}'; 
				$response['npc_id'] = 15; 
			break; 
			default: 
				$response['question'] = 'Добрый день.'; 
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>15] 
				);
			break; 
		}
?>