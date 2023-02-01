<?php
/* ~ Global Include ~ */
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $_SERVER['DOCUMENT_ROOT'].'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
    }
}
if($_GET['route'] === "registration") {
  $lol = 'Создание персонажа';
}elseif($_GET['route'] === "rules") {
  $lol = 'Правила';
}else{
  $lol = 'Последние новости';
}
if($_GET['route'] === 'exit'){
	unset($_SESSION['id']);
	unset($_SESSION['login']);
	header('Location: /');
}
/* END ~ Global Include ~ */
if(isset($_SESSION['id'])){
	$autorize = true;
	$user = $mysqli->query("SELECT `login`,`user_group`,`rang`,`lang` FROM `users` WHERE `id` = ".$_SESSION['id'])->fetch_assoc();
	if(file_exists($patch_project.'/img/tw.png'.$_SESSION['id'].'.png')){
		$user['avatar'] = '/img/tw.png'.$_SESSION['id'].'.png';
    $lang = $user['lang'];
  }else{
		$user['avatar'] = '/img/tw.png';
	}
}else{
  $lang = 'ru';
	$autorize = false;
}
$index = new Index($mysqli);
$page = (isset($_GET['page']) ? ($_GET['page']) : 1);
$nextPage = $page + 1;
$prevPage = $page - 1;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
		<title><?=PAGE_TITLE;?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="<?=PAGE_KEY;?>">
        <meta name="description" content="<?=PAGE_DESCRIPTION;?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="/img/icon.ico" type="image/x-icon">
		<link rel="icon" href="/img/icon.ico" type="image/x-icon">
		<link rel="stylesheet" href="/font-awesome/css/fontawesome-all.css?<?=microtime(true)?>">
		<link rel="stylesheet" href="/css/index.new.css?<?=microtime(true)?>">
	</head>
	<body id="body">
    <div class="TopMenu">
      <div class="Stats">
        <div class="Online">
          <div>100 <span>онлайн</span></div>
          <div>100 <span>за день</span></div>
        </div>
        <div class="Soc">
          <a href="#" class="vk"><i class="fab fa-vk"></i></a>
          <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
          <a href="#" class="twitch"><i class="fab fa-twitch"></i></a>
        </div>
      </div>
      <div class="hero-header-item hero-logo" aria-hidden="true">
        <div class="hero-logo-circles">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-red-semi-206422653d447e981744a5f5865e8225.svg" alt="Index portal red semi">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-red-9bff954009d893312ac619e31af14ae1.svg" alt="Index portal red">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-orange-semi-c671a2be2b56754be0c2fdf64244b1bb.svg" alt="Index portal orange semi">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-orange-4ba73231728c110e0fe16aba5194e92b.svg" alt="Index portal orange">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-yellow-semi-93c8853cbd3ebf297aead4efaf5a6ca3.svg" alt="Index portal yellow semi">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-yellow-1a0199e2dd6d8df832c4bbbda2b0392b.svg" alt="Index portal yellow">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-green-semi-dbb1db021647238b23d575ba492441e6.svg" alt="Index portal green semi">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-green-2c971eb899d32fa7bdb26fac8b1bedd7.svg" alt="Index portal green">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-blue-semi-c37d271ed0200999eed96db9a3d9ebef.svg" alt="Index portal blue semi">
          <img class="hero-logo-circle" src="https://github-atom-io-herokuapp-com.freetls.fastly.net/assets/index-portal-blue-c2e705932469b61cbb9ceb0b6b778e35.svg" alt="Index portal blue">
        </div>
      </div>
      <div class="InfoProject">
        <div class="Logo"></div>
        <div class="Name">League 18</div>
        <div class="About">Онлайн игра про покемонов</div>
      </div>
      <div class="Menu">
        <div class="Wrap">
          <a href="#">Главная</a>
          <a href="#">Регистрация</a>
          <a href="#">Правила</a>
          <a href="#">Форум</a>
          <a href="#">Помощь</a>
        </div>
      </div>
    </div>
    <div class="Auth">
      <div class="Wrap">
        <div class="User">
          <div class="TrenBlock">
            <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
            <div class="Text">
              <div class="u-1">AnarHeest</div>
              <span>Новичок</span>
            </div>
          </div>
        </div>
        <div class="Buttons">
          <a href="#">В игру</a>
          <a href="#">Выход</a>
        </div>
      </div>
    </div>
    <div class="Content">
      <div class="Wrap">
        <div class="Nav">
          <a href="..">Главная страница</a> <i class="fa fa-long-arrow-alt-right"></i> <span>Последние новости</span>
        </div>
        <div class="News">
          <div class="New">
            <div class="User">
              <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
              <div class="Text">
                <div class="Name u-1">AnarHeest</div>
                <div class="Date">20 февраля 2018</div>
              </div>
            </div>
            <div class="Text">
              <img src="http://aquaworldonline.ru/img/quests/19.png"> Петалбургский лес резко посетил жуткий холод. Все покемоны бегут прочь оттуда, не выдерживая такого адского мороза... Но не только покемоны пострадали! Марк из Фолларбора уже не один день грустно сидит на скамейке главной улицы города. Дело в том, что в этом злосчастном лесу он потерял свою подругу. Местные полицейские прочесали весь лес, но девушку так и не нашли. Возможно вы сможете помочь ему и отыскать пропавшую?
            </div>
          </div>
          <div class="New">
            <div class="User">
              <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
              <div class="Text">
                <div class="Name u-1">AnarHeest</div>
                <div class="Date">20 февраля 2018</div>
              </div>
            </div>
            <div class="Text">
              <img src="http://aquaworldonline.ru/img/quests/19.png"> Петалбургский лес резко посетил жуткий холод. Все покемоны бегут прочь оттуда, не выдерживая такого адского мороза... Но не только покемоны пострадали! Марк из Фолларбора уже не один день грустно сидит на скамейке главной улицы города. Дело в том, что в этом злосчастном лесу он потерял свою подругу. Местные полицейские прочесали весь лес, но девушку так и не нашли. Возможно вы сможете помочь ему и отыскать пропавшую?
            </div>
          </div>
          <div class="Buttons">
            <a href="" class="Left">Ранее</a>
            <a href="" class="Right">Позднее</a>
          </div>
        </div>
        <div class="Other">
          <div class="Block">
            <div class="Name">
              Предстоящие события
            </div>
            <div class="Cnt">
              <a href="#" class="sob trn">
                <div class="Text">
                  <div>Турнир для всех желающих на 1 ур.</div>
                  <span>20 февраля 2018</span>
                </div>
              </a>
              <a href="#" class="sob trn">
                <div class="Text">
                  <div>Турнир для всех желающих на 1 ур.</div>
                  <span>20 февраля 2018</span>
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
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
                <div class="Text">Данный тренер имеет PVP рейтинга: 1000 шт.</div>
              </div>
              <div class="Rating Dex">
                <div class="Icon"><i class="fa fa-paw"></i></div>
                <div class="Text">Самая большая коллекция покемонов пренадлежит тренеру</div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
                <div class="Text">Различных видов покемонов насчитывается аж 200 шт.</div>
              </div>
              <div class="Rating Clan">
                <div class="Icon"><i class="fa fa-bookmark"></i></div>
                <div class="Text">Самым боеспособным кланом в игре является</div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
                <div class="Text">Данный клан имеет рейтинга: 1000 шт.</div>
              </div>
            </div>
          </div>
          <div class="Block">
            <div class="Name">
              Награды за Значки Драз`до
            </div>
            <div class="Cnt">
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="Drazdo">
                <div class="Prize">#629 <span>Валлаби</span></div>
                <div class="TrenBlock">
                  <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
                  <div class="Text">
                    <div class="u-1">AnarHeest</div>
                    <span>18.10.2018</span>
                  </div>
                </div>
              </div>
              <div class="InfoBlock">
                Некоторые люди любят собирать редкие Значки Драз`до. Дом одного из таких коллекционеров находится в Маувилле (регион Хоэнн). За полный набор значков он выдает неплохой приз.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="Footer">
      <div class="Wrap">
        <div class="Left">
          <div class="Logo"></div>
          <div class="Text">AquaWorld © 2017</div>
        </div>
        <div class="Right">
          Покемоны, их имена, картинки, и связанные с ними названия являются торговыми марками: Gamefreak, Nintendo, The Pokémon Company Creatures Inc, а также их соответствующим дочерним компаниям.
        </div>
      </div>
    </div>





		<script src="/js/jquery/jquery.js?<?=$versionGame;?>" type="text/javascript"></script>
		<script src="/js/jquery/notify.js?<?=$versionGame;?>" type="text/javascript"></script>
		<script src="/js/index.js?<?=microtime(true)?>" type="text/javascript"></script>
    <script src="/js/jquery/notify.js?<?=$versionGame;?>" type="text/javascript"></script>
    <script src="/js/underscore.js?<?=$versionGame;?>" type="text/javascript"></script>
    <script src="/js/lang/<?=$lang;?>.js?<?=microtime(true)?>" type="text/javascript"></script>
		<script>
			const DOMAIN = '<?=DOMAIN_HTTP;?>';
      //w3.displayObject("body", Lang);
		</script>
	</body>
</html>
