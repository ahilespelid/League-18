<?
	$response['name'] = 'Работник банка';
		switch($npcStep){
			case 1:
				$response['question'] = '{{makasimka}}';
				$response['npc_id'] = 221;
			break;
			default:
				$response['question'] = 'Добро пожаловать в наш Банк! Я могу обменять драгоценные жемчужины на местную валюту! По курсу 1 жем. = 90 000 мон. Извини, больше не можем, комиссия.';
				$response['answer'] = array(
					'by' => ['title'=>'Купить предметы', 'npc_id'=>221]
				);
			break;
		}
?>
