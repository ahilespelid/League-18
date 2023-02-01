<?
	$response['name'] = 'Мари';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 18;
			break;
			default: 
				$response['question'] = '<i>~Протирает банки с витаминами~</i>';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>18]
				);
			break;
		}
?>