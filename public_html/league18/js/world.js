var mainLoader = '<img height="80px" src="/img/loader/loader.gif" class="imgLoader">',
    closeGame = false,
    isTrade = false,
    ClassTrade = null,
    ClassBattle = null,
    assault = false,
    UserPokList = [],
    UserPokedex = null,
    md5locList = '',
    battleInfoRage = 0;
  

var Aqua = {
  struct: {
    preloader: $('.preloader'),
    locationPreLoader: $('#locationPreloader')
    //model: $('<div />', {'class': 'model'})
  },
  notifications: {
    mainAlert: function() {
      Game.notifications.main('Неверный запрос!', 'error');
    }
  },
  modals: {
    creating: {
      model: function(name) {
        $('.model').remove();
  			$('<div />', {
  				'class':'model'
  			}).appendTo('body');
        $('<div />', {
  				'class':'header',
          'id': 'drgModel',
  				html: name
  			}).appendTo('.model');
        $('<span />', {
  				html: '<i class="fa fa-close"></i>',
          click: function() {
            $('.model').remove();
          }
  			}).appendTo('.model .header');
        $('<div />', {
  				'class':'content-model',
          html: mainLoader
  			}).appendTo('.model');
        $('.model').draggabilly({
          handle: '#drgModel',
          containment: true
        });
      }
    }
  },
  users: {
    edit: {
      open: function() {
        alert(123);
      },
      redact: function(type, val = false) {
        switch(type){
          case 'pass':
            var oldPass = $('#oldPass').val(),
                newPass = $('#newPass').val(),
                dblNewPass = $('#dblNewPass').val();
            if(oldPass.length != 0 || newPass.length != 0 || dblNewPass.length != 0) {
              val = [oldPass, newPass, dblNewPass];
            }else{
              val = 2;
            }
          break;
          case 'audio':
            val = (val ? [val] : [2]);
          break;
          case 'team':
            val = (val ? [val] : [2]);
          break;
          case 'color':
            val = (val ? [val] : [100]);
          break;
        }
        if(type && val) {
          $.ajax({
            url: "/do/aqua",
            type: "POST",
            data: {
                id: 'edit',
                type: type,
                val: val
            },
            success: function (response){
              response = JSON.parse(response);
              if(response.error == 1) {
                Game.notifications.main(response.text,"error");
              }else{
                settings();
                Game.notifications.main("Изменения прошли успешно.","success");
              }
            }
          });
        }else{
          Aqua.notifications.mainAlert();
        }
      }
    }
  },
  loaders: {
    main: function(a) {
			Aqua.struct.preloader.find('span').html(a);
			Aqua.struct.locationPreLoader.delay(500).fadeOut(200);
    }
  },
  autoLoad: function() {
    Aqua.loaders.main('');
  }
}







function editStatus(t,e,s){!t?$("#statusUser").html('<textarea type="text" value="'+s+'" onkeydown="if(event.keyCode == 13){editStatus(\'status\',$(this).val());}" />'):$.ajax({url:"/do/trainers",type:"POST",data:{type:t,value:e},
success:function(t){
  t=JSON.parse(t),
  $("#statusUser").html("<div class='Text'>"+t.text+"</div><div class='Pen' onclick=editStatus(false,false,"+t.text+");><i class='fa fa-pen-square'</div>")
}
})
}
document.onkeydown = function(e) {
  if(e.keyCode == 27) {
    if($('.DivNotification').html() != '') {
      $('.DivNotification .noty').remove();
    }else{
      closeModal();
    }
    return false;
  }
  if((e.altKey && e.keyCode == 'P'.charCodeAt(0))) {
    Game.modals.pokemons();
  }
  if((e.altKey && e.keyCode == 'I'.charCodeAt(0))) {
    Game.modals.inventory('all');
  }
  if((e.altKey && e.keyCode == 'C'.charCodeAt(0))) {
    openModal('craft');
  }
  if((e.altKey && e.keyCode == 'T'.charCodeAt(0))) {
    openModal('trainers');
  }
  if((e.altKey && e.keyCode == 'A'.charCodeAt(0))) {
    Game.modals.diary('quests');
  }
}
$(document).mouseup(function (e) {
    var container = $(".window.pokeInfo");
    if (container.has(e.target).length === 0){
        container.hide();
    }
});
$(document).mouseup(function (e) {
    var container = $(".BlockOtherContent");
    if (container.has(e.target).length === 0){
        container.hide();
    }
});
$(document).mouseup(function (e) {
    var container = $(".smileList");
    if (container.has(e.target).length === 0){
        container.hide();
    }
});
$(document).mouseup(function (e) {
    var container = $(".tooltip");
    if (container.has(e.target).length === 0){
        container.hide();
    }
});
$(document).mouseup(function (e) {
    var container = $(".MiniModal");
    if (container.has(e.target).length === 0){
        container.remove();
    }
});
$(document).on('click', '.GiveDiv .wrap .PokList .PokBtn', function(e) {
  var container = $(".GiveDiv");
  container.remove();
});
$(document).mouseup(function (e) {
    var container = $(".GiveDiv");
    if (container.has(e.target).length === 0){
      container.remove();
    }
});
$(document).mouseup(function (e) {
    var container = $(".TrainerGive");
    if (container.has(e.target).length === 0){
      container.remove();
    }
});
function market_go(id,type,val=false) {
  if(type == 'stavka_item') {
    $('<div />', {
      "class": 'MiniModal',
      html: '<div class="Name" id="drgMini">Добавить лот</div><div class="Content"><div class="Settings"><center><b>Внимание, прочитайте!</b><br> За каждый лот вы платите 10.000 монет.<br>Введите значения <b>через запятую без пробелов</b> (Сначала начальную цену, затем количество предметов, затем цену шага, затем цену выкупа (если хотите без выкупа, то ставьте значение <b>0</b>), затем срок в днях).</center><div class="Step"><input placeholder="Начальная цена, кол-во, шаг, выкуп, срок" onkeydown="if(event.keyCode == 13){market_go('+id+',\'stavka_item_go\',$(this).val());}"></div></div></div>'
      }).appendTo('body');
    $('.MiniModal').draggabilly({
      handle: '#drgMini',
      containment: true
    });
  }else if(type == 'stavka_egg'){
    $('<div />', {
      "class": 'MiniModal',
      html: '<div class="Name" id="drgMini">Добавить лот</div><div class="Content"><div class="Settings"><center><b>Внимание, прочитайте!</b><br> За каждый лот вы платите 10.000 монет.<br>Введите значения <b>через запятую без пробелов</b> (Сначала начальную цену, затем цену шага, затем цену выкупа (если хотите без выкупа, то ставьте значение <b>0</b>), затем срок в днях).</center><div class="Step"><input placeholder="Начальная цена, шаг, выкуп, срок" onkeydown="if(event.keyCode == 13){market_go('+id+',\'stavka_egg_go\',$(this).val());}"></div></div></div>'
      }).appendTo('body');
    $('.MiniModal').draggabilly({
      handle: '#drgMini',
      containment: true
    });
  }else if(type == 'stavka_pokemon'){
    $('<div />', {
      "class": 'MiniModal',
      html: '<div class="Name" id="drgMini">Добавить лот</div><div class="Content"><div class="Settings"><center><b>Внимание, прочитайте!</b><br> За каждый лот вы платите 10.000 монет.<br>Введите значения <b>через запятую без пробелов</b> (Сначала начальную цену, затем цену шага, затем цену выкупа (если хотите без выкупа, то ставьте значение <b>0</b>), затем срок в днях).</center><div class="Step"><input placeholder="Начальная цена, шаг, выкуп, срок" onkeydown="if(event.keyCode == 13){market_go('+id+',\'stavka_pokemon_go\',$(this).val());}"></div></div></div>'
      }).appendTo('body');
    $('.MiniModal').draggabilly({
      handle: '#drgMini',
      containment: true
    });
  }else if(type == 'stavka') {
    $('<div />', {
      "class": 'MiniModal',
      html: '<div class="Name" id="drgMini">Добавить ставку, лот №'+id+'</div><div class="Content"><div class="Settings"><div class="Step"><input placeholder="Количество монет..." onkeydown="if(event.keyCode == 13){market_go('+id+',\'stavka_go\',$(this).val());}"></div></div></div>'
      }).appendTo('body');
    $('.MiniModal').draggabilly({
      handle: '#drgMini',
      containment: true
    });
  }else{
    $.ajax({
      url: "/do/marketgo",
      type: "POST",
      data: {
          id: id,
          type: type,
          val: val
      },
      success: function (response){
        response = JSON.parse(response);
        if(response['minus']) {
          Game.notifications.main(response['minus'], 'minus');
        }
        if(response['plus']) {
          Game.notifications.main(response['plus'], 'plus');
        }
        if(response['error'] == 1) {
          Game.notifications.main(response['text'], 'error');
        }else{
          openMarket();
          Game.notifications.main(response['text'], 'success');
        }
      }
    });
  }
}
function evenOn(){
  $('.Events .Steps').toggle();
}
function createView(id) {
  $('.ViewBattle').remove();
  $('<div />', {
    "class": 'ViewBattle',
    html: function() {
      var tpl = '';
      tpl += '<div class="Name" id="drgView">Бой на локации (Beta)<div class="Close" onclick=$(".ViewBattle").remove()><i class="fa fa-close"></i></div></div>';
      tpl += '<div class="Content"></div>';
      return tpl;
    }
  }).appendTo('body');
  $('.ViewBattle').draggabilly({
    handle: '#drgView',
    containment: true
  });
  setFightView(id);
}
function setFightView(id){

  $.ajax({
    url: "/do/viewBattleView",
    type: "POST",
    data: "id=" + id,
    success: function (response){
      response = JSON.parse(response);
      $('.ViewBattle .Content').html(response['html']);
      setTimeout(function() {
        setFightView(id);
      }, 5000);
    }
  });
}
function setFight(){
  $.ajax({
    url: "/do/viewBattle",
    type: "POST",
    success: function (response){
      response = JSON.parse(response);
      $('<div />', {
        "class": 'MiniModal',
        html: function() {
          var tpl = '';
          tpl += '<div class="Name" id="drgMini">Бои на локации</div>';
          tpl += '<div class="Content">';
          tpl += '<div class="Settings">';
          if(response['count'] == 0) {
            tpl += '<div class="Step"><div class="fS">Боев нет</div></div>';
          }else{
            if(response['html']) {
              tpl += response['html'];
            }else{
              tpl += '<div class="Step"><div class="fS">Боев нет</div></div>';
            }
          }
          tpl += '</div>';
          tpl += '</div>';
          return tpl;
        }
      }).appendTo('body');
      $('.MiniModal').draggabilly({
        handle: '#drgMini',
        containment: true
      });
    }
  });
}
function showUserTooltip(o,e) {
  e = window.event;
    $.ajax({
        url: "/do/tooltip",
        type: "POST",
        data: "user=" + o,
        success: function(s) {
            response = JSON.parse(s);
            if (s && ( (s = $.parseJSON(s)).userTooltip && s.userTooltip.login)) {
                $("#chat_user_to").val(s.userTooltip.login);
                var i = $("<div />", {
                        class: "TrainerGive"
                    }),
                    t = [];
                t.push('<div id="btnCardUser" onclick=\'Game.trenercard.opencard("' + s.userTooltip.login + "\");'><i class='fa fa-user'></i></div>"), s.userTooltip.delClan && t.push("<div id='btnClanDelUser' onclick='userAction(\"" + s.userTooltip.login + '","DeleteClan");\'><i class="fa fa-minus-circle"></i></div>'), s.userTooltip.addClan && t.push("<div id='btnClanPlusUser' onclick='userAction(\"" + s.userTooltip.login + '","AddClan");\'><i class="fa fa-plus-circle"></i></div>'), s.userTooltip.my ? t.push('<div id="btnSetUser" onclick="settings()"><i class="fa fa-cogs"></i></div>') : (
                  // t.push($("<div />", {
                  //     class: "PokBtn",
                  //     html: 'Открыть диалог'
                  // }).on("click", function() {
                  //   var newChat = $("<div />", {
                  //           class: "Active Button chat_move_channel_5"+o,
                  //           html: '<div class="u-'+s.userTooltip.group+'">'+s.userTooltip.login+'</div>',
                  //           "data-channel": '5'+o
                  //       }),
                  //       newChatBlock = $("<div />", {
                  //               class: "Active Message-Block Channel_5"+o,
                  //               "data-channel": '5'+o
                  //           });
                  //       $('.Chat .Category .Button').removeClass('Active');
                  //       $('.Chat .Talk .Message-Block').removeClass('Active');
                  //       newChat.appendTo('.Chat .Category');
                  //       newChatBlock.appendTo('.Chat .Talk');
                  // })),
                t.push($("<div />", {
                    "id": 'btnTradeUser',
                    html: '<i class="fa fa-handshake"></i>'
                }).on("click", function() {
                    ClassInfo && ClassInfo._action({
                        type: "offers",
                        target: "trade",
                        offerID: -1,
                        userID: parseInt(s.userTooltip.id)
                    }, function(o) {
                        o.offersCreate && Game.notifications.main(Lang.notify_success_wait, "success")
                    })
                })), t.push($("<div />", {
                    "id": 'btnFightUser',
                    html: '<i class="fa fa-hand-rock"></i>'
                }).on("click", function() {
                    ClassInfo && ClassInfo._action({
                        type: "offers",
                        target: "battle",
                        offerID: -1,
                        userID: parseInt(s.userTooltip.id)
                    }, function(o) {
                        o.offersCreate && Game.notifications.main(Lang.notify_success_wait, "success")
                    })
                })), t.push($("<div />", {
                    "id": 'btnFightUserAtk',
                    html: '<i class="fa fa-hand-rock"></i>'
                }).on("click", function() {
                    ClassInfo && ClassInfo._action({
                        type: "offers",
                        target: "battle",
                        offerID: -1,
                        userID: parseInt(s.userTooltip.id)
                    }, function(o) {
                        o.offersCreate && Game.notifications.main(Lang.notify_success_wait, "success")
                    })
                })), s.userTooltip.friend ? t.push('<div id="btnFrndDelUser" onclick=\'userAction("' + s.userTooltip.login + '","DeleteFriend");\'><i class="fa fa-user-times"></i></div>') : t.push('<div id="btnFrndPlusUser" onclick=\'userAction("' + s.userTooltip.login + '", "friend");\'><i class="fa fa-user-plus"></i></div>')),
                i.append('<div class="Avatar" style="background-image: url(/img/avatars/mini/'+s.userTooltip.id+'.png);"></div>',
                $("<div />", {
                    class: "Title"
                }).append(t)), i.appendTo("body");
                var left = (e.clientX - 100), top = (e.clientY - 50);
                if(left < 0) {
                  left = 0;
                }
                if(top < 0) {
                  top = 0;
                }
                Tipped.create('#btnFrndDelUser', 'Удалить из друзей');
                Tipped.create('#btnFrndPlusUser', 'Добавить в друзья');
                Tipped.create('#btnFightUser', 'Вызвать на бой');
                Tipped.create('#btnFightUserAtk', 'Нападение на тренера');
                Tipped.create('#btnTradeUser', 'Обменяться');
                Tipped.create('#btnSetUser', 'Настройки');
                Tipped.create('#btnClanDelUser', 'Удалить из клана');
                Tipped.create('#btnClanPlusUser', 'Пригласить в клан');
                Tipped.create('#btnCardUser', 'Тренеркарта');
                $('.TrainerGive').css({"left": left+'px',"top": top+'px'});
            }
        }
    })
}
function positionElement(t,o){
  var n=$(t).position(),
  p=$(t).offset(),
  e=Math.round(p.left),
  f=Math.round(p.top+n.top),
  l = (e - 113),
  t = (f + 63);
  $(o).css({
    left:l+"px",
    top:t+"px"
  })}
