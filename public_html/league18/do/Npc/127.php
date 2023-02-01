<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';

	$response['name'] = 'Воришка';
	switch($npcStep){
		default:
		$response['question'] = 'Товаров пока нет...';
		//$response['question'] = 'Новый день - новые товары, дружище! Не спрашивай где я их достал, главное они есть. Разбирай!';
		//$response['answer'] = array(
		//	'by' => ['title'=>'Ну давай, показывай, что есть', 'npc_id'=>127]
		//);
		break;
	}
?>
