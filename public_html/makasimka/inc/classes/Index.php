<?php
Class Index{

	private $mysqli;

	private $news = '';

	private $auth = '';

	public $online = 0;

	public $events = '';

	public $userRatings = array(
		'pvp' => '',
		'pokedex' => '',
		'shinedex' => '',
		'clan' => ''
	);

	public function __construct(mysqli $mysqli){
		$this->mysqli = $mysqli;

		#Вывод новостей
		$page = (isset($_GET['page']) ? clearInt(($_GET['page']-1)) : 0);
		$start = abs($page*10);
		$newsQuery = $mysqli->query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT ".$start.",10");
		$drazdo = $mysqli->query('SELECT * FROM `drazdo` ORDER BY `id` DESC LIMIT 10');
		while($drazdo1 = $drazdo->fetch_assoc()) {
			$user = $mysqli->query("SELECT * FROM `users` WHERE id = ".$drazdo1['user'])->fetch_assoc();
			$drazdo12 .= '<div class="Drazdo">
				<div class="Prize">'.$drazdo1['prize'].'</div>
				<div class="TrenBlock">
					<div class="Avatar" style="background-image: url(/img/avatars/mini/'.$drazdo1['user'].'.png);"></div>
					<div class="Text">
			    <div class="u-'.$user['user_group'].'">'.$user['login'].'</div>
			    <span>'.date('d.m.Y',$drazdo1['date']).'</span>
			  </div>
				</div>
			</div>';
		}
		$this->news .= '<div class="News">';
		while($news = $newsQuery->fetch_assoc()){
			$like = $mysqli->query("SELECT * FROM `likenews` WHERE `like` = 1 AND news = ".$news['id']);
			$user = json_decode($news['author']);
			$this->news .= '<div class="New">';
			$this->news .= '<div class="User">
              <div class="Avatar" style="background-image: url(/img/avatars/mini/'.$user->id.'.png);"></div>
              <div class="Text">
                <div class="Name u-'.$user->group.'">'.$user->login.'</div>
                <div class="Date">'.$news['date'].'</div>
              </div>
            </div>
						<div class="Text">'.$news['text'].'</div></div>';
        }
				$page = (isset($_GET['page']) ? ($_GET['page']) : 1);
				$nextPage = $page + 1;
				$prevPage = $page - 1;
		$this->news .= '<div class="Buttons">
		<a class="Left Button" href="/?page='.$prevPage.'">Раньше...</a>
		<a class="Right Button" href="/?page='.$nextPage.'">Позже...</a>
</div></div>
<div class="Other">';
if(isset($_SESSION['id'])){
	$autorize = true;
	$user = $mysqli->query("SELECT `id`,`login`,`user_group`,`rang` FROM `users` WHERE `id` = ".$_SESSION['id'])->fetch_assoc();
	if(file_exists($patch_project.'/img/avatars/mini/'.$_SESSION['id'].'.png')){
		$user['avatar'] = '/img/avatars/mini/'.$_SESSION['id'].'.png';
	}else{
		$user['avatar'] = '/img/avatars/mini/no-user-img.png';
	}
}else{
	$autorize = false;
}
if(!$autorize){
$this->auth .= '<div class="AuthError"></div><form onsubmit="sign();return false;" id="autorizeForm">
	<input type="text" id="uLogin" placeholder="Игровое имя">
	<input type="password" id="uPass" placeholder="Пароль">
	<button>Войти</button>
	<a href="#" onclick="newPass()">Забыл пароль</a>
</form>';
}else{
	$this->auth .= '<div class="User">
          <div class="TrenBlock">
            <div class="Avatar" style="background-image: url(/img/avatars/mini/'.$user['id'].'.png);"></div>
            <div class="Text">
              <div class="u-'.$user['user_group'].'">'.$user['login'].'</div>
              <span>'.$user['rang'].'</span>
            </div>
          </div>
        </div>
				<div class="Buttons">
          <a href="//'.DOMAIN.'/world">В игру</a>
          <a href="//'.DOMAIN.'/?route=exit">Выход</a>
        </div>';
}
$user1 = $mysqli->query("SELECT * FROM users ORDER BY pvp DESC")->fetch_assoc();
$user2 = $mysqli->query("SELECT * FROM users ORDER BY countNormal DESC")->fetch_assoc();
$user3 = $mysqli->query("SELECT * FROM base_clans ORDER BY rating DESC")->fetch_assoc();
$cl = json_decode($user3['info']);
$this->news .= '
<div class="Block">
            <div class="Name">
              Предстоящие события
            </div>
            <div class="Cnt">
						<a href="http://shadow741.beget.tech/" target="_blank" class="sob konk">
							<div class="Text">
								<div>[Турнир] 55 лвл, 6х6| 17.12.2022 17:00</div>
								<span>Призы: <img src=http://shadow741.beget.tech//img/pokemons/anim/normal/123.gif> #123 Сайтер <br>    <img src=http://shadow741.beget.tech//img/pokemons/anim/normal/213.gif> #213 Шакл <br> <img src=http://shadow741.beget.tech//img/pokemons/anim/normal/137.gif> #137 Поригон </span>
							</div>
						</a>
            </div>
            <div class="Cnt">
						<a href="http://shadow741.beget.tech/" target="_blank" class="sob konk">
							<div class="Text">
								<div>[Ивент] Новогодний квест| 26.12.2022 12:00</div>
							</div>
						</a>
            </div>
          </div>
					<div class="Block">
            <div class="Name">
              Рейтинг
            </div>
            <div class="Cnt">
              <div class="Rating Fight">
                <div class="Icon"><i class="fa fa-bolt"></i></div>
                <div class="Text">Самым лучшим бойцом в игре является тренер</div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/'.$user1['id'].'.png);"></div>
                  <div class="Text">
                    <div class="u-'.$user1['user_group'].'">'.$user1['login'].'</div>
                    <span>'.$user1['rang'].'</span>
                  </div>
                </div>
                <div class="Text">Данный тренер имеет PVP рейтинга: '.$user1['pvp'].' шт.</div>
              </div>
              <div class="Rating Dex">
                <div class="Icon"><i class="fa fa-paw"></i></div>
                <div class="Text">Самая большая коллекция покемонов принадлежит тренеру</div>
                <div class="TrenBlock">
									<div class="Avatar" style="background-image: url(/img/avatars/mini/'.$user2['id'].'.png);"></div>
									<div class="Text">
										<div class="u-'.$user2['user_group'].'">'.$user2['login'].'</div>
										<span>'.$user2['rang'].'</span>
									</div>
                </div>
                <div class="Text">Различных видов покемонов насчитывается аж '.$user2['countNormal'].' шт.</div>
              </div>
              <div class="Rating Clan">
                <div class="Icon"><i class="fa fa-bookmark"></i></div>
                <div class="Text">Самым боеспособным кланом в игре является</div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/world/clans/'.$user3['id'].'.png);"></div>
                  <div class="Text">
                    <div class="u-6">'.$cl->name.'</div>
                  </div>
                </div>
                <div class="Text">Данный клан имеет рейтинга: '.$user3['rating'].' шт.</div>
              </div>
            </div>
          </div>
					<div class="Block">
            <div class="Name">
              Награды за Токены
            </div>
            <div class="Cnt">
              '.$drazdo12.'
              <div class="InfoBlock">
                Некоторые люди любят собирать редкие Токены. Дом одного из таких коллекционеров находится в Маувилле (регион Хоэнн). За полный набор токенов он выдает неплохой приз.
              </div>
            </div>
          </div>
