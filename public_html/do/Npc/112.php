<? 
	$response['name'] = 'Продавец выпечки';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}'; 
				$response['npc_id'] = 112; 
			break; 
			default: 
				$response['question'] = '<i>~Грустно сидит за прилавком~</i>';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>112] 
				);
			break; 
		}
?>