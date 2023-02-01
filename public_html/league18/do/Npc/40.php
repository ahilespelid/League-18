<?
	$response['name'] = 'Фабиан';
	switch($npcStep){
		case 1:
			$response['question'] = '{{new}}';
			$response['type'] = 'fabian';
		break;
		case 2:
			$response['question'] = 'Значит, слушай.. <br>
			<b>Комната покемонов</b> - комната, в которой ты можешь испытать свою удачу. Угадай одного из трех покемонов, которых покажет наш компьютер. Все покемоны выбираются случайно, но одного из этих покемонов выбрал компьютер, его и нужно угадать. Получай жетоны за правильно угаданного покемона. Комната работает с 10:00 по 12:00 и с 18:00 по 20:00.
			<br><b>Комната чемпионов</b> - комната, в которой нужно делать ставки на участников самого главного турнира игры - Кубка Морских Глубин. Угадаешь победителя - получишь жетоны. Комната работает только в дни проведения КМГ.
			<br><b>Лотерейная комната</b> - комната, в которой проходят лотереи. Покупай лотерейные билеты и получи шанс выиграть жетоны. Подробности узнаешь уже в самой комнате. Комната работает всегда.
			<br><b>Темная комната</b> - комната, в которой ты должен будешь найти ценный предмет, но не все так просто.. У тебя изымут всех покемонов и выдадут одного специального покемона, у которого будет в общей сумме 50 PP. Тебе надо будет постараться выбить редкий предмет, который можно обменять на жетоны у специального аппарата, находящегося в комнате. Комната работает всегда.
			';
		break;
		default:
			$response['question'] = 'Добро пожаловать в наш игровой центр. У меня можно обменять <div class="itemIsset" onclick="issetAll(94,\'item\')" style="background-image: url(/img/world/items/little/94.png)"></div> Игровые жетоны на различные призы. Так же я могу ответить на любой интересующий тебя вопрос о игровых комнатах. Смело задавай.<br><b>Жетоны обнуляются в понедельник в 18:00.</b>';
			$response['answer'] = array(
				 1 => "Я хочу обменять игровые жетоны на призы",
				 2 => "Расскажите мне о всех игровых комнатах"
			);
		break;
	}
?>