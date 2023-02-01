<?
	$response['name'] = 'Продавец супермаркета';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 146;
			break;
			default:
				$response['question'] = 'Добро пожаловать в наш супермаркет!'; 
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>146]
				);
			break;
		}
?>