</div>';
		unset($newsQuery);

		#Запрашиваем количество онлайн игроков
		$timeOnline = time() - 300;
		$online = $mysqli->query('SELECT * FROM `users` WHERE `online` >= '.$timeOnline);
		$everd = $mysqli->query('SELECT `online` FROM `system` WHERE id = 1')->fetch_assoc();
		$this->online = $online->num_rows;
		$this->all = $everd['online'];

		#Апдейтим информацию о событиях
		$eventsQuery = $mysqli->query("SELECT * FROM `events` LIMIT 5");
		while($events = $eventsQuery->fetch_assoc()){
			$this->events = '<a href="'.$events['href'].'">'.$events['text'].'</a>';
		}
		unset($eventsQuery);
		$this->getUserRatings();
	}

	public function GetInfo(){
		if(isset($_GET['route']) && $_GET['route'] != 'exit'){
			require_once 'pages/'.$_GET['route'].'.php';
		}else{
			print $this->news;
		}
	}

	public function GetInfo1(){
		print $this->auth;
	}

	private function getUserRatings(){
		$ratings = $this->mysqli->query("SELECT `login`,`pvp` FROM `users` WHERE `user_group` != 1 AND `user_group` != 7 ORDER BY `pvp` DESC");
		$pokNormal = $this->mysqli->query("SELECT `login`,`countNormal` FROM `users` WHERE `user_group` != 1 AND `user_group` != 7 ORDER BY `countNormal` DESC");
		$pokShine = $this->mysqli->query("SELECT `login`,`countShine` FROM `users` WHERE `user_group` != 1 AND `user_group` != 7 ORDER BY `countShine` DESC");
		$pvpRatings = [];
		$poksNormalRatings = [];
		$poksShineRatings = [];
		$i = 0;
		while($ratingsArray = $ratings->fetch_assoc()){
			$pvpRatings[$ratingsArray['login']] = $ratingsArray['pvp'];
			$i++;
			if($i == 1)break;
		}
		$i = 0;
		while($pokNormalArray = $pokNormal->fetch_assoc()){
			$poksNormalRatings[$pokNormalArray['login']] = $pokNormalArray['countNormal'];
			$i++;
			if($i == 1)break;
		}
		$i = 0;
		while($pokShineArray = $pokShine->fetch_assoc()){
			$poksShineRatings[$pokShineArray['login']] = $pokShineArray['countShine'];
			$i++;
			if($i == 1)break;
		}
		#Сортируем и заносим данные в переменную
		#Рейтинг бойцов
		arsort($pvpRatings);
		$i=0;
		foreach($pvpRatings as $key=>$value){
			$pvpGroups = $this->mysqli->query("SELECT `id`,`user_group` FROM `users` WHERE `login` = '".$key."'")->fetch_assoc();
			$this->userRatings['pvp'].= '
			<div class="User">
			          <div class="Prize"><span>Место</span></div>
			          <div class="Avatar" style="background-image: url(/img/avatars/mini/'.$pvpGroups['id'].'.png);"></div>
			          <div class="Text">
			            <div class="u-'.$pvpGroups['user_group'].'">'.$key.'</div>
			            <span>'.$value.'</span>
			          </div>
			        </div>';
			$i++;
			if($i == 1)break;
		}
		#Рейтинг кланов
		$clans = $this->mysqli->query("SELECT * FROM `base_clans` ORDER BY `rating` DESC LIMIT 1");
		while($c = $clans->fetch_assoc()) {
			$cl = json_decode($c['info']);
			$this->userRatings['clan'].= '<div class="User">
			          <div class="Prize"><span>Место</span></div>
			          <div class="Avatar" style="background-image: url(/img/world/clans/'.$c['id'].'.png);"></div>
			          <div class="Text">
			            <div class="u-6">'.$cl->name.'</div>
			            <span>'.$c['rating'].'</span>
			          </div>
			        </div>';
		}
		#Рейтинг покедекса
		//arsort($poksNormalRatings);
		$i=0;
		foreach($poksNormalRatings as $key=>$value){
			$pvpGroups = $this->mysqli->query("SELECT `id`,`user_group` FROM `users` WHERE `login` = '".$key."'")->fetch_assoc();
			$this->userRatings['pokedex'].= '<div class="User">
			          <div class="Prize"><span>Место</span></div>
			          <div class="Avatar" style="background-image: url(/img/avatars/mini/'.$pvpGroups['id'].'.png);"></div>
			          <div class="Text">
			            <div class="u-'.$pvpGroups['user_group'].'">'.$key.'</div>
			            <span>'.$value.'</span>
			          </div>
			        </div>';
			$i++;
			if($i == 1)break;
		}
		#Рейтинг шайнидекса
		//arsort($poksShineRatings);
		$i=0;
		foreach($poksShineRatings as $key=>$value){
			$pvpGroups = $this->mysqli->query("SELECT `id`,`user_group` FROM `users` WHERE `login` = '".$key."'")->fetch_assoc();
			$this->userRatings['shinedex'].= '<div class="User">
			          <div class="Prize"><span>Место</span></div>
			          <div class="Avatar" style="background-image: url(/img/avatars/mini/'.$pvpGroups['id'].'.png);"></div>
			          <div class="Text">
			            <div class="u-'.$pvpGroups['user_group'].'">'.$key.'</div>
			            <span>'.$value.'</span>
			          </div>
			        </div>';
			$i++;
			if($i == 1)break;
		}
	}
}