function userAction(t,e){$.ajax({url:"/do/trainers",type:"POST",data:"type="+e+"&user="+t,success:function(t){1==(t=JSON.parse(t)).error?Game.notifications.main(t.text,"error"):Game.notifications.main(t.text,"success")}})}
function setTrenerBlock(s,c){
  $(".Tabses .Table").hide(),
  $(".Tabses .Tabs div").css("color","#6c99ca"),
  $(".Tabses .Tabs div").css("background","#fff"),
  $("#"+s).show(),$(c).css("color","#fff"),
  $("#"+s).show(),$(c).css("background","#6c99ca")
}
function closeMudol(t){mudol=$(".mudol"),1==t?($("#pokedex").css("display","none"),mudol.attr("id",""),$("#DexBtn").attr("class","flt")):2==t&&($(".CraftModal").css("display","none"),$("#CraftBtn").attr("class","flt"))}
function goLocation(o){if(o<=0)return!1;$("#locationPreloader").show(),$.ajax({url:"/do/goLocation",type:"POST",data:{location_id:o},success:function(o){1==(o=JSON.parse(o)).error?($("#locationPreloader").delay(100).fadeOut(100),Game.notifications.main(o.text,"error")):($(".preloader span").html(Lang.loader_location),$("#locationPreloader").delay(100).fadeOut(100),updateLocation())}})}
function openMarket() {
  dex = $(".mudol"), 0 !== dex.length && dex.html(""), dexBtn = $("#MarketBtn"), dexBtn.attr("class", ""), dex.attr("id", "mark"), dex.css("display", "block"), dex.html('<center>' + mainLoader + '</center>');
  $.ajax({
    url: "/do/market",
    type: "POST",
    dataType: "json",
    success: function(d) {
      dex.html(d.html);
    }
  })
}
function openDex(i) {
    dex = $(".mudol"), 0 !== dex.length && dex.html(""), i < 1 ? i = 10807 : i > 10807 && (i = 1), dexBtn = $("#DexBtn"), dexBtn.attr("class", ""), dex.attr("id", "pokedex"), dex.css("display", "block"), dex.html('<center>' + mainLoader + '</center>'), UserPokedex = i, $.ajax({
        url: "/do/Pokedex",
        type: "POST",
        data: "dex=" + i,
        dataType: "json",
        success: function(d) {
            var s = parseInt(d.id) + 1,
                e = "";
            e += '<div class="Header">Покедекс<div class="Close" onclick="closeMudol(1)"><i class="fa fa-close"></i></div></div>',
            e += '<div class="Content">',

            e += '<div class="Pokedex">',

            e += '<div class="Dex-Inputs">',
            e += '<div onclick="openDex(' + parseInt(d.id - 1) + ')"><i class="fas fa-chevron-left"></i></div>',
            e += '<input type="type" placeholder="Найти покемона..." onkeydown="if(event.keyCode == 13){openDex($(this).val());}">',
            e += '<div onclick="openDex(' + s + ')"><i class="fas fa-chevron-right"></i></div>',
            e += '</div>',

            e += '<div class="Dex-Left">',

            e += '<div class="Dex-Block">',
            e += '<div class="Name">#'+d.numb+' '+d.name+'</div>',
            e += '<div class="Content">',
            e += '<div class="DexInfoPokemon">',
            e += '<div class="Imagep" style="background-image: url(/img/pokemons/mini/normal/' + d.numb + '.png);"></div>',
            e += '<div class="Typep">',
            e += "not" != d.typeOne ? '<div style="background-image: url(/img/world/typs/' + d.typeOne + '.png);"></div>' : "",
            e += "not" != d.typeTwo ? '<div style="background-image: url(/img/world/typs/' + d.typeTwo + '.png);"></div>' : "",
            e += '</div>',
            e += '<div class="Sexp"><span class="m"><i class="fas fa-mars"></i> '+d.m+'%</span><span class="f"><i class="fas fa-venus"></i> '+d.d+'%</span></div>',
            e += '<div class="Heightp"><div>'+d.height+' м.</div><div>'+d.weight+' кг.</div></div>',
            e += '<div class="Statp">',
            e += '<div><span>Здр</span> '+d.hp+'</div>',
            e += ' <div><span>Атк</span> '+d.atk+'</div>',
            e += ' <div><span>Зщт</span> '+d.def+'</div>',
            e += ' <div><span>Скр</span> '+d.sp+'</div>',
            e += ' <div><span>САтк</span> '+d.sa+'</div>',
            e += ' <div><span>СЗщт</span> '+d.sd+'</div>',
            e += '</div>',
            e += '<div class="Infop">Группа опыта: <b>'+d.go+'</b><br>В игре: <b>'+d.typeNormal+'</b><br>С уникальным окрасом в игре: <b>'+d.typeUnik+'</b></div>'
            e += '</div>',
            e += '</div>',
            e += '</div>',

            e += '</div>',

            e += '<div class="Dex-Right">',

            e += '<div class="Dex-Block">',
            e += '<div class="Name">Описание покемона</div>',
            e += '<div class="Content">',
            e += '<div class="AboutText">'+d.info+'</div>',
            e += '</div>',
            e += '</div>',

            e += '<div class="Dex-Block">',
            e += '<div class="Name">Эволюции покемона</div>',
            e += '<div class="Content">',
            e += '<div class="AboutText"><div class="DexEvol">'+d.evolutions+'</div></div>',
            e += '</div>',
            e += '</div>',

            e += '</div>',

            e += '<div class="Dex-Block" style="margin-top: 270px;">',

            e += '<div class="Name">Атаки</div>',
            e += '<div class="Content">',
            e += '<div class="ButtonsDexAtk">',
            e += '<div onclick="setTabDex(this,2);">По развитию</div>',
            e += '<div onclick="setTabDex(this,3);">По TM и HM</div>',
            e += '<div onclick="setTabDex(this,4);">По разведению</div>',
            e += '<div onclick="setTabDex(this,5);">По обучению</div>',
            e += '</div>',
            e += '<div class="DexAtk"><div class="chsC">Выберите категорию слева.</div></div>',
            e += '</div>',

            e += '</div>',

            e += '</div>',

            e += '</div>',
            e += '';
            dex.html(e);
        }
    })
}
function bigmapworld(i) {
    dex = $(".mudolmap"), 0 !== dex.length && dex.html(""), i < 1 ? i = 807 : i > 807 && (i = 1), dexBtn = $("#DexBtn"), dexBtn.attr("class", ""), dex.attr("id", "pokedex"), dex.css("display", "block"), dex.html('<center>' + mainLoader + '</center>'), UserPokedex = i, $.ajax({
        url: "/do/Pokedex",
        type: "POST",
        data: "dex=" + i,
        dataType: "json",
        success: function(d) {
            var s = parseInt(d.id) + 1,
                e = "";
            e += '<div class="Header">Карта Канто [Бета] <div class="Close" onclick="closeMudol(1)"><i class="fa fa-close"></i></div></div>',
            e += '<div class="Content">',

            e += '<img class="postimg" src="http://joxi.ru/gmvpLVetLYBxMA.jpg" alt="http://joxi.ru/gmvpLVetLYBxMA.jpg">',

         

            e += '</div>',

            e += '',
            e += '';
            dex.html(e);
        }
    })
}
var md5=new function(){var l="length",h=["0123456789abcdef",15,128,65535,1732584193,4023233417,2562383102,271733878],x=[[0,1,[7,12,17,22]],[1,5,[5,9,14,20]],[5,3,[4,11,16,23]],[0,7,[6,10,15,21]]],A=function(n,r,t){return(n>>16)+(r>>16)+((t=(n&h[3])+(r&h[3]))>>16)<<16|t&h[3]},B=function(n){for(var r=1+(n[l]+8>>6),t=new Array(1+16*r).join("0").split(""),u=0;u<n[l];u++)t[u>>2]|=n.charCodeAt(u)<<u%4*8;return t[u>>2]|=h[2]<<u%4*8,t[16*r-2]=8*n[l],t},R=function(n,r){return n<<r|n>>>32-r},C=function(n,r,t,u,o,f){return A(R(A(A(r,n),A(u,f)),o),t)},F=function(n,r,t,u,o,f,i){return C(r&t|~r&u,n,r,o,f,i)},G=function(n,r,t,u,o,f,i){return C(r&u|t&~u,n,r,o,f,i)},H=function(n,r,t,u,o,f,i){return C(r^t^u,n,r,o,f,i)},I=function(n,r,t,u,o,f,i){return C(t^(r|~u),n,r,o,f,i)},_=[function(n,r,t,u,o,f,i){return C(r&t|~r&u,n,r,o,f,i)},function(n,r,t,u,o,f,i){return C(r&u|t&~u,n,r,o,f,i)},function(n,r,t,u,o,f,i){return C(r^t^u,n,r,o,f,i)},function(n,r,t,u,o,f,i){return C(t^(r|~u),n,r,o,f,i)}],S=function(){with(Math)for(var i=0,a=[],x=pow(2,32);i<64;a[i]=floor(abs(sin(++i))*x));return a}(),X=function(n){for(var r=0,t="";r<4;r++)t+=h[0].charAt(n>>8*r+4&h[1])+h[0].charAt(n>>8*r&h[1]);return t};return function(n){for(var r,t,u,o=B(""+n),f=[0,1,2,3],i=[0,3,2,1],c=[h[4],h[5],h[6],h[7]],e=0,a=0,C=[].concat(c);e<o[l];e+=16,C=[].concat(c),a=0){for(r=0;r<4;r++)for(t=0;t<4;t++)for(u=0;u<4;u++,f.unshift(f.pop()))c[i[u]]=_[r](c[f[0]],c[f[1]],c[f[2]],c[f[3]],o[e+((4*t+u)*x[r][1]+x[r][0])%16],x[r][2][u],S[a++]);for(r=0;r<4;r++)c[r]=A(c[r],C[r])}return X(c[0])+X(c[1])+X(c[2])+X(c[3])}};
function setTabDex(e, i) {
    $.ajax({
        url: "/do/Pokedex",
        type: "POST",
        data: "setTab=" + i + "&pok=" + UserPokedex,
        beforeSend: function() {
            $(".Content .DexAtk").html('<center>' + mainLoader + '</center>')
        },
        success: function(t) {
            t = JSON.parse(t);
            $(".actv").removeClass("actv");
            $(e).addClass("actv");
            if (t.error) return Game.notifications.main(t.text, "error");
            var a = [],
                s = 0;
                if(t.t == 'tm') {
                  a += t.tt;
                }else{
                  $.each(t.atkList, function(e, o) {
                    addTpl = 2 == i ? t.lvlList[s] + " " + Lang.text_lvl : "",
                    a += '<div class="Move"><img src="/img/world/typs/' + o.type + '.png" onclick="viewDescriptionAttak(this,' + o.id + ');"> <div class="MoveInfo"><div class="Name MoveCategory' + ("physical" == o.category ? 1 : "special" == o.category ? 2 : 3) + '">'+o.name_rus+'</div><div class="PP">'+addTpl+'</div></div>',
                    a += "</div>",
                    s++
                  });
                }
                a += $(".Content .DexAtk").html(a);
        }
    })
}
function byMax(e){$(".DivNpcBlock").remove(),$(".model").length&&$(".model").remove(),ClassInfo._byItemWindow(parseInt(e))}
function closeModal(){$(".Modal").remove()}
function setTab(e, t) {
    $(e).addClass("active"), t = parseInt(t);
    $.ajax({
        url: "/do/modal",
        type: "POST",
        data: {
            tab: t,
            type: "trainers"
        },
        beforeSend: function() {
            $(".Trainers .List").html('<center>' + mainLoader + '</center>')
        },
        success: function(e) {
            e = JSON.parse(e), $(".Modal").html(e.html)
        }
    })
}

function searchUser() {
    var e = $("#searchUser").val();
    $.ajax({
        url: "/do/modal",
        type: "POST",
        data: {
            tab: 9,
            type: "trainers",
            text: e
        },
        beforeSend: function() {
            $(".Trainers .List").html('<center>' + mainLoader + '</center>')
        },
        success: function(e) {
            e = JSON.parse(e), $(".Trainers .List").html(e.html)
        }
    })
}
function goPok(o){UserPokList.length;var s=UserPokList.indexOf(o),e=UserPokList[s-1]?UserPokList[s-1]:UserPokList[UserPokList.length-1],k=UserPokList[s+1]?UserPokList[s+1]:UserPokList[0];$(".prevPok").on("click",function(){Game.modals.pokemons()}),$(".nextPok").on("click",function(){Game.modals.pokemons()})}
function PokemonTeamOpen(){pokemon=$(".BlockOtherContent"),pokemon.removeClass("updated"),pokemon.toggle(),pokemon.html('<center>'+mainLoader+'</center>'),pokemon.load("/do/PokemonTeam")}function openCraft(){craft=$(".CraftModal"),craft.toggle(),craftB=$("#CraftBtn"),craftB.attr("class",""),craft.load("/do/Craft")}
function viewDescriptionAttak(t, s, i, e) {
	$(".tooltip").html("").hide(), $.ajax({
		url: "/do/pokemonsAction",
		type: "POST",
		data: "pokID=" + s + "&type=attackInfo",
		success: function(a) {
			if (a = JSON.parse(a), 0 == s) i && (d = '<div class="Buttons"><div onclick=addAttacks(this,"open",' + i + "," + e + ");>" + Lang.button_attack_learn + "</div></div>");
			else {
				if (a.contact == 0) {
					var se = '';
				} else {
					var se = ', контакт';
				}
        $(".GiveDiv").css({
  				"z-index": 999
  			});
				var d = '<div class="w">';
				d += '<div class="t-a">' + a.nameRus + "</div>", d += '<div class="t-b">' + a.name + "<span>" + a.pp + " PP</span></div></div>", d += '<div class="t-c">' + a.title + "</div>", d += '<div class="t-d"><img src="/img/world/typs/' + a.type + '.png"></div>', d += '<div class="t-f">' + a.category + '' + se + '</div><div class="t-e">', 0 != a.accuracy && (d += "<span>" + Lang.text_accuracy + " " + a.accuracy + "%</span>"), 0 != a.power && (d += "<span>" + Lang.text_power + " " + a.power + "</span>"), d += "</div>", i && (d += '<div class="Buttons"><div onclick=addAttacks(this,"open",' + i + "," + e + ");>" + Lang.button_attack_swap + "</div></div>")
			}
			$("body");
			var c = $(".tooltip"),
				o = ($(t).position(), $(t).offset()),
				p = Math.round(o.left - 50),
				n = Math.round(o.top + 50);
			c.append(d), $(".tooltip").css({
				left: p + "px",
				top: n + "px"
			}), c.show()
		}
	})
}
function opros() {
  $.ajax({
    url: "/do/opros",
    type: "POST",
    success: function (){
      $('.Opros').remove();
      Game.notifications.main('Отлично! Теперь вы можете заглянуть в «В Жемчужный магазин»!', 'info');
    }
  });
}
function setHunt(a){$(a).hasClass("NoActive")?($(a).removeClass("NoActive"),assault=!0,$(a).attr("data","\u0412\u044B\u043A\u043B\u044E\u0447\u0438\u0442\u044C \u043D\u0430\u043F\u0430\u0434\u0435\u043D\u0438\u044F")):($(a).addClass("NoActive"),assault=!1,$(a).attr("data","\u0412\u043A\u043B\u044E\u0447\u0438\u0442\u044C \u043D\u0430\u043F\u0430\u0434\u0435\u043D\u0438\u044F"))}
function setStart(t){$.ajax({url:"/do/pokemonsAction",type:"POST",data:{pokID:t,type:"setStart"},success:function(o){1==(o=JSON.parse(o)).error?Game.notifications.main(o.text,"error"):(Game.notifications.main(o.text,"success"),Game.modals.pokemons())}})}
function wentPok(o){$.ajax({url:"/do/pokemonsAction",type:"POST",data:{pokID:o,type:"wentPok"},beforeSend:function(){$("#locationPreloader span").html(Lang.loader_pokemon_walk),$("#locationPreloader").show()},success:function(e){1==(e=JSON.parse(e)).error?($("#locationPreloader").delay(500).fadeOut(200),Game.notifications.main(e.text,"error")):(Game.modals.pokemons(),$("#locationPreloader").delay(500).fadeOut(200),Game.notifications.main(e.text,"success"))}})}
function openReproductionPoks(a,b){
  $('.GiveDiv').remove();
  var c='<div class="GiveDiv">';
  c+='<div id="DivAbout">\u0420\u0430\u0437\u0432\u0435\u0434\u0435\u043D\u0438\u0435 \u043F\u043E\u043A\u0435\u043C\u043E\u043D\u043E\u0432</b></div>',
  c+='<div class="wrap"><div class="PokList">',
  $.ajax({
    url:'/do/itemsAction',
    type:'POST',
    data:'type=reproductionList',
    success:function(d){
    if(0!=d){
      d=JSON.parse(d);
      var f='';
      $.each(d.pokList,function(l,m){
      var n=m.gen.split(',');
      f+='<div class="PokeUse" onclick=AddReproductionPok('+m.id+','+b+',"'+m.type+'","'+m.basenum+'","'+m.gender+'");><img src="/img/pokemons/mini/'+m.type+'/'+m.basenum+'.png"></img> <div class="NameUse '+m.type+'-color">#'+m.basenum+' '+m.name+' <small><b>'+m.gender.charAt(0)+' ('+m.sparkaNumber+')</b></small><br /><small><u><i>h'+n[0]+'a'+n[1]+'d'+n[2]+'s'+n[3]+'sa'+n[4]+'sd'+n[5]+'</u></i></small></div></div>'}),c+=f}c+='</div></div></div>',$(c).appendTo('body');var g=$(a).position(),h=$(a).offset(),i=Math.round(h.left)+10,j=Math.round(g.top/10),k=Math.round(h.top+g.top/j+100);$('.GiveDiv').css({left:i+'px',top:k+'px'})}})}
