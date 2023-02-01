<?
	$response['name'] = 'Продавец тренировочных машин';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 144;
			break;
			default:
				$response['question'] = 'Привет. Я продаю различные тренировочные машины. Не желаешь купить?';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>144]
				);
			break;
		}
?>
