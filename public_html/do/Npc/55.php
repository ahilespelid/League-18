<?
	$response['name'] = 'Руководитель ярмарки';
	switch($npcStep){
		case 1:
			$response['question'] = 'Разноцветную пыль можно получить во всех аттракционах ярмарки, а также в других различных уголках этого острова.';
		break;
		default:
			$countAll = 0;
			$item = $mysqli->query("SELECT `count` FROM `items_users` WHERE `item_id` = 108");
			while($items = $item->fetch_assoc()){
				$countAll = $countAll+$items['count'];
			}
		$response['question'] = 'Доброго времени суток! На ярмарке можно развлечься и отдохнуть от приключений, да еще и призы получить! Видишь того парня в шляпе? Он обменяет твою <b>Разноцветную пыль</b> на ценные призы. А вон тот клоун может перекрасить твоего покемона в шайни.<br><br><b>Всего выбито Разноцветной пыли: '.$countAll.'</b>';
		$response['answer'] = array(
			1 => "Где мне взять Разноцветную пыль?"
		);
		break;
	}
?>