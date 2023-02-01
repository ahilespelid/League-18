<?
	$response['name'] = 'Анна';
	 switch($npcStep){
     case 1:
       $fish = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 458")->fetch_assoc();
       if($fish) {
         $rand = mt_rand(5,10);
         $response['question'] = 'Какая милая! ^_^';
         $response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/458.gif"> #458 Мантайк';
         $response['actionQuestPlus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль ('.$rand.' шт.)';
         itemAdd(108,$rand);
         $mysqli->query("DELETE FROM `user_pokemons` WHERE `id` = ".$fish['id']);
      }else{
         $response['question'] = 'У тебя нет рыбок с собой.';
       }
     break;
	 	default:
	 	$response['question'] = 'Привет. В Аквариуме никого нельзя поймать на обычный покебол. Разрешается лишь Сачок! Купить его можно у меня. За каждую рыбку, пойманную этим сачком, я буду давать тебе разноцветную пыль! Ах, да, чуть не забыла, Сачок ловит покемона 50 на 50. Ни какие прочие эффекты на него не действуют!<br><i>~Персонаж сам берет покемона по его ID от меньшего к большему.~</i>';
	 	$response['answer'] = array(
	 		'by' => ['title'=>'Купить предметы', 'npc_id'=>150],
	 		1 => "Отдать рыбку"
	 	);
	 	break;
	 }
	//switch($npcStep){
		//default:
			//$response['question'] = 'Аттракцион больше не работает. Ярмарка закрыта.';
		//break;
	//}
?>