function issetAll(m,o,l=false,e){
  e = window.event;
  var a = $('.tooltip');
  $.ajax({
  url: "/do/Issets",
  type: "POST",
  data: 'type='+o+'&id='+m+'&other='+l,
  beforeSend: function(){
    var left = (e.clientX - 134), top = (e.clientY + 15);
    if(left < 0) {
      left = 0;
    }
    if(top < 0) {
      top = 0;
    }
    a.css({"left": left+'px',"top": top+'px'});
    a.html('<center>'+mainLoader+'</center>');a.show();},success: function (response) {response = JSON.parse(response);a.html(response['text']);}});}
function btnCreateClan(){
  var a = $("#clanCreateName").val(),
  b = $("#clanCreateEmblem").val();
  $.ajax({
    url: "/do/clanAction",
    type: "POST",
    data: 'name='+a+'&object=createClan&emblem='+b,
    success: function (response) {
      response = JSON.parse(response);
      if(response["minus"]) {
        Game.notifications.main(response["minus"], 'minus');
      }
      Game.notifications.main(response["text"], response["error"]);
    }
  });
}
function openPanelDL(type){$('.model').remove();$.ajax({url: "/do/logAction",type: "POST",data: {type: type},beforeSend: function(){$('<div />', {'class':'model'}).appendTo('body');$('.model').html('<center>'+mainLoader+'</center>');},success: function (response) {response = JSON.parse(response);var tpl = '';tpl += '<div class="header">'+Lang.text_dl+'<span onclick="$(\'.model\').remove();"><i class="fa fa-close"></i></span></div>';tpl += '<div class="content-model">'+response['text']+'</div>';$('.model').html(tpl);$('.model').draggabilly({handle: '.header',containment: true});}});}
function AddReproductionPok(a,b,c,d,f){
  $('#Reproduction'+b).css('background-image','url(/img/pokemons/mini/'+c+'/'+d+'.png)').attr('data-pok',a)
}
function GetReproductionResult() {
    var a = $('#Reproduction1').attr('data-pok'),
        b = $('#Reproduction2').attr('data-pok');
    a && b ? a == b ? Game.notifications.main(Lang.error_pokemon_different, 'error') : $.ajax({
        url: '/do/reproduction',
        type: 'POST',
        data: 'pok1=' + a + '&pok2=' + b,
        success: function(c) {

            c = JSON.parse(c), 1 == c.error ? Game.notifications.main(c.text, 'error') : Game.notifications.main(c.text, 'success');
        }
    }) : Game.notifications.main(Lang.error_pokemon_choose, 'error')
}
function setTrade(a,b){$.ajax({url:"/do/trade",type:"POST",data:"type="+a+"&id="+b,success:function(c){c=JSON.parse(c),1==c.error?Game.notifications.main(c.text,"error"):Game.notifications.main(c.text,"success")}})}
function updNoticeDef(t){t&&$.each(t,function(t,o){o&&o.text&&Game.notifications.main(o.text,"success")})}
function uploadImg() {
	var u = $('#upload_file #file_name').prop('files')[0];
	var s = new FormData();
	s.append('file', u);
	j = $('#upload_file').html();
	$.ajax({
		url: '/do/upload',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data: s,
		type: 'POST',
		beforeSend: function() {
			$('#upload_file').html('<center><img height="20px" src="/img/loader/1.gif"></center>');
			},
		success: function(n){
			if(n==''){
				$('#upload_file').html('<center><span style="color: green;font-weight: bold;">'+Lang.success_load_file+'</span></center>');
			}else{
				Game.notifications.main(n);
				$('#upload_file').html(j);
			}
		}
	});
	return false;
}
var Game = {
	title_tooltip: function() {
		$('<div />', {
			"class": 'Button',
			html: '<i class="fa fa-paw"></i>'+Lang.title[5],
			'click': function() {
				Game.modals.pokemons();
			}
		}).appendTo('.MidMenu');
		$('<div />', {
			"class": 'Button',
			html: '<i class="fa fa-briefcase"></i>'+Lang.title[0],
			'click': function() {
				Game.modals.inventory('all');
			}
		}).appendTo('.MidMenu');
		$('<div />', {
			"class": 'Button',
			html: '<i class="fa fa-book"></i>'+Lang.title[1],
			'click': function() {
				Game.modals.diary('quests');
			}
		}).appendTo('.MidMenu');
		$('<div />', {
			"class": 'Button',
			html: '<i class="fa fa-users"></i>'+Lang.title[2],
			'click': function() {
				openModal('trainers');
			}
		}).appendTo('.MidMenu');
		$('<div />', {
			"class": 'Button',
			html: '<i class="fa fa-cog"></i>'+Lang.title[4],
			'click': function() {
				openModal('craft');
			}
		}).appendTo('.MidMenu');
    $('<div />', {
			"class": 'Button',
			html: '<i class="fa fa-bookmark"></i>'+Lang.title[3],
			'click': function() {
				Game.modals.clans();
     }
    // }).appendTo('.MidMenu'); 
    // $('<div />', { 
    // "class": 'Button',
    // html: '<i class="fa fa-gift"></i>'+Lang.title[6],
    // 'click': function() { 
    //  Game.prize.dayPrize(''); 
    // }
		}).appendTo('.MidMenu');
		Tipped.create('.TopMenu .RightMenu .Buttons .Button', Lang.hint_notify);
		Tipped.create('.el_dex', Lang.hint_dex);
    Tipped.create('.el_market', 'Межрегиональный аукцион');
		Tipped.create('.el_fight', 'Бои на локации');
		Tipped.create('.el_clear_chat', 'Очистить чат');
    Tipped.create('.el_smile', 'Смайлики');
    Tipped.create('.el_wild', 'Дикие покемоны');
	},
  updateUserLocation: function() {
		$.post('/do/updateLocation', {updateUsers: true, userAssault: assault}, function(data){

      if(data.tw == 1) {
        $('.TechWork').css('display','block');
      }else{
        $('.TechWork').css('display','none');
      }

			if(VERSION != data.ver){
				setTimeout(function(){
					window.location.reload();
				}, 15000);
				if(!$('.DivNotification').find('.version').length){
					Game.notifications.main('<b>Системное оповещение</b><br>Внимание! Игра обновлена до версии '+data.ver+'. Через несколько секунд произойдет автоматическая перезагрузка страницы.','version');
				}
			}

			if(data.usersDefNotice){
				updNoticeDef(data.usersDefNotice);
			}

			if(md5locList != data.usersAtLocationHash){
				md5locList = data.usersAtLocationHash;
				if(ClassInfo){
					ClassInfo._upUsrLoc(data.usersAtLocation, (data.usersAtNotice || null));
				}
			}
      if(data.bafs) {
        $('.TopMenu .Bafs').html(data.bafs);
      }

      if(data.infoChat && ClassChat){
				ClassChat._update(data);
			}

			if(data.serverTime){
				$('#map_time').html(data.serverTime);
			}

			$('.Weather').attr({
				"style": 'background-image: url(/img/weather/'+data.WeatherId+'.png);'
			});

			$('.WeatherName').html(Lang.time_day[$(".WeatherName").attr("data")]+', '+data.WeatherName);
			if(ClassInfo && data.server_ver){
				ClassInfo._upVer(data.server_ver);
			}

			if(data.battleInfo){
				if(!ClassBattle){
					ClassBattle = new GameBattle(data.battleInfo);
				}else{
					ClassBattle._open(data.battleInfo);
				}
			}

			if(data.tradeInfo){
				if(!ClassTrade){
					ClassTrade = new Trade(data.tradeInfo);
				}else{
					ClassTrade._parseData(data.tradeInfo);
				}
			}else{
				if(ClassTrade){
					ClassTrade._close(false);
					ClassTrade = null;
				}
			}
			setTimeout(Game.updateUserLocation, 3000);
		}, 'json')
	},
	modals: {
		modalLoad: function(n) {
			Game.loaders.world();
			$('.Modal').remove();
			$('<div />', {
				"class": 'Modal',
				html: '<div class="Title"><div class="Name">'+Lang.title[n]+'</div></div>'
			}).appendTo('body');
			$('<div />', {
				"class": 'Close',
				html: '<i class="fa fa-close"></i>',
				'click': function() {
					$('.Modal').remove();
				}
			}).appendTo('.Modal .Title');
		},
		modelLoad: function(d){
			$('.model').remove();
			$('<div />', {
				'class':'model'
			}).appendTo('body');
			$('<div />', {
				'class':'header',
				html: d
			}).appendTo('.model');
			$('<span />', {
				html: "<i class='fa fa-close'></i>",
				"click": function() {
					$('.model').remove();
				}
			}).appendTo('.model .header');
			$('<div />', {
				'class':'content-model',
			}).appendTo('.model');
			$('.model').draggabilly({
				handle: '.header',
				containment: true
			});
		},
		itemsCategory: function() {
			var el_qw = $('<div />', {
							'class':'Button',
							'id': 'allItems',
							html: 'Все',
							'click': function() {
								Game.modals.inventory('all');
							}
						}),
				el_qr = $('<div />', {
							'class':'Button',
							'id': 'modificatorItems',
							html: 'Модификаторы',
							'click': function() {
								Game.modals.inventory('modificator');
							}
						}),
				el_qt = $('<div />', {
							'class':'Button',
							'id': 'eggItems',
							html: 'Яйца',
							'click': function() {
								Game.modals.inventory('egg');
							}
						}),
				el_qy = $('<div />', {
							'class':'Button',
							'id': 'evolverItems',
							html: 'Эволверы',
							'click': function() {
								Game.modals.inventory('evolver');
							}
						}),
				el_qu = $('<div />', {
							'class':'Button',
							'id': 'craftItems',
							html: 'Крафтовые',
							'click': function() {
								Game.modals.inventory('craft');
							}
						}),
				el_qi = $('<div />', {
							'class':'Button',
							'id': 'trophyItems',
							html: 'Награды',
							'click': function() {
								Game.modals.inventory('trophy');
							}
						}),
				el_qo = $('<div />', {
							'class':'Button',
							'id': 'potionItems',
							html: 'Регенераторы',
							'click': function() {
								Game.modals.inventory('potion');
							}
						}),
				el_qp = $('<div />', {
							'class':'Button',
							'id': 'ballItems',
							html: 'Покеболы',
							'click': function() {
								Game.modals.inventory('ball');
							}
						}),
				el_qa = $('<div />', {
							'class':'Button',
							'id': 'tmItems',
							html: 'TM/HM',
							'click': function() {
								Game.modals.inventory('tm');
							}
						}),
				el_qd = $('<div />', {
							'class':'Button',
							'id': 'questItems',
							html: 'Квестовые',
							'click': function() {
								Game.modals.inventory('quest');
							}
						}),
				el_qg = $('<div />', {
							'class':'Button',
							'id': 'otherItems',
							html: 'Прочее',
							'click': function() {
								Game.modals.inventory('other');
							}
						}),
			el_zz = [el_qw, el_qr, el_qt, el_qy, el_qu, el_qi, el_qo, el_qp, el_qa, el_qd, el_qg];
			$('.Inventory .Category').append(el_zz);
		},
		questsCategory: function() {
			el_wq = $('<div />', {
							'class':'Button',
							'id': 'questsBook',
							html: 'Задания',
							'click': function() {
								Game.modals.diary('quests');
							}
						}),
            el_we = $('<div />', {
      							'class':'Button',
      							'id': 'locationBook',
      							html: 'Локация',
      							'click': function() {
      								Game.modals.diary('location');
      							}
      						}),
                  el_wj = $('<div />', {
            							'class':'Button',
            							'id': 'newsBook',
            							html: 'Новости друзей',
            							'click': function() {
            								Game.modals.diary('news');
            							}
            						}),
                        el_wi = $('<div />', {
                  							'class':'Button',
                  							'id': 'raidBook',
                  							html: 'Рейды',
                  							'click': function() {
                  								Game.modals.diary('raid');
                  							}
                  						}),
			el_zq = [el_wq, el_wi, el_we, el_wj];
			$('.AquaBook .Category').append(el_zq);
		},
		aquarits: function() {
			Game.modals.modalLoad(6);
			$.post('/do/modal', {type: 'AquaRits'}, function(data){
				$('<div />', {'class': 'Inventory'}).appendTo('.Modal');
				$('<div />', {'class': 'HeaderAqua',
					html: data.html
				}).appendTo('.Inventory');
				$('<div />', {'class': 'ThingBuy'}).appendTo('.Inventory');
				$.each(data.items, function(){
					$('<div />', {
						'class'		: 'Thing',
						'data-id'	: this.id,
						'click'		: function(t){
							Game.modals.modalLoad(0);
							$.post('/do/itemsAction', {itemID: $(this).data('id'), type: 'buyDonat'}, function(data){
                data.plus ? Game.notifications.main(data.plus,'plus') : '';
                data.minus ? Game.notifications.main(data.minus,'minus') : '';
								Game.notifications.main((data.error == 0 ? 'Предмет удачно куплен.' : 'Недостаточно жемчуга.'),(data.error == 0 ? 'success' : 'error'));
								Game.modals.aquarits();
							}, 'json')
						},
						html: '<img src="/img/world/items/little/'+this.item+'.png"><div class="Price">'+this.price+' жем.</div><div class="Name">'+this.name+'</div><div class="About">'+this.about+'</div>'
					}).appendTo('.ThingBuy');
				});
        $('<div />', {
          "class": 'AquaButton'
        }).appendTo('.Inventory');
        $('<div />', {
          "class": 'Button',
          html: 'Инвентарь',
          "click": function() {
            Game.modals.inventory('all');
          }
        }).appendTo('.AquaButton');
				$('.Modal').css('left',(Math.round(offset = $('.MidMenu').offset().left) - 46)+'px');
				//$('.DivAquarits .HeaderAqua input[type="number"]').on('input propertychange', function(){
				//	if(parseInt($(this).val()) > 0){
				//		$('.DivAquarits .HeaderAqua form label').text(parseInt($(this).val()) * 10 + ' р.')
				//	}else{
				//		$(this).val('1')
				//	}
				//})
				Game.loaders.worldClose();
			}, 'json')
		},
		pokemons: function(){
			Game.modals.modalLoad(5);
			$.post('/do/PokemonTeam', {type: 'load'}, function(data){
				$('<div/>', {'class': 'Pokemons'}).appendTo('.Modal');
				$.each(data, function(){
          $('<div />',{
            'html'	: this.html,
            'class': 'PokemonBox '+this.start,
            'id': 'PokemonBox'+this.id
          }).appendTo('.Modal .Pokemons');
        });
        if((Math.round(offset = $('.MidMenu').offset().left) - 120) < 0) {
          var left = 1;
        }else{
          var left = (Math.round(offset = $('.MidMenu').offset().left) - 120);
        }
				$('.Modal').css('left',left+'px');
				Game.loaders.worldClose();
			}, 'json')
		},
		inventory: function(l) {
			$.ajax({
				url: "/do/modal",
				type: "POST",
				data: "type=inventory&category="+l,
				beforeSend: function(){
					Game.modals.modalLoad(0);
				},
				success: function (response) {
						response = JSON.parse(response);
						$('<div />', {
							"class": 'Inventory'
						}).appendTo('.Modal');
						$('<div />', {
							"class": 'Category'
						}).appendTo('.Inventory');
						$('<div />', {
							"class": 'Items',
              "id": 'Items'
						}).appendTo('.Inventory');
						$.each(response['eggList'], function(x,y){
							$('<div />', {
								"class": 'Item',
								"click": function() {
									itemOpen(this,y['ctgMdl'],y['id'],'Яйцо '+y['name'],y['gen']+'<br />'+y['reborn'],54,1,0,false,false,false,true,false,false,y['ustatus'],true,y['loc']);
								},
								html: "<img id='imgItem' src='/img/world/items/little/54.png'><div class='Count'>1</div><div class='Name'>"+y['name']+"</div>"
							}).appendTo('.Inventory .Items');
						});
						// $.each(response['itemList'], function(x,y){
							// $('<div />', {
								// "class": 'Item',
								// "click": function() {
									// itemOpen(this,y['ctgMdl'],y['id'],y['name'],y['about'],y['img'],y['count'],y['itemWeight'],y['use'],y['dress'],a,y['trade'],y['give'],false,y['ustatus']);
								// },
								// html: '<img id="imgItem" src="/img/world/items/little/'+y['img']+'.png" onerror="$(this).attr(\'src\',\'/img/world/items/little/0.png\');"><span class="Bot">'+y['count2']+'</span>'
							// }).appendTo('.InvItems');
						// });
						$('.Inventory .Items').append(response['html']);
            $('<div />', {
							"class": 'AquaButton'
						}).appendTo('.Inventory');
            $('<div />', {
							"class": 'Button',
              html: 'Жемчужный магазин',
              "click": function() {
                Game.modals.aquarits();
              }
						}).appendTo('.AquaButton');
						Game.modals.itemsCategory();
						$('.Inventory .Category').find('#'+l+'Items').addClass('active');
						$('.Modal').css('left',(Math.round(offset = $('.MidMenu').offset().left) - 46)+'px');
						Game.loaders.worldClose();
				}
			});
		},
		diary: function(i,s=false) {
			$.ajax({
				url: "/do/modal",
				type: "POST",
				data: "type=diary&category="+i+"&pokID="+s,
				beforeSend: function(){
					Game.modals.modalLoad(1);
				},
				success: function (response) {
						response = JSON.parse(response);
						var ii = '';
            $('<div />', {
							"class": 'AquaBook'
						}).appendTo('.Modal');
            $('<div />', {
							"class": 'Category'
						}).appendTo('.AquaBook');
						Game.modals.questsCategory();
						$('<div />', {
							"class": 'Quests'
						}).appendTo('.AquaBook');
						if(i == 'quests'){
							$.each(response['questList'], function(x,y){
                var cq;
                if(y['check'] == 1) {
                  cq = '<div class="Check"><i class="fa fa-check"></i></div>';
                }else if(y['check'] == 2) {
                  cq = '<div class="Nach"><i class="fa fa-exclamation"></i></div>';
                }else{
                  cq = '';
                }
								$('<div />', {
									"class": 'Quest',
									"click": function() {
										Game.modals.diary('questsList',y['id']);
									},
									html: cq+'<img src="/img/quests/'+y['id']+'.png" onerror="$(this).attr(\'src\',\'/img/world/items/little/0.png\');"><div class="Name">'+y['name']+'</div>'
								}).appendTo('.Quests');
							});
						}else if(i == 'questsList'){
							$('<div />', {
								"class": 'QuestOne'
							}).appendTo('.Quests');
							$('<div />', {
								"class": 'QuestTop'
							}).appendTo('.QuestOne');
							$('<img />', {
								"src": '/img/quests/'+response['id']+'.png',
								"click": function() {
									Game.modals.diary('quests');
								}
							}).appendTo('.QuestTop');
							$('<div />', {
								"class": 'Name',
								html: response['name']
							}).appendTo('.QuestTop');
							$('.QuestTop').append(response['progress']);
							$('<div />', {
								"class": 'QuestProgress'
							}).appendTo('.QuestOne');
							$.each(response['questList'], function(x,y){
								$('<div />', {
									"class": 'Step',
									html: '<div class="Title">Запись '+y['step']+'</div><div class="Text">'+y['text']+'</div>'
								}).appendTo('.QuestProgress');
							});
						}else if(i == 'news'){
              $('<div />', {
								"class": 'News',
                html: response['newsBook']
							}).appendTo('.Quests');
              // $.each(response['newsList'], function(x,y){
							// 	$('<div />', {
							// 		"class": 'New',
							// 		html: ''
							// 	}).appendTo('.Quests .News');
							// });
						}else if(i == 'location'){
              $('<div />', {
								"class": 'LocWeather',
                html: response['htmlWeather']
							}).appendTo('.Quests');
              $('<div />', {
								"class": 'LocBook'
							}).appendTo('.Quests');
              $.each(response['pokList'], function(x,y){
                if(y['hide'] != 1) {
                  $('<div />', {
  									"class": 'PokemonBook '+y['catch'],
  									html: '<div class="Name"><img src="/img/pokemons/mini/normal/'+y['num']+'.png"> #'+y['num']+' '+y['name']+' (от '+y['lvl1']+' до '+y['lvl2']+' ур.)</div><div class="Content"><span>Можно выбить: <b>'+y['drop']+'</b></span><span>Доп. условия встречи: <b>'+y['c_con']+'</b></span><span>Время: <b>'+y['time']+'</b></span></div>'
  								}).appendTo('.LocBook');
                }
							});
						}else if(i == 'raid') {
              $('<div />', {
								"class": 'Raids',
                html: response['html']
							}).appendTo('.Quests');
            }
            if(i == 'questsList') {
              i = 'quests';
            }
						$('.AquaBook .Category').find('#'+i+'Book').addClass('active');
						$('.Modal').css('left',(Math.round(offset = $('.MidMenu').offset().left) + 108)+'px');
						Game.loaders.worldClose();
				}
			});
		},
		clans: function() {
			$.ajax({
				url: "/do/modal",
				type: "POST",
				data: "type=clans",
				beforeSend: function(){
					Game.modals.modalLoad(3);
				},
				success: function (response) {
						response = JSON.parse(response);
            $('<div />', {
							"class": 'Clans'
						}).appendTo('.Modal');
            $('<div />', {
							"class": 'Category',
              html: '<div class="Name">Лиги</div><div class="Button top1 active">Закрыто</div><div class="Button top2">Золотая</div><div class="Button top3">Закрыто</div><div class="Button top4">Закрыто</div>'
						}).appendTo('.Clans');
            $('<div />', {
							"class": 'ClanList'
						}).appendTo('.Clans');
						$.each(response['clansList'], function(x,y){
							$('<div />', {
								"class": 'Clan',
								"click": function() {
									openClanCard(y['id']);
								},
								html: '<img src="/img/world/clans/'+y['id']+'.png"><div class="Top">'+y['rating']+'</div><div class="Name">'+y['name']+'</div>'
							}).appendTo('.ClanList');
						});
            $('<div />', {
							"class": 'BottomClans'
						}).appendTo('.Clans');
            $('<div />', {
							"class": 'Buttons'
						}).appendTo('.BottomClans');
						$('<div />', {
							"class": 'Button',
							html: 'Создать клан',
							"click": function() {
								Game.clan.createClan();
							}
						}).appendTo('.BottomClans .Buttons');
						$('.Modal').css('left',(Math.round(offset = $('.MidMenu').offset().left) + 500)+'px');
						Game.loaders.worldClose();
				}
			});
		}
	},
	pokemonTeamTabs: function(i,r){
		$.ajax({
			url:"/do/PokemonTeam",
			type:"POST",
			data:"type="+r+"&other="+i,
			beforeSend: function(){
				$('<div />', {
					"class": 'Hidden',
					id: 'Hidden'+i,
					html: '<div id="HiddenLoad"></div>'
				}).appendTo('#pokemonDivs'+i);
			},
			success:function(response){
				if(r == 'info'){
					response = JSON.parse(response);
          Game.modals.modalLoad(5);
          $('<div />', {
						"class": 'Pokemons',
						html: response['html']
					}).appendTo('.Modal');
          if((Math.round(offset = $('.MidMenu').offset().left) - 120) < 0) {
            var left = 1;
          }else{
            var left = (Math.round(offset = $('.MidMenu').offset().left) - 120);
          }
  				$('.Modal').css('left',left+'px');
          Game.loaders.worldClose();
				}else if(r == 'attack'){
					response = JSON.parse(response);
					$('#HiddenLoad').remove();
					$('<div />', {
						"class": 'Name',
						html: '<i class="fa fa-close"></i> Атаки',
						"click": function(){
							$('#Hidden'+i).remove();
						}
					}).appendTo('#Hidden'+i);
					$('<div />', {
						"class": 'Attacks',
						html: response['html']
					}).appendTo('#Hidden'+i);
				}else if(r == 'stats'){
					response = JSON.parse(response);
					$('#HiddenLoad').remove();
					$('<div />', {
						"class": 'Name',
						html: '<i class="fa fa-close"></i> Статы',
						"click": function(){
							$('#Hidden'+i).remove();
						}
					}).appendTo('#Hidden'+i);
					$('<div />', {
						"class": 'StatsPokemon',
						"id": 'StatsPokemon'+i,
						html: '<div class="StatPokemon" id="hpStat'+i+'"><div class="Stat">Здоровье</div><span>'+response['statHp']+'</span></div><div class="StatPokemon" id="atkStat'+i+'"><div class="Stat">Атака</div><span>'+response['statAtk']+'</span></div><div class="StatPokemon" id="defStat'+i+'"><div class="Stat">Защита</div><span>'+response['statDef']+'</span></div><div class="StatPokemon" id="spdStat'+i+'"><div class="Stat">Скорость</div><span>'+response['statSpd']+'</span></div><div class="StatPokemon" id="saStat'+i+'"><div class="Stat">Спец. Атака</div><span>'+response['statSa']+'</span></div><div class="StatPokemon" id="sdStat'+i+'"><div class="Stat">Спец. Защита</div><span>'+response['statSd']+'</span></div>'
					}).appendTo('#Hidden'+i);
					$('<div />', {
						"class": 'Ev',
						html: response['evHp']+' ev <i class="fa fa-plus"></i>',
						"click": function(){
							if(!$('#InputStat_0').length){
								addEV("open",0,this,false,i);
							}
						}
					}).appendTo('#hpStat'+i);
					$('<div />', {
						"class": 'Ev',
						html: response['evAtk']+' ev <i class="fa fa-plus"></i>',
						"click": function(){
							if(!$('#InputStat_1').length){
								addEV("open",1,this,false,i);
							}
						}
					}).appendTo('#atkStat'+i);
					$('<div />', {
						"class": 'Ev',
						html: response['evDef']+' ev <i class="fa fa-plus"></i>',
						"click": function(){
							if(!$('#InputStat_2').length){
								addEV("open",2,this,false,i);
							}
						}
					}).appendTo('#defStat'+i);
					$('<div />', {
						"class": 'Ev',
						html: response['evSpd']+' ev <i class="fa fa-plus"></i>',
						"click": function(){
							if(!$('#InputStat_3').length){
								addEV("open",3,this,false,i);
							}
						}
					}).appendTo('#spdStat'+i);
					$('<div />', {
						"class": 'Ev',
						html: response['evSa']+' ev <i class="fa fa-plus"></i>',
						"click": function(){
							if(!$('#InputStat_4').length){
								addEV("open",4,this,false,i);
							}
						}
					}).appendTo('#saStat'+i);
					$('<div />', {
						"class": 'Ev',
						html: response['evSd']+' ev <i class="fa fa-plus"></i>',
						"click": function(){
							if(!$('#InputStat_5').length){
								addEV("open",5,this,false,i);
							}
						}
					}).appendTo('#sdStat'+i);
					$('<div />', {
						"class": 'EvCount',
						html: 'Доступно <b>'+response['ev']+'</b> EV'
					}).appendTo('#StatsPokemon'+i);
				}else{
					Game.notifications.main('Ошибка. Попробуйте снова.',"error");
				}
			}
		});
	},
	buyThingsAquarits: function(t) {
		$.ajax({
			url:"/do/itemsAction",
			type:"POST",
			data:"itemID="+t+"&type=buyDonat",
			success:function(response){
				response = JSON.parse(response);
				Game.notifications.main((response['error'] == 0 ? 'Предмет удачно куплен.' : 'Недостаточно жемчуга.'),(response['error'] == 0 ? 'success' : 'error'));
			}
		});
	},
	setColor: function(t) {
		$.ajax({
			url:"/do/trainers",
			type:"POST",
			data:"type=setColor&color="+t,
			success:function(t){
				Game.notifications.main('Вы успешно изменили цвет.',"success");
			}
		});
	},
	trenercard: {
		opencard: function(n,c = false) {
			var modal = $('.mudol');
			modal.hide();
			if(c == false){
				c = 'trainercard';
			}
			if(modal.is(':hidden')){
				modal.show();
				Game.loaders.mudol();
				$.post('/do/trainers', {type: c, user: n}, function(response){
          $('<div />', {
						'class': 'Header',
            html: 'Тренеркарта',
					}).appendTo(modal);
          $('<div />', {
						'class': 'Close',
            html: '<i class="fa fa-close"></i>',
						'click': function(){
							modal.hide();
						}
					}).appendTo('.mudol .Header');
          $('<div />', {
						'class': 'Content',
					}).appendTo(modal);
          $('<div />', {
						'class': 'Trainercard',
					}).appendTo('.mudol .Content');
          if(response['clanUserCheck'] == 1) {
            $('<div />', {
              "class": 'ClanBlock',
              "click": function() {
                openClanCard(response['clanUser']);
              },
              "style": "background-image:url(/img/world/clans/"+response['clanUser']+".png)"
            }).appendTo('.Trainercard');
          }
          $('<div />', {
						'class': 'BallBlock',
					}).appendTo('.Trainercard');
          $.each(response['ballList'], function(x,y){
            $('<'+y['styleball']+' />', {
              "style": 'background-image: url('+y['typeball']+''+y['ball']+'.png);'
            }).appendTo('.BallBlock');
          });
          $('<div />', {
						'class': 'BigAvatar',
                       "style": 'background: url(/img/avatars/full/model/'+response['model']+'.png)no-repeat;',
					}).appendTo('.Trainercard');
          $('<div />', {
						'class': 'Information'
          }).appendTo('.Trainercard');
          $('<div />', {
						'class': 'UserInfo',
            html: function() {
              var tpl = '<div class="Position">'+response['region']+' <i class="fas fa-angle-right"></i> '+response['location']+'</div> <div class="TrainerBlock"><div class="Avatar" onclick=showUserTooltip("'+response['id']+'") style="background-image: url(/img/avatars/mini/'+response['miniIcon']+'.png);"> <div class="Status '+response['classOnl']+'"></div> </div> <div class="Title"><div class="Name"><div class="u-'+response['userGroup']+'">'+response['login']+'</div> </div><div class="Other u-'+response['userGroup']+'">'+response['rang']+'</div> </div></div>';
              return tpl;
            }
					}).appendTo('.Trainercard .Information');
          $('<div />', {
            "class": 'Status',
            "id": 'statusUser',
            html: '<div class="Text">'+response['status']+'</div>'
          }).appendTo('.Trainercard .Information');
          if(response['editStatus'] == 1){
            $('<div />', {
              html: '<i class="fa fa-pen-square"></i>',
              "class": 'Pen',
              "click": function() {
                editStatus(false,false,response['status']);
              }
            }).appendTo('#statusUser');
          }
          $('<div />', {
            "class": 'TimeOnl',
            html: 'В игре '+response['inGame']+''+response['lastGame']+''
          }).appendTo('.Trainercard .Information');
          $('<div />', {
            "class": 'Tabses'
          }).appendTo('.Trainercard .Information');
          $('<div />', {
            "class": 'Tabs',
            html: '<div style="color: #fff; background: #6c99ca;" id="trophyTab" onclick=setTrenerBlock("trophyBlock",this);>Награды</div> <div id="friendsTab" onclick=setTrenerBlock("friendBlock",this);>Друзья</div>'
          }).appendTo('.Tabses');
          $('<div />', {
            "class": 'Table',
            "id": 'trophyBlock'
          }).appendTo('.Tabses');
          $('<div />', {
            "class": 'Table',
            "id": 'friendBlock',
            "style": 'display:none'
          }).appendTo('.Tabses');
          $('<div />', {
            "class": 'Trophys',
            html: '<div class="Info">Турнирный рейтинг: '+response['classCount']+'</div>'
          }).appendTo('#trophyBlock');
          $('<div />', {
            "class": 'Friends',
            html: '<div class="Info">Друзей: '+response['friends']+'</div>'
          }).appendTo('#friendBlock');
          $.each(response['trophyList'], function(x,y){
            $('<div />', {
              "class": 'Trophy',
              "style": 'background-image: url(/img/world/items/little/'+y['trophy']+'.png)',
              "click": function() {
                issetAll(y['info'],'item');
              }
            }).appendTo('.Trophys');
          });
          $('.Friends').append(response['friendsList']);
          $('<div />', {
            "class": 'Statistics',
            html: '<div><span>'+response['dex']+'</span>покедекс</div><div><span>'+response['shineDex']+'</span>шайнидекс</div><div><span>'+response['shadowDex']+'</span>шедоудекс</div><div><span>'+response['pver']+'</span>PVE очки</div>'
          }).appendTo('.Trainercard');
					Game.loaders.mudolClose();
				}, 'json')
			}
		}
	},
	clan: {
		createClan: function() {
			$('.model').remove();
			Game.loaders.world();
			Game.modals.modelLoad('Создание клана');
			$('.Modal').remove();
			$('<div />', {
				'class': 'txtCM',
				html: 'Стоимость создания клана составляет <b>1.500.000 монет</b>. Заявка рассматривается около недели. Вы получите уведомление об удачном или неудачном создании клана. <br>Денежные средства снимутся после успешной заявки. Если заявка не пройдет модерацию, монеты будут возвращены.'
			}).appendTo('.content-model');
			$('<div />', {
				'class': 'createClan',
				html: "<input type='text' class='createClanInput' id='clanCreateName' placeholder='Название клана'><br><input id='clanCreateEmblem' type='text' class='createClanInput' placeholder='Ссылка на эмблему (100x100, png или jpg)'>"
			}).appendTo('.content-model');
			$('<div />', {
				'class': 'createClanBtn',
				'click': function() {
					btnCreateClan();
				},
				html: 'Подать заявку'
			}).appendTo('.createClan');
			Game.loaders.worldClose();
		}
	},
	random: {
		mainRand: function(min,max) {
			var rand = min + Math.random() * (max - min)
			rand = Math.round(rand);
			return rand;
		}
	},
	prize: {
		giveTreners: function(u,i) {
			$.ajax({
				url: "/do/gift",
				type: "POST",
				data: {
					user: u,
					id: i
				},
				success: function (response) {
					response = JSON.parse(response);
					var a = (response['errorText'] == 1 ? 'Не хватает жемчуга.' : 'Вы удачно отправили подарок.');
					Game.notifications.main(a,response['error']);
				}
			});
	},
    dayPrize: function() {
      $('.model').remove();
      Game.loaders.world();
      Game.modals.modelLoad('Подарки');
      $.post('/do/dayGift', function(data){
        
        $('<div />', {'class': 'gifts'}).appendTo('.content-model');
        $('<div />', {
          'class' : 'main',
          'html'  : '<div class="gift"><i class="fa fa-gift"></i></div><p>Ежедневно вы можете получить случайный предмет из списка:</p>'
        }).appendTo('.gifts');
        
        $('<div />', {'class': 'giftRoll'}).appendTo('.gifts');
        $('<div />', {'class': 'wrapGift'}).appendTo('.giftRoll');
        $('<ul />', {'class': 'innerGift'}).appendTo('.wrapGift');
        
        $.each(data.list, function(){
          var idItem = this.id;
          $('<div />', {
            'class' : 'itemIsset',
            'style' : 'background-image: url(/img/world/items/little/'+idItem+'.png)',
            'click' : function(){
              issetAll(idItem, 'item');
            }
          }).appendTo('.main');
        });
        
                
        $('<span />', {'class': 'mark'}).appendTo('.wrapGift');
        $('<div />', {'class': 'goRoll'}).appendTo('.gifts');
        
        if(data.carusel !== 0){
          $.each(data.carusel, function(){    
            $('<li />', {'html': '<img src="/img/world/items/little/'+this.id+'.png">'}).appendTo('.innerGift');
          });
          
          $('<div />', {
            'class' : 'mn-btn',
            'html'  : 'Получить подарок',
            'click' : function() {
              $.post('/do/dayGiftAcion', function(response){ scrollGift(response); }, 'json');
            }
          }).appendTo('.goRoll');
          
        }else{
          $('.goRoll').html('<p style="color: #a2a2a2;">Сегодня вы уже получали свой ежедневный подарок.</p>'); 
        }

        
      }, 'json');
      
      Game.loaders.worldClose();
    }
  },
	autoLoadAtWorld: function() {
		Game.notifications.count();
    $('<div />', {
			"class": 'Button Smiles el_smile',
			html: '<i class="fas fa-smile"></i>'
		}).appendTo('.MiniButtons');

    $('<div />', {
			"class": 'Button el_clear_chat',
			html: '<i class="fas fa-eraser"></i>',
			'click': function() {
				$('.Message-Block').html('');
			}
		}).appendTo('.MiniButtons');

    $('<div />', {
			"class": 'Button NoActive Dex el_dex',
			html: 'dex',
      'click': function() {
        openDex(1);
      }
		}).appendTo('.DivRightButtons .Wrap');


    $('<div />', {
			"class": 'Button NoActive el_market',
			html: '<i class="fas fa-gavel"></i>',
      'click': function() {
        openMarket();
      }
		}).appendTo('.DivRightButtons .Wrap');

    $('<div />', {
			"class": 'Line'
		}).appendTo('.DivRightButtons .Wrap');

    $('<div />', {
			"class": 'Button NoActive el_wild',
			html: '<i class="fas fa-paw"></i>',
      'click': function() {
        setHunt(this);
      }
		}).appendTo('.DivRightButtons .Wrap');

    $('<div />', {
			"class": 'Button NoActive el_fight',
			html: '<i class="fas fa-eye"></i>',
      'click': function() {
        setFight();
      }
		}).appendTo('.DivRightButtons .Wrap');
	},
	loadAtWorld: function() {
		$.ajax({
			url: "/do/init",
			type: "POST",
			success: function (response) {
				response = JSON.parse(response);
				if(response['data']['bonusMoney'] != '1'){
					$('<div />', {
						'id': 'moneyBonusTime',
						html: '<i class="fa fa-database"></i><div>x'+response['data']['bonusMoneyReit']+'</div>',
					}).prependTo('.Reits');
					Tipped.create('#moneyBonusTime', 'Дроп монет х'+response['data']['bonusMoneyReit']+'. Закончится '+moment(response['data']['bonusMoney'],'YYYYMMDDhmmss').calendar());
				}
				if(response['data']['bonusDrop'] != '1'){
					$('<div />', {
						'id': 'dropBonusTime',
						html: '<i class="fa fa-briefcase"></i><div>x'+response['data']['bonusDropReit']+'</div>',
					}).prependTo('.Reits');
					Tipped.create('#dropBonusTime', 'Дроп предметов х'+response['data']['bonusDropReit']+'. Закончится '+moment(response['data']['bonusDrop'],'YYYYMMDDhmmss').calendar());
				}
				if(response['data']['bonusExp'] != '1'){
					$('<div />', {
						'id': 'expBonusTime',
						html: '<i class="fa fa-graduation-cap"></i><div>x'+response['data']['bonusExpReit']+'</div>',
					}).prependTo('.Reits');
					Tipped.create('#expBonusTime', 'Опыт х'+response['data']['bonusExpReit']+'. Закончится '+moment(response['data']['bonusExp'],'YYYYMMDDhmmss').calendar());
				}
				if(response['data']['bonusVolera'] != '1'){
					$('<div />', {
						'id': 'voleraBonusTime',
						html: '<i class="fa fa-home"></i><div>x'+response['data']['bonusVoleraReit']+'</div>',
					}).prependTo('.Reits');
					Tipped.create('#voleraBonusTime', 'Встретить покемонов из вольера Богатого поместья х'+response['data']['bonusVoleraReit']+'. Закончится '+moment(response['data']['bonusVolera'],'YYYYMMDDhmmss').calendar());
				}
				if(response['data']['bonusUnik'] != '1'){
					$('<div />', {
						'id': 'unikBonusTime',
						html: '<i class="fa fa-star"></i><div>x'+response['data']['bonusUnikReit']+'</div>',
					}).prependTo('.Reits');
					Tipped.create('#unikBonusTime', 'Встретить Shine и Shadow х'+response['data']['bonusUnikReit']+'. Закончится '+moment(response['data']['bonusUnik'],'YYYYMMDDhmmss').calendar());
				}
							$('<div />', {
											'class': 'Text',
											html: ' <div class="u-'+response['data']['user_group']+'">'+response['data']['login']+'</div> <span>'+response['data']['rang']+'</span>'
										}).prependTo('.TopMenu .LeftMenu');
										$('<div />', {
														'class': 'Avatar',
														'style': 'background-image: url(/img/avatars/mini/'+response['data']['img']+'.png)'
													}).prependTo('.TopMenu .LeftMenu');
							Tipped.create('.TopMenu .LeftMenu .Avatar',function(element){return{title:response['data']['login'],content:'<a onclick="Game.trenercard.opencard(\''+LOGIN+'\');">Тренеркарта</a><br><a onclick="settings();">Настройки профиля</a><br><a href="Dont_work" target="_blank">Покепедия</a><br><a href="http://leagueonline.forum2.net/" target="_blank">Форум</a><br><a href=".." target="_blank">Главная страница</a><br><a href="/?route=exit">Выход</a>'};});
			}
		});
	},
	loaders: {
		main: function() {
			$(".preloader").find('span').html(Lang.loader_load);
			$("#locationPreloader").delay(500).fadeOut(200);
		},
		world: function() {
			$('.loadWorld').fadeIn(0);
		},
		worldClose: function() {
			$('.loadWorld').fadeOut(100);
		},
		mudol: function() {
			$('.mudol').html('<center id="mainLoader">'+mainLoader+'</center>');
		},
		mudolClose: function() {
			$('#mainLoader').remove();
		}
	},
	notifications: {
		main: function(a,b){
			var rand = Game.random.mainRand(1,1000000),
				rand = 'notyId'+rand,
				icon;
			if(b == 'success'){
				icon = 'check';
			}else if(b == 'error'){
				icon = 'close';
			}else if(b == 'info' || b == 'admin' || b == 'version'){
				icon = 'info';
			}else if(b == 'warning'){
				icon = 'exclamation-triangle';
			}else if(b == 'plus'){
				icon = 'plus';
			}else if(b == 'minus'){
				icon = 'minus';
			}else if(b == 'quest'){
				icon = '';
			}
			$('<div />', {
				"class": 'noty '+b,
				"id": rand,
				html: '<div class="icon"><i class="fa fa-'+icon+'"></i></div> <div class="text">'+a+'</div>',
				"click": function() {
					$('#'+rand).fadeOut(500, function() {
						$('#'+rand).remove();
					});
				}
			}).appendTo('.DivNotification');
			setTimeout(function() {
				$('#'+rand).fadeOut(500, function() {
					$('#'+rand).remove();
				});
			}, 10000);
		},
		count: function() {
			$.ajax({
				url: "/do/notifications",
				type: "POST",
				data: "type=count",
				success: function (data){
					$('#countNotif').html(data);
					if($('#countNotif').html() > 0){
						$('.TopMenu .RightMenu .Buttons span').css('background','#e37d72');
					}else{
						$('.TopMenu .RightMenu .Buttons span').css('background','#f3f3f3');
					}
				},
				complete: function(){
					setTimeout(function(){
						Game.notifications.count();
					}, 3000);
				}
			});
		}
	},
  init: function(){

    if(REITS == 1) {
      $('.DivNotification').append('<div class="noty reits" onclick=$(this).fadeOut(500);><div class="icon"><i class="fa fa-star"></i></div> <div class="text">'+REITS_TEXT+'</div></div>');
    }

		Aqua.loaders.main('');
		Game.updateUserLocation();
		updateLocation();

		Game.autoLoadAtWorld();
		Game.loadAtWorld();
		Game.title_tooltip();
	}
}

