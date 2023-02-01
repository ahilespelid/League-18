<?
	$response['name'] = 'Хозяин Сада';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 143;
			break;
			default:
				$response['question'] = 'Привет. Эх, никому уже не нужны Априкорны. В наше время всё так сложно...';
				$response['answer'] = array(
					'by' => ['title'=>'Я как - раз за этим!', 'npc_id'=>143]
				);
			break;
		}
?>
