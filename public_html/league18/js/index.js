// New

var Index = {
  news: {
    likeNews: function(id) {
      $.ajax({
  		url: '/do/likeNews',
  		type: 'POST',
  		data: 'id=' + id,
  		success: function(data) {
  			data = JSON.parse(data);
        $('#likenew-id'+id).html('<i class="fa fa-heart"></i> '+data.like);
  		}
      });
    }
  }
}

// New end

function forgot() {
  var mail = $('#uEmail');
  $.ajax({
  url: '/do/forgot',
  type: 'POST',
  data: 'mail=' + mail.val(),
  beforeSend: function(){
    $('#forgotForm').css('display','none');
    $('#forgotForm').prepend('<img src="/img/loader/loader.gif" height="80" />');
  },
  success: function(data) {
    $('#forgotForm img').remove();
    $('#forgotForm').css('display','block');
    data = JSON.parse(data);
    if (data['error'] == 1) {
      $('.AuthError').html($.notify(data['text']));
    } else {
      $('.AuthError').remove();
      $('#autorizeForm').remove();
      $('.Auth a').remove();
      var tpl = '<div class="AuthNow">Новый пароль выслан на почту.</div>';
      $('.Auth').html(tpl);
    }
  }
  });
}
function sign() {
    var login = $('#uLogin');
    var password = $('#uPass');
    $.ajax({
		url: '/do/sign',
		type: 'POST',
		data: 'login=' + login.val() + '&password=' + password.val(),
		beforeSend: function(){
			$('#autorizeForm').css('display','none');
			$('#autorizeForm').prepend('<img src="/img/loader/loader.gif" height="80" />');
		},
		success: function(data) {
			$('#autorizeForm img').remove();
			$('#autorizeForm').css('display','block');
			data = JSON.parse(data);
			if (data['error'] == 1) {
				$('.AuthError').html($.notify(data['text']));
			} else {
				$('.AuthError').remove();
				$('#autorizeForm').remove();
				$('.Auth a').remove();
				var tpl = '<div class="Wrap"><div class="User"><div class="TrenBlock"><div class="Avatar" style="background-image: url(/img/avatars/mini/'+data['text'][3]+'.png);"></div> <div class="Text"><div class="u-'+data['text'][1]+'">'+data['text'][0]+'</div> <span>'+data['text'][2]+'</span> </div> </div> </div> <div class="Buttons"><a href="' + DOMAIN + '/world">В игру</a> <a href="' + DOMAIN + '/?route=exit">Выход</a></div></div>';
				$('.LeftMenu .Text div').attr('class', 'u-' + data['text'][1]).html(data['text'][0]);
				$('.LeftMenu .Text span').html(data['text'][2]);
				$('.LeftMenu .Avatar').attr('style','background-image: url(/img/avatars/mini/'+data['text'][3]+'.png);');
				$('.Auth').html(tpl);
			}
		}
    });
}

function newPass() {
  $('.Auth').html('<div class="Wrap"><div class="AuthError"></div><form onsubmit="forgot();return false;" id="autorizeForm"><input type="text" id="uEmail" placeholder="Электронная почта"> <button>Прислать новый пароль</button> <a href="#" onclick="backAuth()">Назад к авторизации</a></form></div>');
}
function backAuth() {
  $('.Auth').html('<div class="Wrap"><div class="AuthError"></div><form onsubmit="sign();return false;" id="forgotForm"><input type="text" id="uLogin" placeholder="Игровое имя"> <input type="password" id="uPass" placeholder="Пароль"> <button>Войти</button> <a href="#" onclick="newPass()">Забыл пароль</a></form></div>');
}

function registration() {
    var login, password, dblPassword, mail, avatar;
    login = $('#regLogin');
    password = $('#regPass');
    dblPassword = $('#regDblPass');
    mail = $('#regMail');
    var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
    if (login.val() == '') {
        return login.notify("Введите логин!");
    } else if (login.val().length < 4 || login.val().length > 16) {
        return login.notify("Длина логина должна быть не менее 4 и не более 16 символов!");
    } else if (password.val() == '') {
        return password.notify("Введите пароль!");
    } else if (password.val().length < 6 || password.val().length > 20) {
        return password.notify("Длина пароля должна быть не менее 6 и не более 20 символов!");
    } else if (dblPassword.val() == '') {
        return dblPassword.notify("Повторите пароль!");
    } else if (password.val() != dblPassword.val()) {
        return dblPassword.notify("Пароли не совпадают!");
    } else if (mail.val() == '') {
        return mail.notify("Введите почту!");
    } else if (!pattern.test(mail.val())) {
        return mail.notify("Введите коректную почту!");
    } else {
		var gender = ($('#GenderDiv').attr('data-patch') == 'm' ? 'm' : 'f');
        $.ajax({
            url: '/do/registration',
            type: 'POST',
            data: 'login=' + login.val() + '&password=' + password.val() + '&mail=' + mail.val() + '&gender=' + gender,
            success: function(data) {
                data = JSON.parse(data);
                if (data['error'] == 1) {
					alert(data['text']);
                } else {
                    $('.Inputs').html('<div class="Thx">Благодарим за регистрацию, тренер <div class="u-6">'+data['text']+'</div>. Если вы впервые играете в подобные игры, вам следует ознакомиться с <a href="http://leagueonline.forum2.net/viewtopic.php?id=139" traget="_blank">Пособием для начинающих</a>. Удачной и веселой игры!</div>');
                }
            }
        });
    }
}

function editGender(g){
	var a = ($('#GenderDiv').attr('data-patch') == 'm' ? 'f' : 'm');
	var b = (a == 'm' ? 'Мужской' : 'Женский');
	$('#GenderDiv').attr('data-patch',a).html(b);
}

function init(){
	var $ = document;

}
