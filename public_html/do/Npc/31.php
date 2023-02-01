<?
	$response['name'] = 'Торговец Мо';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 31;
			break;
			default: 
				$response['question'] = 'Добрый день, путник! Что привело тебя на эту чудесную поляну? Может ты хочешь купить у меня что-нибудь?';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>31]
				);
			break;
		}
?>