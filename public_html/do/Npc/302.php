<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Эльф';
	switch($npcStep){
		case 1:
			$response['question'] = 'Да, вот помощь бы не помешала. Я занимаюсь подготовкой новогодних оленей для повозки Деда мороза. Но одного #234 Сентлер не хватает. Сможешь принести его?';
			$response['answer'] = array(
				2 => "Да, конечно"
			);
		break;
		case 2:
			if(quest_step(21,4)){
				quest_update(21,5);
				$response['question'] = 'Учти, что покемон нужен с характером Выносливый, чтобы он смог преодолевать дальние расстояния <br> Вообщем, жду тебя тут. И побыстрее! Наградой не обижу.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			$allPokemons = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			if($allPokemons->num_rows < 2){
				$response['question'] = 'Если я заберу этого покемона, у тебя не останется покемонов с собой!';
			}else{
				if(quest_step(21,5)){
					$olen = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 234 AND `character` = 2")->num_rows;
					if($olen > 0 ){
						quest_update(21,6);
						$response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/234.gif">#234 Сентлер';
						$response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/427.gif">#427 Банири';
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 234 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$response['action'] = 'updateTeam';
						newPokemon(427,$_SESSION['id'],1,false,0,'true',1,false,false,false,false,false);
						$response['question'] = 'Огромное тебе спасибо, тренер! У меня для тебя есть подарок!У меня есть несколько символов нового года. Одного  я дарю тебе. Держи и еще раз спасибо тебе! Твой поступок мы не забудем. Обратись к Деду Морозу.';
					}else{
						$response['question'] = 'У тебя его нет!';
					}
				}else{
					$response['question'] = 'Ошибка!';
				}
			}
		break;
		default:
		if(quest_step(21,4)){
			$response['question'] = 'Привет, слушай, не мешай мне! У меня и так работы навалом, а тут еще и ты..';
			$response['answer'] = array(
				1 => "Может я смогу чем-то помочь?"
			);
		}else if(quest_step(21,5)){
			$response['question'] = 'Принес покемона? <br>В вашей команде должен  быть ТОЛЬКО ОДИН: <br> <b>#234 Сентлер</b> с характером <b>Выносливый</b>';
			$response['answer'] = array(
				3 => "Да, вот он"
			);
		}else{
			$response['question'] = 'Чем-то очень занят. Не стоит его отвлекать.';
		}
		break;
	}
?>