function submitResponse(user,type,data){
    $('.BlockOtherContent').hide();
    if(type == 'friend' || type == 'clan'){
        $('.BlockOtherContent').removeClass('updated');
    }
    $.ajax({
        url: "/do/submitResponse",
        type: "POST",
        data: {
            type: type,
            data: data,
            user: user
        },
        success: function (response) {
            response = JSON.parse(response);
            if(response['error'] == 1){
                Game.notifications.main(response['text'],'error');
            }else{
                Game.notifications.main(response['text'],'success');
                if(response['type'] == 'trade'){
                    openTrade();
                }
            }
        }
    });
}
function nursery(type, basenum = false, e = false, sort = false){
    if(type=="back"){
        $('.pok-2').remove();
        $('.back').remove();
        $('#sortNursery').remove();
        $('.pok-1').show();
    }else if(type=="open"){
        $.ajax({
            url: "/do/modal",
            type: "POST",
            data: "type=nurseryList&basenum="+basenum+"&sort="+sort,
            beforeSend: function(){
                $('.pok-1').hide();
            },
            success: function (response) {
                response = JSON.parse(response);
                var tpl = '<form id="sortNursery"><select><option disabled selected style="background: graytext; color: #000000b3;">'+Lang.pit_select_main+'</option><optgroup label="'+Lang.pit_select_lvl+'"><option value="0">&darr;</option><option value="1">&uarr;</option></optgroup><optgroup label="'+Lang.pit_select_spar+'"><option value="2">'+Lang.pit_select_spar_no+'</option><option value="5">'+Lang.pit_select_spar_yes+'</option></optgroup><optgroup label="'+Lang.pit_select_sex+'"><option value="3">'+Lang.pit_select_sex_m+'</option><option value="4">'+Lang.pit_select_sex_d+'</option></optgroup></select></form><div class="back" onclick=nursery("back");>&lt;&lt; '+Lang.button_back+'</div>';
                tpl+= '<div class="pok-2">';
			$.each(response['html'], function(x,y){
				gen = y['gen'].split(',');
				tpl += '<div onclick=nursery("tooltip",'+y['id']+',this);>'; // Раз
				tpl += '<img src="/img/pokemons/mini/'+y['type']+'/'+y['basenum']+'.png">';
				tpl += '<div class="nameNur '+y['type']+'-color">#'+y['basenum']+' '+y['name']+' <b>'+y['lvl']+''+Lang.abb_lvl+'</b></div>';
				tpl += '<span>'+y['gender']+' '+(y['sparka']==0?Lang.text_spar_yes:Lang.text_spar_no)+'('+y['sparkaNumber']+')';
				tpl += '<br>h'+gen[0]+'a'+gen[1]+'d'+gen[2]+'s'+gen[3]+'sa'+gen[4]+'sd'+gen[5]+'</span>';
				tpl += ''+Lang.text_character+': '+y['character']+'</div>';
			});
            tpl+= '</div>';
            $('.pit').append(tpl);
				if(sort){
					$("select [value='"+sort+"']").attr("selected", "selected");
				}
				$('select').on('change', function (){
					$('.pok-2').remove();
					$('.back').remove();
					$('#sortNursery').remove();
					nursery("open",basenum,false,this.value);
				});
            }
        });
    }else if(type=="search"){
        var search = $('#pitInput').val();
        if(search==''){
            return Game.notifications.main(Lang.text_query_null);
        }
        $.ajax({
            url: "/do/Npc/nursery",
            type: "POST",
            data: "search="+search,
            success: function (response) {
				response = JSON.parse(response);
                $('.back').remove();
                $('.pok-2').remove();
                $('.pok-1').hide();
                var tpl = '<div class="back" onclick=nursery("back");>&lt;&lt; '+Lang.button_back+'</div>';
                tpl+= '<div class="pok-2">';
				if(response['error'] == 1){
					tpl+= '<center>'+Lang.text_category_null+'</center>';
				}else{
					$.each(response['pokList'], function(x,y){
						gen = y['gen'].split(',');
						tpl += '<div onclick=nursery("tooltip",'+x+',this);>';
						tpl += '<img src="/img/pokemons/mini/'+(y['type'] != 'normal' ? 'shine' : 'normal')+'/'+y['basenum']+'.png">';
						tpl += '<div class="nameNur '+y['type']+'-color">#'+y['basenum']+' '+y['name']+' <b>'+y['lvl']+''+Lang.abb_lvl+'</b></div>';
						tpl += '<span>'+y['gender']+' '+(y['sparka']==0?Lang.text_spar_yes:Lang.text_spar_no)+'('+y['sparkaNumber']+')';
						tpl += '<br>h'+gen[0]+'a'+gen[1]+'d'+gen[2]+'s'+gen[3]+'sa'+gen[4]+'sd'+gen[5]+'</span>';
						tpl += ''+Lang.text_character+': '+y['character']+'</div>';
					});
				}
                tpl+= '</div>';
                $('.pit').append(tpl);
            }
        });
    }else if(type=="tooltip"){
        $('.GiveDiv').remove();
        var tpl = '<div class="GiveDiv">';
        tpl+= '<div id="DivAbout">'+Lang.text_info+'</b></div>';
        tpl+= '<div class="wrap"><div class="PokList">';
        tpl+= '<div class="PokBtn" onclick=nursery("get",'+basenum+');>'+Lang.button_take_pokemon_pit+'</div>';
        tpl+= '</div></div></div>';
        $(tpl).appendTo('body');
        var position = $(e).position();
        var offset = $(e).offset();
        var left = Math.round(offset.left+30);
        var top = Math.round(offset.top+15);
        $('.GiveDiv').css({
            "left": left+'px',
            "top": top+'px'
        });
    }else if(type=="get"){
        $.ajax({
            url: "/do/modal",
            type: "POST",
            data: "type=nurseryGet&basenum="+basenum,
            beforeSend: function(){
                $('.pok-1').hide();
            },
            success: function (response) {
                response = JSON.parse(response);
                if(response['error'] == 1){
                    Game.notifications.main(response['html'],'error');
                }else{
                    Game.notifications.main(response['html'],'success');
                    $('.back').remove();
                    $('.pok-2').remove();
                    $('#sortNursery').remove();
                    nursery('open',response['basenum']);
                }
            }
        });
    }else{

    }
}
function updateLocation(){
	$.post('/do/updateLocation', {userAssault: assault}, function(data){
		tplLoc = [], tplNpc = [];
		$.each(data.roads, function(key, val){
			tplLoc.push(
				$('<div />', {
					'html': val['name'],
          'class': (val['event'] == 1 ? 'active' : ''),
					'click': function(){
						goLocation(val['id']);
					}
				})
			);
		});
		$.each(data.npc, function(key, val){
      if(val.name) {
        tplNpc.push(
  				$('<div />', {
  					'html': val['name'],
            'class': (val['event'] == 1 ? 'active' : ''),
  					'click': function(){
  						NpcDialog(val["id"],false);
  					}
  				})
  			);
      }
		});
		$('.DivMap .Center .Name div').html(data.name);
		$('.ImageLoc .About .Text').html(data.description);
		$('.DivMap .Right .Steps').html(tplNpc);
    $('.DivMap .Right .Steps').append(data.pc);
		$('.DivMap .Left .Steps').html(tplLoc);

		(data.pokAtLocation == 1 ? $('.DivMap .Center .Other div').css('color','#b34d4d') : $('.DivMap .Center .Other div').css('color','#646464'));
    if(data.img > 0) {
      $('.DivMap .Center .ImageLoc').css('backgroundImage','url(/img/world/location/'+data.img+'.png)');
      //$('.ImageLoc .About').css('display','none');
    }else{
      $('.DivMap .Center .ImageLoc').css('backgroundImage','url(/img/world/location/unknown.png)');
      //$('.ImageLoc .About').css('display','block');
    }
    $('.DivNpcBlock').remove();
		$('.model').remove();

		if(data.usersDefNotice){
			updNoticeDef(data.usersDefNotice);
		}

		if(ClassInfo){

			ClassInfo._upUsrLoc(data.usersAtLocation, (data.usersAtNotice || null));

			if(data.server_ver){
				ClassInfo._upVer(data.server_ver);
			}

		}

		if(data.battleInfo){
			if(!ClassBattle){
				ClassBattle = new GameBattle(data.battleInfo);
			}else{
				ClassBattle._open(data.battleInfo);
			}
		}

		if(data.tradeInfo){
			if(!ClassTrade){
				ClassTrade = new Trade(data.tradeInfo);
			}else{
				ClassTrade._parseData(data.tradeInfo);
			}
		}else{
			if(ClassTrade){
				ClassTrade._close(false);
				ClassTrade = null;
			}
		}
	}, 'json')
}

