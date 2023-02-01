<? 
	$response['name'] = 'Анастасия';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}'; 
				$response['npc_id'] = 106; 
			break; 
			default: 
				$response['question'] = '<i>~Увлеченно читает какую-то брошюру~</i> О! Добрый день.';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>106] 
				);
			break; 
		}
?>