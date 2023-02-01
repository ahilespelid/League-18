<?
	$response['name'] = 'Продавец';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 181;
			break;
			default:
				$response['question'] = 'Добро пожаловать в Покемаркет!';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>181]
				);
			break;
		}
?>