function openModal(type,id) {
	var modal = $('.Modal');
	$('.BlockOtherContent').hide();
    modal.remove();
    $.ajax({
        url: "/do/modal",
        type: "POST",
        data: "type="+type+"&pokID="+id,
		beforeSend: function(){
      Game.loaders.world();
      $('.Modal').remove();
			$("<div/>", {
					"class": "Modal"
      }).appendTo("body");
        Game.loaders.world();
		},
        success: function (response) {
				response = JSON.parse(response);
				var offset = $('.MidMenu').offset();
				var left = Math.round(offset.left);
				if(type == 'trainers'){
					var leftA = left + 310;
				}else if(type == 'craft' || type == 'discovery'){
					var leftA = left + 383;
				}
                $('.Modal').css('left',leftA+'px');
				$('.Modal').append(response["html"]);
				if(type == 'pokemons'){
					goPok(id);
				}
        Game.loaders.worldClose();
        }
    });
}
function editInfo(type, other = false){
	switch(type){
		case 'pass':
			var oldPass = $('#oldPass').val(),
				newPass = $('#newPass').val(),
				dblNewPass = $('#dblNewPass').val();
			if(oldPass == newPass){
				return Game.notifications.main(Lang.error_password_is_used, "error");
			}else if(newPass !== dblNewPass){
        return Game.notifications.main(Lang.error_password_do_not_match, "error");
			}else if($('#oldPass').length == 0 || $('#dblNewPass').length == 0 || $('#newPass').length == 0){
        return Game.notifications.main('Поля не должны оставаться пустыми', "error");
			}else{
				$.post('/do/edit', {type: type, pass: oldPass, newPass: newPass, dblNewPass: dblNewPass}, function(data){
					if(data.error == 1){
						return Game.notifications.main(data.text);
					}else{
						$('#oldPass').val('');
						$('#newPass').val('');
						$('#dblNewPass').val('');
						Game.notifications.main(Lang.success_password_changed, "success");
					}
				}, 'json')
			}
			break;
		case 'closeNotifyAdmin':
			$.post('/do/edit', {type: type, idNotify: other}, function(data){
				$('.notya-'+other+'').remove();
			}, 'json')
			break;
      case 'editSound':
  			$.post('/do/edit', {type: type, set: other}, function(data){
  				UserAudio = other;
  				settings();
  			}, 'json')
  			break;
        case 'editColor':
    			$.post('/do/edit', {type: type, set: other}, function(data){
    				Game.notifications.main('Цвет успешно изменен.', "success");
    				settings();
    			}, 'json')
    			break;
          case 'editTeam':
      			$.post('/do/edit', {type: type, set: other}, function(data){
      				Game.notifications.main('Изменения прошли успешно.', "success");
      				settings();
      			}, 'json')
      			break;
		//case 'editSprite':
		//	$.post('/do/edit', {type: type, set: other}, function(data){
		//		UserAudio = other;
		//		settings();
		//	}, 'json')
		//	break;
	}

}
function editLang(lang){
	$.ajax({
		url: "/do/edit",
		type: "POST",
		data: "type="+lang,
		success: function (response) {
			response = JSON.parse(response);
			Game.notifications.main(Lang.success_edit_lang, 'success');
		}
	});
}
function itemOpen(e,typeM,item_id,name,description,id,count,weight,use,dress,drop,trade,give,type=false,status=false,egg,npc){
	var tlp = $('.tooltip'),
  e = window.event,
  element = $(e),
  left = (e.clientX - 134),
  top = (e.clientY + 15);
  if(left < 0) {
    left = 0;
  }
  $(tlp).css({
      "left": left+'px',
      "top": top+'px'
  });
    tlp.html('<center>'+mainLoader+'</center>');

    var tpl = [], el_count = element.find('.Count');

    count = (el_count.length ? el_count.text() : count);

    tpl.push('<div class="Name">'+name+' ('+count+' шт.)</div>');
    tpl.push('<div class="Image"><img id="imgItem" src="/img/world/items/big/'+id+'.png"></div>');
    tpl.push('<div class="About">'+description+'<br><span class="id_item_ab">id предмета: '+id+'</span></div>');

    var tpl_t_g = [], countItemInput;

    if(drop === true || dress === true || give === true){
        countItemInput = $('<input />', {
            'id':'countItemInput',
            'type':'number',
            'value':'1',
            'placeholder':Lang.text_count
        });
        tpl_t_g.push(countItemInput);
    }

    if(egg){
        countItemInput = $('<input />', {
            'id':'countItemInput',
            'type':'number',
            'value':'1',
            'placeholder':Lang.text_count
        });
    }

    if(give === true){
        tpl_t_g.push('<div onclick=\'itemAction('+id+',"give","'+name+'","'+typeM+'");\'>'+Lang.button_item_pokemon+'</div>');
    }
    if(dress === true){
        tpl_t_g.push(
            $('<div />', {
                'html':Lang.button_item_dress,
                'click':function(){
                    itemAction(item_id, 'dress', name,''+typeM+'');
                }
            })
        );
    }
    if(use === true){
        tpl_t_g.push('<div onclick=itemAction('+id+',"use",false,"'+typeM+'");>'+Lang.button_item_use+'</div>');
    }
    if(trade === true && !egg) {
      tpl_t_g.push('<div onclick=market_go('+item_id+',"stavka_item");>Выставить на аукцион</div>');
    }
    if(drop === true && !isTrade){
        tpl_t_g.push('<div onclick=itemAction('+item_id+',"drop",false,"'+typeM+'");>'+Lang.button_drop+'</div>');
    }else if(egg){
		tpl_t_g.push('<div onclick=itemAction('+item_id+',"dropEgg",false,"'+typeM+'");>'+Lang.button_drop_egg+'</div>');
    tpl_t_g.push('<div onclick=itemAction('+item_id+',"incubEgg",false,"'+typeM+'");>Использовать инкубатор</div>');
    tpl_t_g.push('<div onclick=market_go('+item_id+',"stavka_egg");>Выставить на аукцион</div>');
		(npc > 0) ? tpl_t_g.push('<div onclick=itemAction('+item_id+',"giveEgg");>'+Lang.button_item_npc_give+'</div>') : '';
	}
  if(!egg && npc > 0) {
    tpl_t_g.push('<div onclick=itemAction('+item_id+',"giveEgg",true);>'+Lang.button_item_npc_give+'</div>');
  }
    if((trade === true || trade === 'true') && status == 'trade'){
        if(ClassTrade){
            tpl_t_g.push(
                $('<div />', {
                    'html':Lang.button_trade_add,
                    'click':function(){
                        Game.modals.inventory('all');
                        if(ClassTrade && countItemInput){
                            var countTrade = parseInt(countItemInput.val());
                            ClassTrade._addObject((egg ? 'egg' : 'item'), item_id, countTrade,
                                function(){
                                    if(element && element.length){
                                        var eCount = parseInt(element.find('span').text());
                                        if(eCount > 0){
                                            eCount -= countTrade;
                                            if(eCount > 0){
                                                element.find('span').html(eCount);
                                                return true;
                                            }
                                        }
                                        element.remove();
                                    }
                                }, function(){
                                    tlp.hide();
                                }
                            );
                        }
                    }
                })
            );
        }
    }

    tpl.push(
        $('<div />', {
            'class':'Buttons'
        }).append(
            tpl_t_g
        )
    );
    tlp.empty().append(tpl).show();
}
function renamePok(type,e,id,name){
    if(type == "open"){
      $('<div />', {
        "class": 'MiniModal',
        html: function() {
          var tpl = '';
          tpl += '<div class="Name" id="drgMini">Дать имя покемону</div>';
          tpl += '<div class="Content">';
          tpl += '<div class="Settings"><div class="Step"><input placeholder="'+Lang.text_name_it+'" type="text" maxlength="15" onkeydown="if(event.keyCode == 13){renamePok(\'rename\',this,'+id+',$(this).val());}"></div></div>'
          tpl += '</div>';
          return tpl;
        }
      }).appendTo('body');
      $('.MiniModal').draggabilly({
        handle: '#drgMini',
        containment: true
      });
        $('#namePokemon'+id).html('<input placeholder="'+Lang.text_name_it+'" type="text" maxlength="15" onkeydown="if(event.keyCode == 13){renamePok(\'rename\',this,'+id+',$(this).val());}">').focus();
        $('#namePokemon'+id+' input').focus();
    }else{
        if(name < 1 || name > 15){
            Game.notifications.main(Lang.error_name_it,"error");
        }else{
            $.ajax({
                url: "/do/pokemonsAction",
                type: "POST",
                data: {
                    pokID: id,
                    type: 'renamePok',
                    name: name
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if(response['error'] == 1){
                        Game.notifications.main(response['text'],'error');
                    }else{
                        Game.notifications.main(response['text'],'success');
                        $('#namePokemon'+id).html(response['name']);
                        $('.MiniModal').remove();
                        Game.modals.pokemons();
                    }
                }
            });
        }
    }
}

