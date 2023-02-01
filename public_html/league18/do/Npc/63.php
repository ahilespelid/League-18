<?php
	$response['name'] = 'Колесо';
	// switch($npcStep){
		// case 1:
			// if(item_isset(108,10)){
				// $rand = rand(1,100);
				// if($rand >= 6 && $rand <= 99){
					// $rand1 = rand(1,100);
					// if($rand1 <= 15){
						// itemAdd(108,15);
						// $response['question'] = 'Ваш выигрыш:<br><b>Разноцветная пыль (15 шт.)</b>';
						// $response['answer'] = array(
							// 1 => "Крутить колесо"
						// );
					// }elseif($rand1 >= 16 && $rand1 <= 40){
						// $response['question'] = 'Вы ничего не выиграли';
						// $response['answer'] = array(
							// 1 => "Крутить колесо"
						// );
					// }elseif($rand1 >= 41 && $rand1 <= 70){
						// itemAdd(108,5);
						// $response['question'] = 'Ваш выигрыш:<br><b>Разноцветная пыль (5 шт.)</b>';
						// $response['answer'] = array(
							// 1 => "Крутить колесо"
						// );
					// }else{
						// itemAdd(108,9);
						// $response['question'] = 'Ваш выигрыш:<br><b>Разноцветная пыль (9 шт.)</b>';
						// $response['answer'] = array(
							// 1 => "Крутить колесо"
						// );
					// }
				// }elseif($rand == 100){
					// $response['question'] = 'Ваш выигрыш:<br><b>Набор классификаций (1 шт.)</b>';
					// itemAdd(95,1);
				// }else{
					// $response['question'] = '<b>ДЖЕКПОТ! Вы получаете 50 Разноцветной пыли!</b>';
					// itemAdd(108,50);
					// $response['answer'] = array(
						// 1 => "Крутить колесо"
					// );
				// }
				// minus_item(108,10);
			// }else{
				// $response['question'] = 'Недостаточно Разноцветной пыли.';
			// }
		// break;
		// default:
				// $response['question'] = 'Одна прокрутка колеса = 10 Разноцветной пыли. Выпасть может 0, 5, 9, 15 пыли. Шнас сорвать джекпот в 50 пыли = 5%. Также есть шанс получить <b>Набор классификаций</b> с шансом около 1%.';
				// $response['answer'] = array(
					// 1 => "Крутить колесо"
				// );
		// break;
	// }
	switch($npcStep){
		default:
			$response['question'] = 'Аттракцион больше не работает. Ярмарка закрыта.';
		break;
	}
?>
