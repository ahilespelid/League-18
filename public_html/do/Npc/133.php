<? 
	$response['name'] = 'Продавец';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}'; 
				$response['npc_id'] = 133; 
			break; 
			default: 
				$response['question'] = 'Добрый день. Купите у меня вкусняшек ^_^';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>133] 
				);
			break; 
		}
?>