function deletePok(id){
    if(confirm(Lang.confirm_drop_pokemon)){
        $.ajax({
            url: "/do/pokemonsAction",
            type: "POST",
            data: {
                pokID: id,
                type: 'deletePok'
            },
            success: function (response) {
                response = JSON.parse(response);
                if(response['error'] == 1){
                    Game.notifications.main(response['text'],'error');
                }else{
                    Game.notifications.main(response['text'],'success');
                    Game.notifications.main('<img src="/img/pokemons/anim/normal/'+response['pokId']+'.gif"> '+response['pokName']+'','minus');
                    closeModal();
                }
            }
        });
    }else{
        return false;
    }
}
function putPok(id){
    $.ajax({
        url: "/do/pokemonsAction",
        type: "POST",
        data: {
            pokID: id,
            type: 'putPok'
        },
        success: function (response) {
            response = JSON.parse(response);
            if(response['error'] == 1){
                Game.notifications.main(response['text'],'error');
            }else{
                Game.notifications.main(response['text'],'success');
                Game.modals.pokemons();
            }
        }
    });
}
function npcGiveItem(id,npc,type=false){
	var ctg = (type == false ? "egg" : "item");
    $.ajax({
        url: "/do/npcGiveItem",
        type: "POST",
        data: {
            npc: npc,
            category: ctg,
			id: id
        },
        success: function (response) {
            response = JSON.parse(response);
            if(response['minus']) {
              Game.notifications.main(response['minus'],'minus');
            }
            if(response['plus']) {
              Game.notifications.main(response['plus'],'plus');
            }
            if(response['text']) {
            Game.notifications.main(response['text'],response['error']);
            }
			Game.modals.inventory('all');
        }
    });
}

function pokAction(e,id,start,newName,num){
    $('.GiveDiv').remove();

    var elm = $('<div />', {'class':'GiveDiv'});

    var tpl = [];

    tpl.push('<div id="DivAbout">'+Lang.text_info+'</b></div>');

    tpl.push(
        $('<div />', {'class':'wrap'}).append(
            $('<div />', {'class':'PokList'}).append(
                (ClassTrade ?  $('<div />', {
                    'class':'PokBtn',
                    'html':Lang.button_trade_add,
                    'click': function(){
                        if(ClassTrade){
                            ClassTrade._addObject('poke', id, 1,
                                function(){
                                    $('#pokeTeam_'+id).remove();
                                    Game.modals.pokemons();
                                }, function(){
                                    elm.remove();
                                }
                            );
                        }
                    }
                }) : ''),
                '<div class="PokBtn" onclick=openDex('+num+')>'+Lang.button_pokedex+'</div>',
                '<div class="PokBtn" onclick=market_go('+id+',"stavka_pokemon")>Выставить на аукцион</div>',
                '<div class="PokBtn" onclick=renamePok("open",this,'+id+');>'+Lang.button_pokemon_name_add+'</div>',
                '<div class="PokBtn" onclick="putPok('+id+');">'+Lang.button_drop_pokemon_pit+'</div>',
                '<div class="PokBtn" onclick=wentPok('+id+');>'+Lang.button_pokemon_walk+'</div>',
                (start == 0 ? '<div class="PokBtn" onclick="setStart('+id+');">'+Lang.button_pokemon_start+'</div>' : ''),
                '<div class="PokBtn" onclick="deletePok('+id+');">'+Lang.button_let_go+'</div>'
            )
        )
    );

    elm.empty().append(tpl);

    elm.appendTo('body');

    positionElement(e, elm[0]);
}
function itemAction(id,type,name,typeM,pok){
    $('.GiveDiv').remove();
    var count = ($('#countItemInput').val()?$('#countItemInput').val():1);
    if(type == 'giveEgg'){
		$('.GiveDiv').remove();
        var tpl = '<div class="GiveDiv">';
        tpl+= '<div id="DivAbout"><b>'+Lang.text_npc_add_item+'</b></div>';
        tpl+= '<div class="wrap"><div class="PokList">';
		$.ajax({
            url: "/do/modal",
            type: "POST",
            data: 'type=giveEggNpc',
            success: function (response) {
				response = JSON.parse(response);
                if(!response['error']){
                    var NPC = '';
                    $.each(response['npc'], function(x,y){
                        NPC += '<div class="PokeUse" onMouseOver="$(this).css(\'background\',\'#e8e8e8\');" onclick="npcGiveItem('+id+','+y['id']+','+name+');"><div class="NameUse" style="padding: 5px;color: #5f5f5f;">'+y['name']+'</div></div>';
                    });
                    tpl += NPC;
                }
                tpl+= '</div></div></div>';
                $(tpl).appendTo('body');
                var position = $('.tooltip').position();
                var offset = $('.tooltip').offset();
                var left = Math.round(offset.left)+20;
                var positionTop = Math.round(position.top/100);
                var top = Math.round(offset.top+(position.top/positionTop)+100);
                $('.GiveDiv').css({
                    "left": left+'px',
                    "top": top+'px'
                });
            }
        });
	}else if(type == 'give' || type == 'dress'){
        if(type == 'give'){
            var typeAction = 'GivePok';
            var Action = Lang.button_item_use;
        }else{
            var typeAction = 'DressPok';
            var Action = Lang.button_item_dress;
        }
        $('.GiveDiv').remove();
        var tpl = '<div class="GiveDiv">';
        tpl+= '<div id="DivAbout">'+Action+' <b>'+name+'</b></div>';
        tpl+= '<div class="wrap"><div class="PokList">';
        $.ajax({
            url: "/do/itemsAction",
            type: "POST",
            data: 'type=pokList',
            success: function (response) {
                if(response != 0){
                    response = JSON.parse(response);
                    var team = '';
                    $.each(response['pokList'], function(x,y){
                        team+= '<div class="PokeUse '+y['class']+'" onclick=itemAction('+id+',"'+typeAction+'",false,"'+typeM+'",'+y['id']+');><img src="/img/pokemons/mini/'+y['type']+'/'+y['basenum']+'.png"></img> <div class="NameUse '+y['type']+'-color">#'+y['basenum']+' '+y['name']+'</div></div>';
                    });
                    tpl+=team;
                }
                tpl+= '</div></div></div>';
                $(tpl).appendTo('body');
                var position = $('.tooltip').position();
                var offset = $('.tooltip').offset();
                var left = Math.round(offset.left)+10;
                var positionTop = Math.round(position.top/100);
                var top = Math.round(offset.top+(position.top/positionTop)+100);
                $('.GiveDiv').css({
                    "left": left+'px',
                    "top": top+'px'
                });
            }
        });
    }else if(type == 'eggDrop'){
			$.ajax({
		url: "/do/itemsAction",
            type: "POST",
            data: {
                itemID: id
            },
            beforeSend: function(){
                $('.tooltip').hide();
            },
			success: function (response) {
				Game.notifications.main(response['text'],'success');
			}
		});
	}else{
        $.ajax({
            url: "/do/itemsAction",
            type: "POST",
            data: {
                itemID: id,
                type: type,
                count: count,
                pokID: pok
            },
            beforeSend: function(){
                $('.tooltip').hide();
            },
            success: function (response) {
                response = JSON.parse(response);
                if(response['text'] && response['error'] == 0){
					if(id == 7 && type == 'GivePok' || id == 9 && type == 'GivePok' || id == 8 && type == 'GivePok'){
						$('body').append('<div class="animationImage"><div class="eat"></div></div>');
						setTimeout(function(){
							$( ".animationImage" ).fadeOut( "slow", function() {
								$('.animationImage').remove();
								Game.notifications.main(response['text'],'success');
							});
						}, 2000);
					}else if(type == 'GivePok' && id > 18 && id < 24 || type == 'GivePok' && id > 24 && id < 29 || type == 'GivePok' && id > 33 && id < 37 || type == 'GivePok' && id > 50 && id < 54 || type == 'GivePok' && id > 64 && id < 75 || type == 'GivePok' && id > 95 && id < 101){
						if(response['other'] != 0){
              if(response['other'] <= 9) {
                var ip = '00'+response['other'];
              }else if(response['other'] >= 10 && response['other'] <= 99) {
                var ip = '0'+response['other'];
              }else{
                var ip = response['other'];
              }
              if(response['other2'] <= 9) {
                var ip2 = '00'+response['other2'];
              }else if(response['other2'] >= 10 && response['other2'] <= 99) {
                var ip2 = '0'+response['other2'];
              }else{
                var ip2 = response['other2'];
              }
							$('body').append('<div class="animationImage"><div class="evol" style="background-image: url(/img/pokemons/full/normal/'+ip+'.png);"></div></div>');
							$( ".animationImage .evol" ).fadeOut(3000, function() {
								$('.evol').remove();
							});
							setTimeout(function(){
									$('.animationImage').append('<div class="evol" style="background-image: url(/img/pokemons/full/normal/'+ip2+'.png);"></div>');
									setTimeout(function(){
										$('.animationImage').remove();
										Game.notifications.main(response['text'],'success');
									}, 3000);
							}, 3100);
						}else{
							Game.notifications.main(response['text'],'success');
						}
					}else if(id == 95 && type == 'GivePok'){
						if(response['other'] == 0){
							Game.notifications.main(response['text'],'success');
						}else{
							$('body').append('<div class="animationImage"><div class="pika"></div><div class="tren"><div class="text" style="display:none;">'+Lang.text_fail+'</div><div class="a">'+Lang.stat[2]+'</div><div class="d">'+Lang.stat[3]+'</div><div class="s">'+Lang.stat[4]+'</div><div class="sa">'+Lang.stat[5]+'</div><div class="sd">'+Lang.stat[6]+'</div></div></div>');
								function getRandomFloat(min, max) {
									return Math.random() * (max - min) + min;
								}
								if(response['other'] == 1){
									setTimeout(function () { $(".tren .d").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .s").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sa").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sd").fadeOut("slow"); }, getRandomFloat(1000,8000));
								}else if(response['other'] == 2){
									setTimeout(function () { $(".tren .a").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .s").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sa").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sd").fadeOut("slow"); }, getRandomFloat(1000,8000));
								}else if(response['other'] == 3){
									setTimeout(function () { $(".tren .a").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .d").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sa").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sd").fadeOut("slow"); }, getRandomFloat(1000,8000));
								}else if(response['other'] == 4){
									setTimeout(function () { $(".tren .a").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .s").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .d").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sd").fadeOut("slow"); }, getRandomFloat(1000,8000));
								}else if(response['other'] == 5){
									setTimeout(function () { $(".tren .a").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .s").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sa").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .d").fadeOut("slow"); }, getRandomFloat(1000,8000));
								}else if(response['other'] == 6){
									setTimeout(function () { $(".tren .a").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .d").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .s").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sa").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .sd").fadeOut("slow"); }, getRandomFloat(1000,8000));
									setTimeout(function () { $(".tren .text").fadeIn("slow"); }, 8000);
								}
								setTimeout(function(){
									$( ".animationImage" ).fadeOut( "slow", function() {
										$('.animationImage').remove();
										Game.notifications.main(response['text'],'success');
									});
								}, 9000);
						}
					}else{
					    if($.isArray(response['text'])){
					        var countInf = 0;
					        $.each(response['text'], function(key, val){
					            ++countInf;
					            if(val && countInf < 50){
                                    Game.notifications.main(val,'success');
                                }
                            })
                        }else{
                            Game.notifications.main(response['text'],'success');
                        }

					}
                    if(type == 'remove'){
						Game.notifications.main('<img src="img/world/items/little/'+id+'.png" class="item"> '+response['nameItem']+' (1 шт.)','plus');
                        Game.modals.pokemons();
                    }else{
						Game.modals.inventory(typeM);
                    }
                    if(response['minus']) {
                      Game.notifications.main(response['minus'],'minus');
                    }
                    if(response['plus']) {
                      Game.notifications.main(response['plus'],'plus');
                    }
                }else{
                    Game.notifications.main(response['text'],'error');
                }
            }
        });
    }
}
function addEV(type,stat,e,count=false,pokID){
    if(type=='open'){
      $('<div />', {
        "class": 'MiniModal',
        html: '<div class="Name" id="drgMini">Добавить покемону EV</div><div class="Content"><div class="Settings"><div class="Step"><input placeholder="Количество EV..." onkeydown="if(event.keyCode == 13){addEV(\'add\','+stat+',this,$(this).val(),'+pokID+');}"></div></div></div>'
        }).appendTo('body');
      $('.MiniModal').draggabilly({
        handle: '#drgMini',
        containment: true
      });
	}else if(type=="add"){
        count = parseInt(count);
        var pattern = /^[0-9]+$/i;
        if(count > 126 || count <= 0){
            Game.notifications.main(Lang.error_ev_count,'error');
        }else if(!pattern.test(count)){
            Game.notifications.main(Lang.error_natural_numbers,'error');
        }else{
            $.ajax({
                url: "/do/pokemonsAction",
                type: "POST",
                data: {
                    type: 'addEV',
                    stat: stat,
                    pokID: pokID,
                    count: count
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if(response['text'] && response['error'] == 0){
                        Game.notifications.main(response['text'],'success');
                        Game.modals.pokemons();
                    }else if(response['error'] == 1){
                        Game.notifications.main(response['text'],'error');
                    }else{
                        Game.notifications.main(response['text'],'error');
                    }
                }
            });
        }
        $('.MiniModal').remove();
    }
}
function NpcDialog(id,step = false){
    var npcBlock = $('.DivNpcBlock');
    if(npcBlock.length && !step){
        npcBlock.remove();
    }else{
        if(npcBlock.length === 0){
            $('body').append("<div class='DivNpcBlock'></div>");
            $('.DivNpcBlock').css("top",'110px');
        }
    }
    $.ajax({
        url: "/do/Npc/",
        type: "post",
        data: {
            npc: id,
            step: step
        },
        beforeSend: function(){
          $('.DivNpcBlock').css({
            "left": '40%',
            "top": '10%'
          });
			$('.loadWorld').css('display','block');
        },
        success: function (response) {
            response = JSON.parse(response);
			Game.loaders.worldClose();
            if(!response['error']){
                if(response['action'] == 'updateLocation'){
                    $('.DivNpcBlock').remove();
                    updateLocation();
                }
				if(response['actionQuest']){
                    Game.notifications.main(response['actionQuest'],'quest');
                }
                if(response['actionQuestPlus']){
                  Game.notifications.main(response['actionQuestPlus'],'plus');
                }
                if(response['actionQuestMinus']){
                  Game.notifications.main(response['actionQuestMinus'],'minus');
                }
                if(response['question'] == '{{makasimka}}'){
                    byMax(response['npc_id']);
                    return;
                }
                if(response['question'] != '{{new}}'){
                    var answer = '';
                    if(response['answer']){
                        $.each(response['answer'], function(x,y){

                            if(x == 'by'){
                                answer+= "<div onclick='byMax("+y['npc_id']+");'>"+y['title']+"</div>";
                            }else{
                                answer+= "<div onclick='NpcDialog("+id+","+x+",event);'>"+y+"</div>";
                            }
                        });
                    }
                    var tpl = "";
                    tpl+= "<div class='Info'><div class='Image' style='background-image: url(/img/world/npc/"+id+".png);''></div> <div class='Name'><div id='drgNpc'>"+response['name']+"</div></div></div> <div class='Text'><div class='Close' onclick=$('.DivNpcBlock').remove();><i class='fa fa-close'></i></div> <div class='Dialog'>"+response['question']+"</div> <div class='Answer'>"+answer+"</div></div>";
                    $(".DivNpcBlock").html(tpl);
                }else{
                    $('.DivNpcBlock').remove();
                    if($('.model').length){
                        $('.model').remove();
                    }
                    NpcObject(response['type']);
                }
            }else if(response['error'] == 1){
                alert(Lang.error_npc_unavailable);
                $('.DivNpcBlock').remove();
            }else{
                alert(Lang.error_npc_unlocation);
                $('.DivNpcBlock').remove();
            }
            $('.DivNpcBlock').draggabilly({
              handle: '#drgNpc',
              containment: true
            });
        }
    });
}
function NpcObject(type){
    $.ajax({
        url: "/do/Npc/",
        type: "post",
        data: {
            type: type
        },
        success: function (response) {
            response = JSON.parse(response);
            if(!response['error']){
                var tpl = '<div class="model"><div class="header">'+response['title']+'<span onclick=$(".model").remove();><i class="fa fa-close"></i></span></div>';
				tpl += '<div class="content-model">';
                if(response['type'] == 'pokemarket'){
                    tpl+= response['html'];
                }else if(response['type'] == 'reproduction'){
                    tpl+= response['html'];
                }else if(response['type'] == 'lombard'){
                    tpl+= response['html'];
                }else{
                    tpl+= '<div class="pit"><input id="pitInput" placeholder="'+Lang.search_pokemon+'" onkeypress=if(event.keyCode==13)nursery("search"); type="text">';
                    tpl+= '<div class="pok-1">'+response['html'];
                    tpl+= '';
                    tpl+= '</div></div></div>';
                }
                tpl += '</div>';
                $("body").append(tpl);
					$('.model').draggabilly({
						handle: '.header',
						containment: true
					});
            }else{
                alert(Lang.error_no_way);
            }
        }
    });
}
function showNotify(e){
	$('.BlockOtherContent').toggle();
	if($('.BlockOtherContent').is(':visible')){
		$.ajax({
			url: "/do/notifications",
			type: "POST",
			data: "type=load",
			beforeSend: function(){
				Game.loaders.world();
			},
			success: function (data) {
				Game.loaders.worldClose();
				if(data != '0'){
					$('.BlockOtherContent .DivNotifyBlock').html(data);
				}
				if(!$('.BlockOtherContent').hasClass('updated')){
					$('.BlockOtherContent').addClass('updated');
				}
			}
		});
	}
}

function openTrade(){

    if(ClassTrade){
        ClassTrade._close(false);

        return setTimeout(function(){
            ClassTrade = null;

            openTrade();

        }, 100);
    }

    $.ajax({

        url: "/do/trade",
        type: "POST",
        data: {
            type:'view'
        },

        success: function (response) {
            response = JSON.parse(response);
            if(response['error'] == 1){
                Game.notifications.main(response['text'],'error');
            }else{
                ClassTrade = new Trade(response);
            }
        }
    });
}
function addTrade(id,type){
    var count = ($('#countItemInput').val()?$('#countItemInput').val():1);
    $.ajax({
        url: "/do/trade",
        type: "POST",
        data: "id="+id+"&typePut="+type+"&type=add&count="+count,
        success: function (response) {
            response = JSON.parse(response);
            if(response['error'] == 1){
                Game.notifications.main(response['text'],'error');
            }else{
                if(response['update'] == 0){
                    var tpl = '<div class="slot" id=slot_'+response['data']['id']+'>';
                    tpl+= '<img src="/img/world/items/little/'+response['data']['id']+'.png">';
                    tpl+= '<div class="text">'+response['data']['name']+' ('+response['data']['count']+' шт.)</div>';
                    tpl+= '</div>';
                    $('.userOne .itemsTrade').append(tpl);
                }else{
                    alert(response['data']['count']);
                    var tpl = '<img src="/img/world/items/little/'+response['data']['id']+'.png">';
                    tpl+= '<div class="text">'+response['data']['name']+' ('+response['data']['count']+' шт.)</div>';
                    $('#slot_'+response['data']['id']).html(tpl);
                }
            }
        }
    });
}
function evolutionPok(id){
    var pokID = parseInt($("#pokID").val());
     $.ajax({
        url: "/do/Npc/"+id+".php",
        type: "POST",
        data: 'pokID='+pokID,
        success: function (response) {
            response = JSON.parse(response);
            response['error'] == 1 ? Game.notifications.main(response['text'],'error') : Game.notifications.main(response['text'],'success');
            if(response['minus']) {
              Game.notifications.main(response['minus'],'minus');
            }
        }
    });
}
//function discoveryGo(type){
//    var pokID = parseInt($("#pokID").val());
//     $.ajax({
//        url: "/do/DiscoveryItem",
  //      type: "POST",
  //      data: 'pokID='+pokID+'&type='+type,
  //      success: function (response) {
  //          response = JSON.parse(response);
  //          Game.notifications.main(response["html"], response["error"]);
  //      }
  //  });
//}
function ngBox(type, refresh, rare){
    if(!rare) rare = 0;
    $.ajax({
        url: "/do/ngbox",
        type: "POST",
        data: 'type='+type+'&ref='+(refresh || 0)+'&rare='+rare,
        success: function (response) {
            response = JSON.parse(response);

            if(refresh){
                $('.model').empty().append(response['html']);
            }else{
                $('.model').remove();
                $('body').append(response['html']);
                $('.model').draggabilly({
                    handle: '.header',
                    containment: true
                });
            }


        }
    });
}
//function giveDiscovery(id){
//     $.ajax({
//        url: "/do/Discovery",
//        type: "POST",
//        data: 'id_discovery='+id,
//        success: function (response) {
  //          response = JSON.parse(response);
  //          Game.notifications.main(response["html"], response["error"]);
	//		if(response["error"] == 'success'){
	//			$('.CraftContent').html('<div class="discovery"><span>'+response['prize']+'</span></div>');
	//		}
//        }
  //  });
//}
function addAttacks(e,type,id,atkID){
	$('.GiveDiv').remove();
	if(type == 'open'){
		$.ajax({
			url: "/do/pokemonsAction",
			type: "POST",
			data: {
					pokID: id,
					attackID: atkID,
					type: type
				},
			success: function (response) {
				response = JSON.parse(response);
				if(response['error'] == 1){
					Game.notifications.main(response['text'],'error');
				}else{
					var attacks = '';
					$.each(response['attacks'], function(x,y){
						var data = y.split(',');
            attacks += '<div class="Move"><div class="PlusAtk" onclick=\'addAttacks('+data[2]+',"add",'+data[1]+','+x+');\'><i class="fa fa-plus"></i></div><img src="/img/world/typs/'+data[3]+'.png" onclick="viewDescriptionAttak(this,'+data[6]+');"><div class="MoveInfo"><div class="Name MoveCategory3">'+data[0]+'</div><div class="PP">'+data[4]+'/'+data[4]+' PP</div></div></div>';
					});
					var tpl = '<div class="GiveDiv">';
					tpl+= '<div id="DivAbout">'+Lang.text_atk_learn+'</b></div>';
					tpl+= '<div class="wrap"><div class="PokList">';
					tpl+= attacks;
					tpl+= '</div></div></div>';
					$(tpl).appendTo('body');
					var position = $(e).position();
					var offset = $(e).offset();
					var left = Math.round(offset.left+30);
					var top = Math.round(offset.top-200);
					$('.GiveDiv').css({
						"left": left+'px',
						"top": top+'px'
					});
          $('.tooltip').hide();
				}
			}
		});

	}else if(type == 'add'){
		$.ajax({
			url: "/do/pokemonsAction",
			type: "POST",
			data: {
					positionAtk: e,
					pokID: id,
					attackID: atkID,
					type: type
				},
			success: function (response) {
				response = JSON.parse(response);
				response['error'] == 1 ? Game.notifications.main(response['text'],'error') : Game.notifications.main(response['text'],'success');
				Game.modals.pokemons();
			}
		});
	}
}
function policeNPC(){
	var subject = $('#subjectPolice').val();
	var text = $('#textPolice').val();
		$.ajax({
			url: "/do/Npc/jess",
			type: "POST",
			data: {
				subject: subject,
				text: text
			},
			success: function (response) {
				response = JSON.parse(response);
				response['error'] == 1 ? Game.notifications.main(response['text'],'error') : Game.notifications.main(response['text'],'success');
			}
		});
}
function upgradeClan(type){
	if(type == 'goLeaderClan'){
		var a = $("#goLeaderClan").val();
	}else if(type == 'goUnleaderClan'){
		var a = $("#goUnleaderClan").val();
	}else if(type == 'goDeleteClan'){
		var a = $("#goDeleteClan").val();
	}else if(type == 'goStatusClan'){
		var a = $("#goStatusClanLogin").val(),
			b = $("#goStatusClanText").val();
	}else if(type == 'goNotifyClan'){
		var a = $("#goNotifyClan").val();
	}
	$.ajax({
		url: "/do/clanAction",
		type: "POST",
		data: 'object='+type+'&name='+a+'&other='+b,
		success: function (response) {
			response = JSON.parse(response);
			Game.notifications.main(response["text"], response["error"]);
		}
	});
}
function openClanCard(id){
	id = parseInt(id);
	if($('.mudol').length){
		$('.mudol').remove();
	}
	$.ajax({
		url: "/do/modal",
		type: "POST",
		data: 'id='+id+'&type=clanCard',
		beforeSend: function(){
			$('.Modal').remove();
			$('<div />', {
					'class':'mudol'
				}).prependTo('body');
           $('.mudol').html('<center>'+mainLoader+'</center>');
        },
		success: function (response) {
			response = JSON.parse(response);
			if(response['text']){
				$('.mudol').remove();
				return Game.notifications.main(response['text'],'error');
			}
			var info = JSON.parse(response['info']);
			var tpl = '', member = false, leader = false;
			tpl+='<div class="Header">'+Lang.text_clancard+'<div class="Close" onclick=$(".mudol").hide();><i class="fa fa-close"></i></div></div>';

      tpl+='<div class="Content">';

      tpl+='<div class="Clancard">';

      tpl+='<div class="LeftClan">';

      tpl+='<div class="ClanName"><img src="/img/world/clans/'+id+'.png"><span>'+info['name']+'</span></div>';
      tpl+='<div class="ClanAbout">'+info['description']+'</div>';

      tpl+='<div class="ClanMembers">';
      tpl+='<span>Участники</span>';
      tpl+='<div class="MembersList">';
      $.each(response['users'], function(x,y){
				var data = y.split(',');
				var raiting = (data[2].indexOf('-') ? '<span class="plus">'+data[2]+'</span>' : '<span class="minus">'+data[2]+'</span>');
				var classUser = (data[4] == 1 ? 'lead' : (data[4] == 2 ? 'moder' : ''));
				tpl+='<div class="'+classUser+'"><div class="user-link"><div onclick="showUserTooltip('+x+')" class="Info-Link sexm"><i class="fa fa-info"></i></div> <div class="u-'+data[1]+'">'+data[0]+'</div></div> <div class="zvan">'+data[3]+'</div> '+raiting+' '+(x == info['Creater'] ? '<div class="gl"></div>' : '')+'</div>';
				leader = (data[5] == data[6] ? (data[7] == 1 ? true : false) : false),
				member = (data[5] == data[6] ? true : false);

			});
      tpl+='</div>';
      tpl+='</div>';

      tpl+='</div>';

      tpl+='<div class="RightClan">';

      tpl+='<div class="ClanInfo">';
      tpl+='<div>'+info['dateCreate']+'<span>Создан</span></div>';
      tpl+='<div>'+response['position']+'<span>Позиция</span></div>';
      tpl+='<div>'+response['rating']+'<span>Рейтинг</span></div>';
      tpl+='<div>'+response['countUsers']+'<span>Участников</span></div>';
      tpl+='</div>';
      tpl+='<div class="ClanLog">';
      $.each(response['log'],function(x,y){
				var data = JSON.parse(y['info']);
				var clan_action;
				if(y['type'] == 'ADD_CLAN_USER'){
					clan_action = Lang.clan_user_entered;
				}else if(y['type'] == 'ADD_CLAN_MONEY'){
					clan_action = (member == true ? Lang.clan_user_add_money+' <b>'+data['count']+'</b> '+Lang.currency_money : true);
				}else if(y['type'] == 'TAKE_CLAN_MONEY'){
					clan_action = (member == true ? Lang.clan_user_take_money+' <b>'+data['count']+'</b> '+Lang.currency_money : true);
				}else if(y['type'] == 'CLAN_CREATE'){
					clan_action = Lang.clan_user_create;
				}else if(y['type'] == 'ADD_CLAN_STATUS'){
					clan_action = Lang.clan_user_status+' <b>'+data['status']+'</b>';
				}else if(y['type'] == 'ADD_CLAN_NOTICE'){
					clan_action = (member == true ? Lang.clan_user_notify+' <b>'+data['notice']+'</b>' : true);
				}else if(y['type'] == 'ADD_CLAN_ADMIN'){
					clan_action = Lang.clan_user_leader;
				}else if(y['type'] == 'DELETE_CLAN_ADMIN'){
					clan_action = Lang.clan_user_unleader;
				}else if(y['type'] == 'LEFT_CLAN'){
					clan_action = Lang.clan_user_leave;
				}else if(y['type'] == 'LEFT_CLAN_ALERT'){
					clan_action = Lang.clan_user_excluded;
				}else if(y['type'] == 'ABOUT_CLAN_ALERT'){
					clan_action = Lang.clan_user_clan_status;
				}
				if(clan_action == true){
					tpl+='';
				}else{
					tpl+='<div><div class="time">'+data['date']+'</div> <div class="user-link"><div class="u-'+data['user_group']+'">'+data['user_new']+'</div></div> <span>'+clan_action+'</span></div>';
				}
			});
      tpl+='</div>';

      tpl+='</div>';

      tpl+='<div class="ClanBot">';

      tpl+='<div class="LeftBotClan"><span>Контролирует локацию</span><div>-</div></div>';
      if(member == true){
        tpl+='<div class="RightBotClan">';
        if(leader == true){
					tpl+='<div class="BtnLeadClan" onclick="openClanControl('+id+')">Управление</div>';
				}
        tpl+='<div class="BtnLeavClan" onclick=actionClan("left");>'+Lang.button_clan_leave+'</div>';
        tpl+='<div class="MoneyClan">';
        tpl+='Монета (<b>'+info['Money']+'</b> шт.)<input id="countMoney" style="display:none;"><div class="BtnMoneyClan" id="addMoney" onclick=actionClan("openMoney");>Пополнить</div> <div class="BtnMoneyClan" id="getMoney" onclick=actionClan("addMoneys");>Вывести</div>';
        tpl+='</div>';
        tpl+='</div>';
			}

      tpl+='</div>';

      tpl+='</div>';

      tpl+='</div>';

			$('.mudol').html(tpl);
		}
	});
}
function openClanControl(id){
	id = parseInt(id);
	if($('.model').length){
		$('.model').remove();
	}
	$.ajax({
		url: "/do/modal",
		type: "POST",
		data: 'id='+id+'&type=clanCardControl',
		beforeSend: function(){
			$('<div />', {
					'class':'model'
				}).appendTo('body');
           $('.model').html('<center>'+mainLoader+'</center>');
        },
		success: function (response) {
			response = JSON.parse(response);
			$('.model').html(response['html']);
			$('.model').draggabilly({
				handle: '.header',
				containment: true
			});
		}
	});
}
function actionClan(obj){
	obj = [obj];
	if(obj == 'openMoney'){
		$('#addMoney').hide();
		$('#countMoney').show();
		$('#getMoney').replaceWith('<input type="button" class="btnA" value="'+Lang.button_clan_add_money+'" onclick=\'actionClan("addMoney");\'>');
		return false;
	}else if(obj == 'addMoneys'){
		$('#addMoney').hide();
		$('#countMoney').show();
		$('#getMoney').replaceWith('<input type="button" class="btnA" value="'+Lang.text_get+'" onclick=\'actionClan("minusMoney");\'>');
		return false;
	}else if(obj == 'minusMoney'){
		var count = (/[^[0-9]/.test($("#countMoney").val()) || $("#countMoney").val() < 0 ? null : parseInt($("#countMoney").val()));
		if(count == null){
			return false;
		}
		obj = obj+','+count;
	}else if(obj == 'addMoney'){
		var count = (/[^[0-9]/.test($("#countMoney").val()) || $("#countMoney").val() < 0 ? null : parseInt($("#countMoney").val()));
		if(count == null){
			return false;
		}
		obj = obj+','+count;
	}else if(obj == 'clanAbout'){
		var count = $("#clanAbout").val();
		if(count == null){
			return false;
		}
		obj = obj+','+count;
	}
	$.ajax({
		url: "/do/clanAction",
		type: "POST",
		data: 'object='+obj,
		success: function (response) {
			response = JSON.parse(response);
      if(response['error'] == 1) {
        Game.notifications.main(response['text'],'error');
      }else{
        Game.notifications.main(response['text'],'success');
      }
			if(response['action'] == 'updateClan'){
				openClanCard(response['id']);
			}
		}
	});
}
function clanAdmin(type,id){
	$.ajax({
		url: "/do/clanAction",
		type: "POST",
		data: 'object='+type+'&name='+id,
		success: function (response) {
			response = JSON.parse(response);
			response['error'] == 1 ? Game.notifications.main(response['text'],'error') : Game.notifications.main(response['text'],'success');
		}
	});
}
function craftCategory(type,id_isset=false,e){
	if(id_isset){
		$.ajax({
			url: "/do/Craft",
			type: "POST",
			data: "category="+type,
			beforeSend: function(){
				$('.CraftItemNow').html('<center>'+mainLoader+'</center>');
			},
			success: function (response) {
				response = JSON.parse(response);
				$('.CraftItemNow').html(response["html"]);
			}
		});
	}else{
		$('.CraftCategory .Button').removeClass('active');
		$('.'+type+'').addClass('active');
		$.ajax({
			url: "/do/Craft",
			type: "POST",
			data: "category="+type,
			beforeSend: function(){
				$('.CraftContent').html('<center>'+mainLoader+'</center>');
			},
			success: function (response) {
				response = JSON.parse(response);
				$('.CraftContent').html(response["html"]);
			}
		});
	}
}
//function discoveryCategory(type,e){
//	$('.ctgCraft').removeClass('active');
	//$('.'+type+'').addClass('active');
	//$.ajax({
	//	url: "/do/Discovery",
	//	type: "POST",
	//	data: "category="+type,
	//	beforeSend: function(){
	//		$('.CraftContent').html('<center>'+mainLoader+'</center>');
	//	},
	//	success: function (response) {
	//		response = JSON.parse(response);
	//		$('.CraftContent').html(response["html"]);
	//	}
	//});
//}
function craftItem(id){
	var count = $('#CountCraft').val();
	$.ajax({
		url: "/do/CraftItems",
		type: "POST",
		data: "item="+id+"&count="+count,
		beforeSend: function(){
			$('.CraftItemNow').html('<center>'+mainLoader+'</center>');
		},
		success: function (response) {
			response = JSON.parse(response);
			Game.notifications.main(response["html"], response["error"]);
      if(response['plus']) {
        Game.notifications.main(response["plus"], 'plus');
      }
      if(response['minus']) {
        Game.notifications.main(response["minus"], 'minus');
      }
			$('.CraftItemNow').html('');
		}
	});
}
function rand(min, max){
      var r = Math.random() * (max - min) + min;
      return r;
}
function scrollGift(response){
	var gift_width  = $('.gifts .innerGift').outerHeight();

	$('<li />', {'html': '<img src="/img/world/items/little/'+response['id']+'.png">'}).appendTo('.innerGift');
		$('.innerGift li:first').animate({
								'marginTop':'-'+(gift_width+10)+'px'
							}, rand(8000,12000)).queue(function(){
					$('.goRoll').html('<p style="color: #0e39b9c7;"><b>Вы получили: '+response['name']+' ('+response['count']+' шт.)</b></p>');
					Game.notifications.main('<img src="img/world/items/little/'+response['id']+'.png" class="item"> '+response['name']+' ('+response['count']+' шт.)','plus');
		});
}
function uploadImg() {
	var u = $('#upload_file #file_name').prop('files')[0];
	var s = new FormData();
	s.append('file', u);
	j = $('#upload_file').html();
	$.ajax({
		url: '/do/upload',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data: s,
		type: 'POST',
		beforeSend: function() {
			$('#upload_file').html('<center><img height="40px" src="/img/loader/loader.gif"></center>');
		},
		success: function(n){
      $('#upload_file').html('');
			if(n==''){
        Game.notifications.main(Lang.success_load_file, "success");
			}else{
				Game.notifications.main(n, "error");
				$('#upload_file').html(j);
			}
		}
	});
	return false;
}
function settings() {
  $.ajax({
		url: "/do/trainers",
		type: "POST",
		data: "type=setting",
		success: function (response) {
			response = JSON.parse(response);
        $('.MiniModal').remove();
        $('<div />', {
          "class": 'MiniModal',
          html: function() {
            var snd = (response['sound'] == 0 ? 'Включить' : 'Выключить'),
                team = (response['team'] == 0 ? 'Открыть' : 'Закрыть'),
                tpl = '';
            tpl += '<div class="Name" id="drgMini">Настройки профиля</div>';
            tpl += '<div class="Content">';
            tpl += '<div class="Settings">';
            tpl += '<div class="Step">';
            tpl += '<div class="Name">Смена пароля</div>';
            tpl += '<input type="password" id="oldPass" placeholder="Старый пароль">';
            tpl += '<input type="password" id="newPass" placeholder="Новый пароль">';
            tpl += '<input type="password" id="dblNewPass" placeholder="Новый пароль еще раз">';
            tpl += '<div class="Button" onclick=Aqua.users.edit.redact("pass")>Применить</div>';
            tpl += '</div>';
            tpl += '<div class="Step">';
            tpl += '<div class="Name">Звуковые оповещения</div>';
            tpl += '<div class="Button" onclick=Aqua.users.edit.redact("audio",'+response['soundTwo']+')>'+snd+'</div>';
            tpl += '</div>';
            tpl += '<div class="Step">';
            tpl += '<div class="Name">Команда покемонов в тренеркарте</div>';
            tpl += '<div class="Button" onclick=Aqua.users.edit.redact("team",'+response['team']+')>'+team+'</div>';
            tpl += '</div>';
            tpl += '<div class="Step">';
            tpl += '<div class="Name">Цвет текста в чате</div>';
            tpl += '<div class="Color" onclick=Aqua.users.edit.redact("color",1) style="background: #d1d1d1;"></div><div class="Color" onclick=Aqua.users.edit.redact("color",2) style="background: #923838;"></div><div class="Color" onclick=Aqua.users.edit.redact("color",3) style="background: #257b34;"></div><div class="Color" onclick=Aqua.users.edit.redact("color",4) style="background: #252b7b;"></div><div class="Color" onclick=Aqua.users.edit.redact("color",5) style="background: #891f85;"></div><div class="Color" onclick=Aqua.users.edit.redact("color",6) style="background: #896520;"></div>';
            tpl += '</div>';
            tpl += '<div class="Step">';
            tpl += '<div class="Name">Изменить аватарку (формат PNG)</div>';
            tpl += '<form enctype="multipart/form-data" action="do/upload" method="post" id="upload_file" name="MAX_FILE_SIZE" value="1"><input type="file" name="file_name" id="file_name"/></form><div class="Button" onclick=uploadImg();>Сохранить</div>';
            tpl += '</div>';
            tpl += '</div>';
            tpl += '</div>';
            return tpl;
          }
        }).appendTo('body');
        $('.MiniModal').draggabilly({
          handle: '#drgMini',
          containment: true
        });
		}
	});
}
