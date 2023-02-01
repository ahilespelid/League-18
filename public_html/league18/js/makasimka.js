function rand(mi, ma) { return Math.random() * (ma - mi + 1) + mi; }
function irand(mi, ma) { return Math.floor(rand(mi, ma)); }
function isString(obj) { return typeof obj === 'string'; }
function isFunction(obj) {return obj && Object.prototype.toString.call(obj) === '[object Function]'; }
function isObject(obj) { return Object.prototype.toString.call(obj) === '[object Object]'; }
function isArray(obj) { return Object.prototype.toString.call(obj) === '[object Array]'; }

function _pokeNum(number){
    return (number < 10 ? '00'+number : (number < 100 ? '0'+number : number));
}

/**@return {Object}*/
function getElCord(ev, elem, oSet, lol=false, elnIn){
    if(lol == false) {
      var event = ev || event || window.event;
    }else{
      var event = ev;
    }
    var el = isObject(elem) ? elem : $('#'+elem), box, offset = [];
    if(elnIn) {
      var elIni = $('#'+elnIn);
    }else{
      var elIni = $('#window_games');
    }
    if(!elIni.length || !event || !el.length){
        return {};
    }
    if(isArray(oSet)){
        offset = [oSet[0], oSet[1]];
    }else{
        offset = [oSet || 7, oSet || 7];
    }
    if(el){
        box = {
            width: el.outerWidth(true),
            height: el.outerHeight(true)
        };
        var body = document.body,
            html = document.documentElement,
            wBody = elIni.outerWidth(true),
            hBody = elIni.outerHeight(true),
            clientTop = event.pageY || html.clientTop || body.clientTop || 0,
            clientLeft = event.pageX || html.clientLeft || body.clientLeft || 0,

            top = clientTop + offset[0],
            left = clientLeft + offset[1];

        if((top + box.height) > hBody){
            top = (top  - (box.height + (offset[0] / 2)));
        }
        if(top < 0){
            top = offset[0];
        }
        if((left + box.width) > wBody){
            left = (left - (box.width + (offset[1] / 2)));
        }
        if(left < 0){
            left = offset[1];
        }
    }
    return {
        top: Math.round(top)+'px',
        left: Math.round(left)+'px'
    };
}

function smile(el, text){
    var val = el.value;
    if (el.selectionStart && el.selectionEnd){
        var endIndex = el.selectionEnd,
            startIndex = el.selectionStart;
        el.value = val.slice(0, el.selectionStart) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length;
        _focus(el, (startIndex + text.length));
        return true;
    } else if(document && document.selection && document.selection.createRange){
        el.focus();
        var range = document.selection.createRange();
        if(range.text){
            range.text = text;
        }
        range.select();
        return true;
    }else{
        el.value = val + text;
        el.focus();
        return true;
    }
}

function _focus(el, start, stop){
    if(el){
        try{
            el.focus();
            if(start === undefined || start === false) start = el.value.length;
            if(stop === undefined || stop === false) stop = start;
            if(el.createTextRange){
                var range = el.createTextRange();
                range.collapse(true);
                range.moveEnd('character', stop);
                range.moveStart('character', start);
                range.select();
            }else if(el.setSelectionRange){
                el.setSelectionRange(start, stop);
            }
        }catch(e){
            el.focus();
        }
    }
}

/**
 * Trade Users
 *
 * @author Makasimka <000_01@list.ru>
 * @version 1.0
 *
 * @class Trade
 */
var Trade = function(info){

    var _self = this;

    var _ref_timer = 0,
        _data = {},
        _loaded = false,
        _confirmed = 1,
        _hash_my = '',
        _hash_enemy = '';

    var _element_window_game,
        _element_window,
        _element_my,
        _element_enemy,
        _element_my_list,
        _element_enemy_list,
        _element_button_confirmed,
        _element_poke_info,
        _element_warning;

    this._action = function(data, suc, err, cpl){
        if(data){
            if(ClassInfo){

                data = $.extend({
                    'type':'trade'
                }, data);

                ClassInfo._action(data, function(info){

                    if(info && info['tradeInfo']){
                        _self._parseData(info['tradeInfo']);
                    }
                    if(info['tradeInfo']['error'] == 1){
                        Game.notifications.main(info['tradeInfo']['text'], 'error');
                    }

                    if(suc && isFunction(suc)){
                        suc.call(_self, info);
                    }

                }, err, cpl);

            }
        }
    };

    this._started = function(data){

        if(window['isTrade']){
            window['isTrade'] = true;
        }else{
            isTrade = true;
        }

        //_self._refresh(true);

        _self._parseData(data);

    };

    this._addObject = function(object_type, object_id, count, suc, cpl){
        if(object_type && object_id && count && object_id > 0 && count > 0){

            _self._action({
                'addObject': object_type,
                'objectID': parseInt(object_id),
                'objectCount': parseInt(count)
            }, suc, null, cpl);

        }
    };

    this._refresh = function(started){

        if(!_element_window){
            return;
        }

        if(_ref_timer){
            clearTimeout(_ref_timer);
            _ref_timer = 0;
        }

        if(!started){

            _self._action({
                'type':'view'
            }, null, null, function(){
                _ref_timer = setTimeout(function(){
                    _self._refresh();
                }, 3000);
            });

        }else{

            _ref_timer = setTimeout(function(){
                _self._refresh();
            }, 3000);

        }

    };

    this._parseData = function(data){
        if(data){

            if(isString(data)){
                _data = JSON.parse(data);
            }else{
                _data = $.extend(_data, data);
            }

            _self._update();

        }
    };

    this._update = function(data){

        data = data ? data : _data;

        if(!data['my']){
            return;
        }

        if(!_element_window_game){
            _element_window_game =  $('.DivWorld');
        }

        if(!_element_window){
            _element_window_game.find('.DivMap').hide();
            _element_window = $('<div />', {
                'id':'TradeWrap',
                'class':'DivMap'
            }).appendTo(_element_window_game);
        }

        if(_element_window && _element_window.length && !_element_my && !_element_enemy){

            _element_my = $('<div />', {
                'class':'Left'
            }).append(
                '<div class="User">' +
                '<div class="TrainerBlock">' +
                '<div onclick=showUserTooltip("'+data['my']['id']+'") class="Avatar" style="background-image: url(/img/avatars/mini/'+data['my']['id']+'.png);"></div>'+
                ' <div class="Title"><div class="Name"><div class="u-'+data['my']['group']+'">'+data['my']['login']+'</div></div><div class="Other">'+data['my']['rang']+'</div></div>' +
                '</div>' +
                '</div>'
            );

            _element_enemy = $('<div />', {
                'class':'Right'
            }).append(
              '<div class="User">' +
              '<div class="TrainerBlock">' +
              '<div onclick=showUserTooltip("'+data['enemy']['id']+'") class="Avatar" style="background-image: url(/img/avatars/mini/'+data['enemy']['id']+'.png);"></div>'+
              ' <div class="Title"><div class="Name"><div class="u-'+data['enemy']['group']+'">'+data['enemy']['login']+'</div></div><div class="Other">'+data['enemy']['rang']+'</div></div>' +
              '</div>' +
              '</div>'
            );

            _element_my_list    = $('<div />', {'class':'Content'});
            _element_enemy_list = $('<div />', {'class':'Content'});
            _elenent_warning = $('<div />', {
              'class': 'Info',
              html: '<span>Внимание!</span>Прежде чем совершить обмен, убедитесь, что ваш партнер добавил все необходимые для обмена предметы.'
            });
            _element_button_confirmed = $('<div />', {
                'class':'btn Go',
                'html':'Согласен',
                'click':function(){
                    _self._action({
                        'confirmed': parseInt(_confirmed)
                    }, function(){
                        if(_element_button_confirmed){
                            _element_button_confirmed.html((_confirmed > 0 ? 'Не согласен' : 'Согласен'));
                            _confirmed = (_confirmed > 0 ? 0 : 1);
                        }
                    })
                }
            });

            _element_window.append(
                $('<div />', {
                    'class':'Trade'
                }).append(
                    _element_my.append(
                        _element_my_list
                    ),
                    $('<div />', {
                        'class':'Mid'
                    }).append(
                        _elenent_warning,
                        _element_button_confirmed,
                        $('<div />', {
                            'class':'btn Cancel',
                            'html':'Отменить'
                        }).click(function(){
                            _self._close(true);
                        })
                    ),
                    _element_enemy.append(
                        _element_enemy_list
                    )
                )
            );
        }

        if(_element_window && _element_window.length && _element_my_list && _element_enemy_list){

            var tpl = [], hash = '';

            if(data['myObj']){
                hash = '';
                $.each(data['myObj'], function(key, val){
                    hash += '~'+val['number']+'x'+val['count']+'~';
                    tpl.push(_self._parseObjects(val));
                });
                hash = md5(hash);
                if(tpl.length){
                    if(_hash_my != hash){
                        _hash_my = hash;
                        _element_my_list.empty().append(tpl);
                    }
                }else{
                    _hash_my = '';
                    _element_my_list.empty();
                }
            }

            if(data['enemyObj']){
                tpl = [];

                $.each(data['enemyObj'], function(key, val){
                    tpl.push(_self._parseObjects(val));
                });

                if(tpl.length){
                    _element_enemy_list.empty().append(tpl);
                }else{
                    _element_enemy_list.empty();
                }
            }

            tpl = [];

            if(data['myConfirmed'] && data['myConfirmed'] > 0){
                _element_my.addClass('confirmed');
                _element_button_confirmed.html('Не согласен');
                _confirmed = 0;
            }else{
                _element_my.removeClass('confirmed');
                _element_button_confirmed.html('Согласен');
                _confirmed = 1;
            }
            if(data['enemyConfirmed'] && data['enemyConfirmed'] > 0){
                _element_enemy.addClass('confirmed');
            }else{
                _element_enemy.removeClass('confirmed');
            }
        }

        if(_element_my_list && _element_window.length){

            if(data['trades']){
                _self._close();
            }

        }

    };

    this._pokeNum = function(number){
        return (number < 10 ? '00'+number : (number < 100 ? '0'+number : number));
    };

    this._pokeRep = function(type){
        return (type == 'normal' ? 'normal' : 'shine');
    };

    this._parseObjects = function(info){

        if(info && info['type']){

            if(info['type'] == 'item'){
                return $('<div />', {
                    'class':'Step',
                    'html':'<img src="/img/world/items/little/'+info['number']+'.png"> '+(info['name'] || '...')+' '+info['str_exp']+' ('+info['count']+' шт.)',
                    'click': function(){
                        _self._itemFocus(this, info);
                    }
                });
            }else if(info['type'] == 'egg'){
                return $('<div />', {
                    'class':'Step',
                    'html':'<img src="/img/world/items/little/54.png"> '+info['name']+'',
                    'click': function(){
                        _self._itemFocus(this, info);
                    }
                });
            }else if(info['type'] == 'poke'){
                return $('<div />', {
                    'class':'Step '+_self._pokeRep(info['poke_type'])+'-color',
                    'html':'<img src="/img/pokemons/anim/'+_self._pokeRep(info['poke_type'])+'/'+info['number']+'.gif"> #'+_self._pokeNum(info['number'])+' '+info['name']+'',
                    'click': function(e){
                        _self._pokeFocus(e, (info['id'] || 0), info);
                    }
                });
            }

        }

        return '';
    };

    this._pokeFocus = function(e, id, inf){

        if(id && _data['pokeInfoList']){

            var info = _data['pokeInfoList']['p'+id];

            if(!info){
                return;
            }

            if(!_element_poke_info){
                _element_poke_info = $('<div />', {
                    'class':'window pokeInfo'
                }).appendTo('#window_games');
            }

            var ev = info['evcounts'].split(','),
                stat = info['stats'].split(','),
                gen = info['gen'].split(','),
                exp = (info['lvl'] != 100 ? info['exp']+' / '+info['exp_max'] : 'полное'),
                nS = (info['type'] == 'normal' ? '' : info['type']),
                led,
                gender,
                tr,
                tr_n;
                if(info['gender'] == 'Мальчик') {
                  gender = 'mars';
                }else if(info['gender'] == 'Девочка') {
                  gender = 'venus';
                }else{
                  gender = 'genderless';
                }
                if(info['led']['gen'] == 1 && info['led']['char'] == 1) {
                  led = 'Горький и Кислый';
                }else if(info['led']['gen'] == 1 && info['led']['char'] != 1) {
                  led = 'Горький';
                }else if(info['led']['gen'] != 1 && info['led']['char'] == 1) {
                  led = 'Кислый';
                }else{
                  led = 'Не использовано';
                }

                if(info['tren_stat'] == 1) {
                  tr = 'в Атаку';
                }else if(info['tren_stat'] == 2) {
                  tr = 'в Защиту';
                }else if(info['tren_stat'] == 3) {
                  tr = 'в Скорость';
                }else if(info['tren_stat'] == 4) {
                  tr = 'в Спец. Атаку';
                }else if(info['tren_stat'] == 5) {
                  tr = 'в Спец. Защиту';
                }else{
                  tr = '';
                }

                if(info['tren'] == 1) {
                  tr_n = 'Начальная, ';
                }else if(info['tren'] == 2) {
                  tr_n = 'Морская, ';
                }else if(info['tren'] == 3) {
                  tr_n = 'Жемчужная, ';
                }else if(info['tren'] == 4) {
                  tr_n = 'Престижная, ';
                }else if(info['tren'] == 5) {
                  tr_n = 'Величайшая, ';
                }else if(info['tren'] == 6) {
                  tr_n = 'Легендарная, ';
                }else if(info['tren'] == 7) {
                  tr_n = 'Королевская, ';
                }else{
                  tr_n = 'Отсутствуют';
                }

            _element_poke_info.empty().append(
              '<div class="Pokemons">' +
              '<div class="Info">' +
              '<div class="Left">' +
              '<div class="PokemonBox">' +
              '<div class="Modif" style="background-size: url(/img/tren/'+info['tren']+'.png);"></div>' +
              '<img class="Image" src="/img/pokemons/mini/'+info['type']+'/'+_pokeNum(info['basenum'])+'.png">' +
              '<div class="Lvl">'+info['lvl']+'</div>' +
              '<div class="Unik '+info['type']+'-color">'+nS+'</div>'+
              '<div class="Name '+info['type']+'-color">' +
              '<div class="Text">#'+_pokeNum(info['basenum'])+' '+info['name']+'</div>' +
              '<div class="Sex '+(info['sparka'] == 0 ? '' : 'spar')+'"><i class="fas fa-'+gender+'"></i></div>' +
              '</div>' +
              '<div class="Bars">' +
              '<div class="Bar">' +
              '<div class="Text">'+info['hp']+' / '+stat['0']+'</div>' +
              '<div class="HpBar" style="width: '+(info['hp'] / stat['0']) * 100+'%;"></div>' +
              '</div>' +
              '<div class="Bar">' +
              '<div class="Text">'+exp+'</div>' +
              '<div class="ExpBar" style="width: '+(info['exp'] / stat['exp_max']) * 100+'%;"></div>' +
              '</div>' +
              '<div class="Bar">' +
              '<div class="Text">'+info['happy']+' / 255</div>' +
              '<div class="HappyBar" style="width: '+(info['happy'] / 255) * 100+'%;"></div>' +
              '</div>' +
              '</div>' +
              '</div>' +
              '<div class="MoveBox">' +
              ''+info['atk1']+'' +
              ''+info['atk2']+'' +
              ''+info['atk3']+'' +
              ''+info['atk4']+'' +
              '</div>' +
              '</div>' +
              '<div class="Right">' +
              '<div class="Id Id-trade'+(info['trade'] == 'true' ? 'Yes' : 'No')+'">id'+info['id']+'</div>' +
              '<div class="Info">' +
              '<div class="Step">Характер: <span>'+info['character']+'</span></div>' +
              '<div class="Step">Генокод: <span>h'+gen['0']+'a'+gen['1']+'d'+gen['2']+'s'+gen['3']+'sa'+gen['4']+'sd'+gen['5']+'</span>, Витамины: <span>'+info['vitamines']+'/100</span></div>' +
              '<div class="Step">Классификация: <span>'+tr_n+''+tr+'</span></div>' +
              '<div class="Step">Разведение: <span>'+(info['sparka'] == 0 ? 'Доступно' : 'Недоступно')+'</span>, Группа привлекательности: <span>'+info['sparkaNumber']+'</span></div>' +
              '<div class="Step">Заколдованные леденцы: <span>'+led+'</span></div>' +
              '<div class="Step">Пойман: <span>'+(info['birthday'] ? (info['birthday']['date']+'г. тренером '+info['birthday']['user']) : 'Неизвестно')+'</span></div>' +
              '<div class="Step">Способность: <span>в разработке</span></div>' +
              '</div>' +
              '<div class="MainInfo">' +
              '<div class="Stats">' +
              '<div class="Stat"><div class="Name">Здоровье</div><div class="Count">'+stat['0']+'</div> <div class="Progress"><div class="Text">'+ev[0]+' / 126 EV</div><div class="Bar" style="width: '+(ev[0]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Атака</div><div class="Count">'+stat['1']+'</div> <div class="Progress"><div class="Text">'+ev[1]+' / 126 EV</div><div class="Bar" style="width: '+(ev[1]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Защита</div><div class="Count">'+stat['2']+'</div> <div class="Progress"><div class="Text">'+ev[2]+' / 126 EV</div><div class="Bar" style="width: '+(ev[2]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Скорость</div><div class="Count">'+stat['3']+'</div> <div class="Progress"><div class="Text">'+ev[3]+' / 126 EV</div><div class="Bar" style="width: '+(ev[3]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Спец. Атака</div><div class="Count">'+stat['4']+'</div> <div class="Progress"><div class="Text">'+ev[4]+' / 126 EV</div><div class="Bar" style="width: '+(ev[4]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Спец. Защита</div><div class="Count">'+stat['5']+'</div> <div class="Progress"><div class="Text">'+ev[5]+' / 126 EV</div><div class="Bar" style="width: '+(ev[5]/126 * 100)+'%;"></div></div></div>' +
              '</div>' +
              '<div class="CountEv">Свободных EV: <span>'+info['ev']+'</span></div>' +
              '</div>' +
              '</div>' +
              '</div>',
                (inf['hidden'] ? '' : $('<div />', {
                    'class':'trade-btn',
                    'html':'Убрать из обмена',
                    'click':function(){

                        _self._action({
                            'removeObject': 'poke',
                            'objectID': parseInt(info['id'])
                        }, function(){

                        });

                    }
                }))
            );

            _element_poke_info.css(getElCord(e, _element_poke_info, [-25, 6]));
            _element_poke_info.css('display', 'block');

            $('body')
                .off('click.pokeInfoTrade')
                .on('click.pokeInfoTrade', function(){
                    if(_element_poke_info){
                        _element_poke_info.remove();
                        _element_poke_info = null;
                    }
                    $('body').off('click.pokeInfoTrade');
                });

            e.stopImmediatePropagation();
        }
    };

    this._itemFocus = function(elm, info){

        if(info['type'] == 'poke'){
            return _self._pokeFocus(window.event, (info['id'] || 0), info);
        }

        var tlp = $('.tooltip'),
            element = $(elm),
            offset = element.offset();

        var left = Math.round(offset.left+10),
            top = Math.round(offset.top+50);

        tlp.css({
            "left": left+'px',
            "top": top+'px'
        });

        var tpl = [];

        tpl.push('<div class="Name">'+(info['name'] || '...')+' ('+info['count']+' шт.)</div>');

        if(info['type'] == 'poke'){
            tpl.push('<div class="Image"><img id="imgItem" style="display: inline-block;" src="/img/pokemons/mini/'+_self._pokeRep(info['poke_type'])+'/'+_self._pokeNum(info['number'])+'.png"></div>');
        }else{
            tpl.push('<div class="Image"><img id="imgItem" style="display: inline-block;" src="/img/world/items/big/'+(info['type'] == 'egg' ? 54 : info['number'])+'.png"></div>');
        }


        if(info['type'] == 'egg'){
            if(info['gens']){
                var gen = info['gens'].split(',');
                gen = '[h'+gen[0]+'a'+gen[1]+'d'+gen[2]+'s'+gen[3]+'sa'+gen[4]+'sd'+gen[5]+']';
                tpl.push('<div class="About">Генокод: '+gen+'</div>');
            }
            tpl.push('<div class="About">'+info['reborn']+'</div>');
        }

        if(info['about']){
            tpl.push('<div class="About">'+info['about']+'</div>');
        }


        var tpl_t_g = [];

        if(info['id']){
            tpl_t_g.push(
                $('<div />', {
                    'html':'Убрать',
                    'click':function(){

                        _self._action({
                            'removeObject': info['type'],
                            'objectID': parseInt(info['id'])
                        }, function(){

                            if(info['type'] != 'poke'){
                                if($('#modal').find('.ves-item').length){
                                    Game.mdl.mf('all');
                                }
                            }

                        });

                        tlp.empty().hide();
                    }
                })
            );
        }

        if(tpl_t_g.length){
            tpl.push(
                $('<div />', {
                    'class':'Buttons'
                }).append(
                    tpl_t_g
                )
            );
        }

        tlp.empty().append(tpl).show();
        tlp.click(function(){
            tlp.empty().hide();
        })

    };

    this._close = function(reset){

        if(_ref_timer){
            clearTimeout(_ref_timer);
            _ref_timer = 0;
        }

        if(reset){
            _self._action({
                'exit':'true'
            }, null, null, function(){
                _self._close(false);
            });
            return;
        }

        _data = {};

        if(window['isTrade']){
            window['isTrade'] = false;
        }else{
            isTrade = false;
        }

        if(window['ClassTrade']){
            window['ClassTrade'] = null;
        }else{
            ClassTrade = null;
        }

        if(_element_window){
            _element_window.remove();
        }

        _element_window_game = null;
        _element_window = null;
        _element_my = null;
        _element_enemy = null;
        _element_my_list = null;
        _element_enemy_list = null;
        _element_button_confirmed = null;
        _element_warning = null;
        _element_poke_info = null;
        _hash_enemy = '';
        _hash_my = '';
        _confirmed = 1;
		$('#battleMap').remove();
        $('.DivWorld').find('.DivMap').show();
    };

    _self._started(info);
};

/**
 * Chat Game
 *
 * @author Makasimka <000_01@list.ru>
 * @version 2.0
 *
 * @class GameChat
 */
var GameChat = function(uInfo){

    var _self = this;

    var _element_move_chat = $('.DivChat .Chat .Category'),
        _element_chat_channel,
        _element_chat_user = $('#chat_user_to'),
        _element_chat_send = $('#chat_send'),
        _element_chat_send_smile = $('.Smiles'),
        _element_scrolling = $('input.__chat_scrolls'),
        _element_command_list,
        _element_smile_list,
        _element_poke_info;

    var _userInfo = {},
        _userChannel = 0,
        _loaded = false,
        _lastID = 0,
        _readID = 0,
        _count_chanel = {},
        _poke_list = {};

    var _command_list = {
        's':{
            'group':[1,2,3],
            'title':'Выдать кляп',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь"/><input class="time" name="time" autocomplete="off" placeholder="Минуты"/><input class="title" name="title" autocomplete="off" placeholder="Причина"/>'
        },
        'us':{
            'group':[1,2,3],
            'title':'Снять кляп',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь" style="width: 170px;"/><input class="title" name="title" autocomplete="off" placeholder="Причина"/>'
        },
        'm':{
            'group':[1,2,3],
            'title':'Предупреждение в приват',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь" style="width: 170px;"/><input class="title" name="title" autocomplete="off" placeholder="Текст предупреждения"/>'
        },
        'mm':{
            'group':[1,2,3],
            'title':'Предупреждение в «МИР»',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь" style="width: 170px;"/><input class="title" name="title" autocomplete="off" placeholder="Текст предупреждения"/>'
        },
        'clear':{
            'group':[1,2,3],
            'title':'Очистить статус',
            'text':'<input class="big" name="user" autocomplete="off" placeholder="Пользователь"/>'
        },
        'free':{
            'group':[1,2],
            'title':'Освободить из тюрьмы',
            'text':'<input class="big" name="user" autocomplete="off" placeholder="Пользователь"/>'
        },
        'system':{
            'group':[1],
            'title':'Системное сообщение',
            'text':'<input class="big" name="text" autocomplete="off" placeholder="Текст"/>'
        },
        'prison':{
            'group':[1,2],
            'title':'Посадить в тюрьму',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь"/><input class="time" name="time" autocomplete="off" placeholder="Дни"/><input class="title" name="title" autocomplete="off" placeholder="Причина"/>'
        },
        'fine':{
            'group':[1,2],
            'title':'Штраф',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь"/><input class="sum" name="sum" autocomplete="off" placeholder="Сумма"/><input class="title" name="title" autocomplete="off" placeholder="Причина" style="width:220px;"/>'
        },
        'transf':{
            'group':[1,2],
            'title':'Изьятие пока',
            'text':'<input class="big" name="pokeID" autocomplete="off" placeholder="ID Покемона"/>'
        },
        'comment':{
            'group':[1],
            'title':'Комментарий',
            'text':'<input class="big" name="title" autocomplete="off" placeholder="Текст комментария"/>'
        },
        'ban':{
            'group':[1,2],
            'title':'Забанить пользователя',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь" style="width: 170px;"/><input class="title" name="title" autocomplete="off" placeholder="Причина"/>'
        },
        'tp':{
            'group':[1],
            'title':'Телепортироваться на локу',
            'text':'<input class="big" name="loc_name" autocomplete="off" placeholder="Название локации"/>'
        },
		'moder':{
            'group':[1,2,3],
            'title':'Сделать модератором',
            'text':'<input class="big" name="user" autocomplete="off" placeholder="Пользователь"/>'
        },
		'moderDel':{
            'group':[1,2,3],
            'title':'Удалить из модераторов',
            'text':'<input class="big" name="user" autocomplete="off" placeholder="Пользователь"/>'
        },
		'nast':{
            'group':[1,4],
            'title':'Сделать наставником',
            'text':'<input class="big" name="user" autocomplete="off" placeholder="Пользователь"/>'
        },
		'nastDel':{
            'group':[1,4],
            'title':'Удалить из наставников',
            'text':'<input class="big" name="user" autocomplete="off" placeholder="Пользователь"/>'
        },
		'upGroup':{
            'group':[1],
            'title':'Назначить должность',
            'text':'<input class="big" name="user" autocomplete="off" placeholder="Ник" style="width: 300px;"/><input class="group" name="group" autocomplete="off" placeholder="Должность" style="width: 170px;"/>'
        },
        'aqua':{
            'group':[1],
            'id':[1],
            'title':'Выдать жемчуг',
            'text':'<input class="user" name="user" autocomplete="off" placeholder="Пользователь" style="width: 170px;"/><input class="sum" name="sum" autocomplete="off" placeholder="Количество" style="width: 300px;"/>'
        }
    };

    this._action = function(data, suc, err, cpl){
        if(data){

            suc = (suc && isFunction(suc) ? suc : function(){});
            err = (err && isFunction(err) ? err : function(){});
            cpl = (cpl && isFunction(cpl) ? cpl : function(){});

            if(_loaded){
                cpl.call(_self, '');
                return false;
            }

            _loaded = true;

            $.ajax({
                url: "/do/chat",
                type: "POST",
                dataType: "json",
                data: $.extend({
                    'chat':'chat',
                    'lastID':_lastID,
                    'chanel':_userChannel
                }, data),

                success: function(info, textStatus){

                    if(info){
                        _self._update(info);
                    }

                    if(info['error']){
                        err.call(_self, textStatus);
                        Game.notifications.main(info['text'], 'error');
                    }else{
                        suc.call(_self, info, textStatus);
                    }

                    cpl.call(_self, info, textStatus);
                },

                complete: function(jqXHR, textStatus){
                    _loaded = false;
                    cpl.call(_self, textStatus);
                },

                error: function(jqXHR, textStatus){
                    err.call(_self, textStatus);
                    cpl.call(_self, textStatus);
                }

            });
        }
    };

    this._send = function(){

        var msg = _element_chat_send.val(),
            toUser = _element_chat_user.val();
        if(msg.length){
            _self._action({
                'type':'add',
                'msg':msg,
                'to_user':(toUser.length ? toUser : 0)
            });
            if(msg.substr(0,30) == '/' || msg.substr(0,30) == '=') {
              // var newChat = $("<div />", {
              //         class: "Active Button chat_move_channel_5"+toUser,
              //         html: ''+toUser+'',
              //         "data-channel": '5'+toUser,
              //         click: function () {
              //           _self._targetChannel(newChat);
              //         }
              //     }),
              //     newChatBlock = $("<div />", {
              //             class: "Active Message-Block Channel_5"+toUser,
              //             "data-channel": '5'+toUser
              //         });
              //     newChat.appendTo('.Chat .Category');
              //     newChatBlock.appendTo('.Chat .Talk');
              //     _self._targetChannel(newChat);
              _element_chat_send.val(msg.substr(0,1));
            }else{
              _element_chat_send.val('');
            }
        }
    };

    this._start = function(){
        var cop;
        if(GROUP_USER >= 1 && GROUP_USER <= 3) {
          cop = '<div class="Button chat_move_channel_10" data-channel="10">'+Lang.chat_cop+'</div>';
        }else {
          cop = '';
        }
        if(_element_move_chat && _element_move_chat.length){
			_element_move_chat.append(
			'<div class="Button chat_move_channel_0 Active" data-channel="0">'+Lang.chat_world+'</div>' +
			'<div class="Button chat_move_channel_30" data-channel="30">Приват</div>' + //временно
			'<div class="Button chat_move_channel_8" data-channel="8">Помощь</div>' + //временно
			
			'<div class="Button chat_move_channel_9" data-channel="9">'+Lang.chat_torg+'</div>' +
      '<div class="Button chat_move_channel_21" data-channel="21">'+Lang.chat_clan+'</div>' +
			cop
			);
            $('div.Message-Block').removeClass('Active');

            _element_move_chat.find('div.Button').click(function(){
                _self._targetChannel($(this));
            });

            _element_chat_channel = $('div.Message-Block.Channel_'+_userChannel);

            if(_element_chat_channel.length){
                _element_chat_channel.addClass('Active');
            }

            if(_element_chat_send_smile && _element_chat_send_smile.length){
                _element_chat_send_smile.on('click', function(){
                    _self._viewSmile();
                });
            }

            if(_element_scrolling.length){
                /*_element_scrolling.on('change', function(){

                });*/
            }

            if(_element_chat_send && _element_chat_send.length){
                _element_chat_send.off().on('keyup', function(){
                    if($(this).val().charAt(0) == '-'){
                        _self._viewCommand();
                    }else{
                        _self._viewCommand(true);
                    }
                });
            }
        }

    };

    this._update = function(data){

        if(data['infoChatLastId']){
            _lastID = data['infoChatLastId'];
        }

        if(data['infoChat']){

            $.each(data['infoChat'], function(key,val){
                if(val){
                    _self._generateMsg(key, (isObject(val) ? val : $.parseJSON(val)));
                }
            });

            if(_element_chat_channel.length){

                if(!(_element_scrolling.length && _element_scrolling.prop('checked'))){

                }else{
                    _element_chat_channel.animate({
                        'scrollTop': _element_chat_channel[0].scrollHeight
                    }, 300);
                }


                _element_chat_channel
                    .on('click', '.__info_usr_poke', function(e){
                        _self._pokeFocus(e, $(this).attr('data-id'));
                    });

            }

        }

    };

    this._pokeFocus = function(e, id){

        if(id && _poke_list){

            var info = _poke_list['p'+id];

            if(!info){
                return;
            }

            if(!_element_poke_info){
                _element_poke_info = $('<div />', {
                    'class':'window pokeInfo'
                }).appendTo('#window_games');
            }

            var ev = info['evcounts'].split(','),
                stat = info['stats'].split(','),
                gen = info['gen'].split(','),
                tpl_atk = [],
                exp = (info['lvl'] != 100 ? info['exp']+' / '+info['exp_max'] : 'полное'),
                nS = (info['type'] == 'normal' ? '' : info['type']),
                led,
                gender,
                tr,
                tr_n;
                if(info['gender'] == 'Мальчик') {
                  gender = 'mars';
                }else if(info['gender'] == 'Девочка') {
                  gender = 'venus';
                }else{
                  gender = 'genderless';
                }
                if(info['led']['gen'] == 1 && info['led']['char'] == 1) {
                  led = 'Горький и Кислый';
                }else if(info['led']['gen'] == 1 && info['led']['char'] != 1) {
                  led = 'Горький';
                }else if(info['led']['gen'] != 1 && info['led']['char'] == 1) {
                  led = 'Кислый';
                }else{
                  led = 'Не использовано';
                }
                if(info['tren_stat'] == 1) {
                  tr = 'в Атаку';
                }else if(info['tren_stat'] == 2) {
                  tr = 'в Защиту';
                }else if(info['tren_stat'] == 3) {
                  tr = 'в Скорость';
                }else if(info['tren_stat'] == 4) {
                  tr = 'в Спец. Атаку';
                }else if(info['tren_stat'] == 5) {
                  tr = 'в Спец. Защиту';
                }else{
                  tr = '';
                }

                if(info['tren'] == 1) {
                  tr_n = 'Начальная, ';
                }else if(info['tren'] == 2) {
                  tr_n = 'Морская, ';
                }else if(info['tren'] == 3) {
                  tr_n = 'Жемчужная, ';
                }else if(info['tren'] == 4) {
                  tr_n = 'Престижная, ';
                }else if(info['tren'] == 5) {
                  tr_n = 'Величайшая, ';
                }else if(info['tren'] == 6) {
                  tr_n = 'Легендарная, ';
                }else if(info['tren'] == 7) {
                  tr_n = 'Королевская, ';
                }else{
                  tr_n = 'Отсутствуют';
                }

            _element_poke_info.empty().append(
              '<div class="Pokemons">' +
              '<div class="Info">' +
              '<div class="Left">' +
              '<div class="PokemonBox">' +
              '<div class="Modif" style="background-image:url(/img/tren/'+info['tren']+'.png)"></div>' +
              '<img class="Image" src="/img/pokemons/mini/'+info['type']+'/'+_pokeNum(info['basenum'])+'.png">' +
              '<div class="Lvl">'+info['lvl']+'</div>' +
              '<div class="Unik '+info['type']+'-color">'+nS+'</div>'+
              '<div class="Name '+info['type']+'-color">' +
              '<div class="Text">#'+_pokeNum(info['basenum'])+' '+info['name']+'</div>' +
              '<div class="Sex '+(info['sparka'] == 0 ? '' : 'spar')+'"><i class="fas fa-'+gender+'"></i></div>' +
              '</div>' +
              '<div class="Bars">' +
              '<div class="Bar">' +
              '<div class="Text">'+info['hp']+' / '+stat['0']+'</div>' +
              '<div class="HpBar" style="width: '+(info['hp'] / stat['0']) * 100+'%;"></div>' +
              '</div>' +
              '<div class="Bar">' +
              '<div class="Text">'+exp+'</div>' +
              '<div class="ExpBar" style="width: '+(info['exp'] / stat['exp_max']) * 100+'%;"></div>' +
              '</div>' +
              '<div class="Bar">' +
              '<div class="Text">'+info['happy']+' / 255</div>' +
              '<div class="HappyBar" style="width: '+(info['happy'] / 255) * 100+'%;"></div>' +
              '</div>' +
              '</div>' +
              '</div>' +
              '<div class="MoveBox">' +
              ''+info['atk1']+'' +
              ''+info['atk2']+'' +
              ''+info['atk3']+'' +
              ''+info['atk4']+'' +
              '</div>' +
              '</div>' +
              '<div class="Right">' +
              '<div class="Id Id-trade'+(info['trade'] == 'true' ? 'Yes' : 'No')+'">id'+info['id']+'</div>' +
              '<div class="Info">' +
              '<div class="Step">Характер: <span>'+info['character']+'</span></div>' +
              '<div class="Step">Генокод: <span>h'+gen['0']+'a'+gen['1']+'d'+gen['2']+'s'+gen['3']+'sa'+gen['4']+'sd'+gen['5']+'</span>, Витамины: <span>'+info['vitamines']+'/100</span></div>' +
              '<div class="Step">Классификация: <span>'+tr_n+''+tr+'</span></div>' +
              '<div class="Step">Разведение: <span>'+(info['sparka'] == 0 ? 'Доступно' : 'Недоступно')+'</span>, Группа привлекательности: <span>'+info['sparkaNumber']+'</span></div>' +
              '<div class="Step">Заколдованные леденцы: <span>'+led+'</span></div>' +
              '<div class="Step">Пойман: <span>'+(info['birthday'] ? (info['birthday']['date']+'г. тренером '+info['birthday']['user']) : 'Неизвестно')+'</span></div>' +
              '<div class="Step">Способность: <span>в разработке</span></div>' +
              '</div>' +
              '<div class="MainInfo">' +
              '<div class="Stats">' +
              '<div class="Stat"><div class="Name">Здоровье</div><div class="Count">'+stat['0']+'</div> <div class="Progress"><div class="Text">'+ev[0]+' / 126 EV</div><div class="Bar" style="width: '+(ev[0]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Атака</div><div class="Count">'+stat['1']+'</div> <div class="Progress"><div class="Text">'+ev[1]+' / 126 EV</div><div class="Bar" style="width: '+(ev[1]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Защита</div><div class="Count">'+stat['2']+'</div> <div class="Progress"><div class="Text">'+ev[2]+' / 126 EV</div><div class="Bar" style="width: '+(ev[2]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Скорость</div><div class="Count">'+stat['3']+'</div> <div class="Progress"><div class="Text">'+ev[3]+' / 126 EV</div><div class="Bar" style="width: '+(ev[3]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Спец. Атака</div><div class="Count">'+stat['4']+'</div> <div class="Progress"><div class="Text">'+ev[4]+' / 126 EV</div><div class="Bar" style="width: '+(ev[4]/126 * 100)+'%;"></div></div></div>' +
              '<div class="Stat"><div class="Name">Спец. Защита</div><div class="Count">'+stat['5']+'</div> <div class="Progress"><div class="Text">'+ev[5]+' / 126 EV</div><div class="Bar" style="width: '+(ev[5]/126 * 100)+'%;"></div></div></div>' +
              '</div>' +
              '<div class="CountEv">Свободных EV: <span>'+info['ev']+'</span></div>' +
              '</div>' +
              '</div>' +
              '</div>'
            );

            _element_poke_info.css(getElCord(e, _element_poke_info, [-25, 6]));
            _element_poke_info.css('display', 'block');

            e.stopImmediatePropagation();
        }
    };

    this._updateCount = function(chanel){
        if(chanel !== true){
            var elm = _element_move_chat.find('div.chat_move_channel_'+chanel),
                count = _count_chanel['c'+chanel] || 0;
            if(elm.length){
                if(count > 0){
                    if(elm.find('span').length){
                        elm.find('span').html('+'+count)
                    }else{
                        elm.append(' <span>+'+count+'</span>')
                    }
                }else{
                    elm.find('span').remove();
                }
            }
        }else{
            _element_move_chat.find('div.Button').each(function(){
                _self._updateCount($(this).attr('data-channel'));
            });
        }
    };

    this._targetChannel = function(elm){
        if(elm && elm.length){
            var channel = elm.attr('data-channel');

            $('div.Message-Block').removeClass('Active');

            _element_move_chat.find('div.Button').removeClass('Active');

            _element_chat_channel = $('div.Message-Block.Channel_'+channel);

            if(_element_chat_channel.length){
                _count_chanel['c'+channel] = 0;
                _userChannel = channel;
                _element_chat_channel.addClass('Active');
                _element_move_chat.find('div.chat_move_channel_'+channel).addClass('Active').find('span').remove();

                _element_chat_channel.animate({
                    'scrollTop': _element_chat_channel[0].scrollHeight
                }, 650);
            }
        }
    };

    this._generateMsg = function(id, info){
        if(id > _readID){

            _readID = id;

            if(info['msg_type'] == 20){
                info['user_msg'] = (info['user_msg'] && !isObject(info['user_msg']) ? $.parseJSON(info['user_msg']) : {});
                if(info['user_msg']['msg_del']){
                    $('div.__msg_id_'+info['user_msg']['msg_del']).remove();
                }
                return '';
            }

            if(info['poke_list']){
                _poke_list = $.extend(_poke_list, info['poke_list']);
            }

            if(info['msg_type'] != 1 && _userChannel != info['msg_type']){
                if(_count_chanel['c'+info['msg_type']]){
                    _count_chanel['c'+info['msg_type']] += 1;
                }else{
                    _count_chanel['c'+info['msg_type']] = 1;
                }
                _self._updateCount(info['msg_type']);
            }

            var style = '', touser = '', channel = (info['msg_type'] == 1 ? true : info['msg_type']);

            if(info['user_id'] == _userInfo['id'] || (info['userto_id'] && info['userto_id'] == _userInfo['id'])){
                style = 'me '
            }
            if(info['msg_type'] == 1){
                style = 'private '
            }
            if(info['msg_type'] == 11){
                style = 'pred '
            }
            if(info['msg_type'] == 12){
                style = 'mut '
            }
            if(info['msg_type'] == 13){
                style = 'alert '
            }

            if(info['css']){
                style += ' '+info['css'];
            }

            if(info['userto_id']){
                touser = ' <i class="fas fa-angle-right"></i> <div class="user-link"> <div onclick=showUserTooltip("'+info['userto_id']+'") class="Info-Link sex'+info['sex_to']+'"><i class="fas fa-info"></i></div> <div class="u-'+info['userto_group']+'">'+info['userto_login']+'</div> </div>';
            }

            var snowly = '';

            if(_userInfo['id'] != info['user_id']){
                snowly = $('<div />', {
                    'class':'snow-user chat'
                }).on('click', function(e){
                    ClassInfo._action({
                        'type': 'snowball',
                        'view': 1,
                        'touser': info['user_id']
                    }, function(data){
                        if(data && data['inf_snowball']){
                            ClassInfo._snowball(e, data, info['user_id'], info['user_login']);
                        }
                    });
                }).on('contextmenu', function(e){
                    ClassInfo._snowball_act(e, null, info['user_id'], info['user_login']);
                    return false;
                });
            }
            $((channel === true ? 'div.Message-Block' : 'div.Message-Block.Channel_'+channel)).append(
                $('<div />', {
                    'class':'Message __msg_id_'+id+' '+style,
                    'id':'gameChatMessage'
                }).append(
                    $('<div />', {
                        'id':'gameChatMessageTime',
                        'class':'Data',
                        'html':info['msg_time'],
                        'click':function(e){
                            if(info['msg_type'] != 10){
                                _self._openHelper(e, id, info['user_login']+': '+info['user_msg']);
                            }
                        }
                    }),
					'<div class="User"><div class="user-link"> <div onclick=showUserTooltip("'+info['user_id']+'") class="Info-Link sex'+info['user_sex']+'"><i class="fas fa-info"></i></div> <div class="u-'+replaceEmoji(info['user_group'])+'">'+replaceEmoji(info['user_login'])+'</div> </div>'+touser+' <div class="DblDot">:</div></div> ' +
                    '<span class="TextColor'+info['user_msg_color']+' Post '+style+'">'+replaceEmoji(info['user_msg'])+'</span>'
                )
            );

        }
        return '';
    };

    this._openHelper = function(e, msg_id, msg_text){

        $('.GiveDiv').remove();

        var elm = $('<div />', {'class':'GiveDiv'});

        var tpl = [], tpl_list = [];


        if($.inArray(parseInt(_userInfo['group']), [1,2,3]) != -1){

            tpl_list.push(
                $('<div />', {
                    'class':'PokBtn',
                    'html': '<i class="fa fa-trash"></i> Удалить сообщение',
                    'click': function(){
                        _self._action({'type':'console', 'console':'mdel', 'msg_id':msg_id, 'msg_text':msg_text});
                        $('div.__msg_id_'+msg_id).remove();
                    }
                })
            )

        }else{

            tpl_list.push(
                $('<div />', {
                    'class':'PokBtn',
                    'html': '<i class="fa fa-flag"></i> Пожаловаться на сообщение',
                    'click': function(){
                        _self._action({'type':'console', 'console':'mreport', 'msg_id':msg_id, 'msg_text':msg_text});
                    }
                })
            )

        }

        if(tpl_list.length){
            tpl.push('<div id="DivAbout">Выберите действие</b></div>');

            tpl.push(
                $('<div />', {
                    'class':'wrap'
                }).append(
                    $('<div />', {
                        'class':'PokList'
                    }).append(
                        tpl_list
                    )
                )
            );

            elm.empty().append(tpl);

            elm.appendTo('body');

            elm.css(getElCord(e, elm, [145, 10]));
        }

    };

    this._upInfo = function(info){
        if(info){
            _userInfo = $.extend(_userInfo, info);
        }
    };

    this._viewSmile = function(hide){
        if(_element_smile_list && _element_smile_list.length){
            if(_element_smile_list.is(':visible')){
                _element_smile_list.css('display', 'none');
            }else{
                if(!hide){
                    _element_smile_list.css('display', 'block');
                }
            }
        }else{

            if(!hide){
                _element_smile_list = $('<div />', {
                    'class':'window smileList'
                }).appendTo('body');

                _element_smile_list.append(
                    showEmoji()
                );

                _element_smile_list.off().on('click', '.emoji', function(){
                    smile(_element_chat_send[0], ' '+$(this).attr('data-emoji')+' ');
                });
            }
        }
    };

    this._viewCommand = function(hide){
        if(_element_command_list && _element_command_list.length){
            if(_element_command_list.is(':visible')){
                if(hide){
                    _element_command_list.css('display', 'none');
                }
            }else{
                if(!hide){
                    if(!_element_command_list.is(':empty')){
                        _element_command_list.css('display', 'block');
                    }
                }
            }
        }else{

            if(!hide){
                _element_command_list = $('<div />', {
                    'class':'window commandList'
                }).appendTo('.Talk');

                var tpl = [];
                $.each(_command_list, function(key, val){
                    if(
                        (val['group'] && $.inArray(parseInt(_userInfo['group']), val['group']) != -1) ||
                        (val['id'] && $.inArray(parseInt(_userInfo['id']), val['id']) != -1)
                    ){
                        tpl.push(
                            $('<form />', {
                                'action':'',
                                'method':'POST',
                                'on':{
                                    'submit': function(){
                                        var data = {'type':'console', 'console':key}, form = $(this);
                                        $.each(form.serializeArray(), function(key, val){
                                            if(val && val['name']){
                                                data[val['name']] = val['value'];
                                            }
                                        });
                                        _self._action(data, null, null, function(){
                                            //form[0].reset();
                                        });
                                        return false;
                                    }
                                }
                            }).append(
                                $('<div />', {
                                    'class':'cmd'
                                }).append(
                                    '<h3>'+val['title']+'</h3>',
                                    val['text'],
                                    '<input type="submit" value="OK" />'
                                )
                            ).on('focus', 'input', function(){
                                if($(this).val() != 'OK'){
                                    $(this).val('');
                                }
                            })
                        );
                    }

                });

                if(tpl.length){
                    var msgField = $('#messageFieldBox');
                    _element_command_list.css('left',(parseInt(msgField.offset().left) - 0)+'px').append(tpl);
                }else{
                    _element_command_list.css('display', 'none');
                }
            }

        }
    };

    if(uInfo){
        _self._upInfo(uInfo);
        _self._start();
    }
};

var GameInfo = function(uInfo){

    var _self = this;

    var _element_userlist_loc = $('.TrainerList'),
        _element_userlist_loc_count = $('.Trainers .Name'),
        _element_sion_info,
        _element_window_offers
    ;

    var _userInfo = {},
        _loaded = false;

    var inputSnowball = null;

    this._action = function(data, suc, err, cpl){
        if(data){

            suc = (suc && isFunction(suc) ? suc : function(){});
            err = (err && isFunction(err) ? err : function(){});
            cpl = (cpl && isFunction(cpl) ? cpl : function(){});

            if(_loaded){
                cpl.call(_self, '');
                err.call(_self, '');
                return false;
            }

            _loaded = true;

            $.ajax({
                url: "/do/makasimka",
                type: "POST",
                dataType: "json",
                data: $.extend({
                    'makasimka':'true'
                }, data),
                beforeSend: function() {
                  $('.loadWorld').fadeIn(0);
                },

                success: function(info, textStatus){
                    _loaded = false;

					if(info['logDrop']){

						$.each(info['logDrop'], function(key, val){
						    if(val['name']){
                                Game.notifications.main('<img src="img/world/items/little/'+val['id']+'.png" class="item"> '+val['name']+' ('+val['count']+' шт.)', 'plus');
                            }
						});
					}
					if(info['minusItem']){

						$.each(info['minusItem'], function(key, val){
						    if(val['name']){
                                Game.notifications.main('<img src="img/world/items/little/'+val['id']+'.png" class="item"> '+val['name']+' ('+val['count']+' шт.)', 'minus');
                            }
						});
					}

                    if(info){
                        _self._update(info);
                    }

                    if(info['error']){
                        err.call(_self, textStatus);
                        Game.notifications.main(info['error']['text'],'error');
                    }else{
                        suc.call(_self, info, textStatus);
                    }

                    cpl.call(_self, info, textStatus);
                },

                complete: function(){
                    $('.loadWorld').fadeOut(100);
                    _loaded = false;
                },

                error: function(jqXHR, textStatus){
                    _loaded = false;
                    err.call(_self, textStatus);
                    cpl.call(_self, textStatus);
                }

            });
        }
    };

    this._byItem = function(item_id, npc_id, item_count){

        if(item_id > 0 && npc_id > 0 && item_count > 0){
            _self._action({
                'type': 'by_shop',
                'npc': parseInt(npc_id),
                'item': parseInt(item_id),
                'count': parseInt(item_count)
            }, function(resp){
                if(resp){

                    if('by_count' in resp){
                        $('div.__npc_item_'+npc_id).find('span.__count').html(resp['by_count']);
                    }

                    if(resp['by_ok']){
                        Game.notifications.main(resp['by_ok'], 'success');
                    }
                    if(resp['by_plus']){
                        Game.notifications.main(resp['by_plus'], 'plus');
                    }
                    if(resp['by_minus']){
                        Game.notifications.main(resp['by_minus'], 'minus');
                    }
                }
            });
        }else{
            Game.notifications.main('Некорректные данные!', 'error');
        }

    };

    this._byItemWindow = function(npc_id){

        if(npc_id > 0){
            _self._action({
                'type': 'view_shop',
                'npc': parseInt(npc_id)
            }, function(resp){
                if(resp){

                    if(resp['by_list']){

                        var tpl = '<div class="model"><div class="header">Продавец<span onclick=$(".model").remove();><i class="fa fa-close"></i></span></div>';
                        tpl += '<div class="content-model">';
                        tpl += resp['by_list'];
                        tpl += '</div>';
                        $("body").append(tpl);
                        $('.model').draggabilly({
                            handle: '.header',
                            containment: true
                        });

                    }

                }
            });
        }else{
            Game.notifications.main('Некорректные данные!', 'error');
        }

    };

    this._upUsrLoc = function(info, notice){

        if(info && _element_userlist_loc && _element_userlist_loc.length){
            var count = 0, tpl = [];

            $.each(info, function(key, val){
                ++count;

                if(val['isOffer']){
                    tpl.unshift(_self._generateUsrBlock(val, notice));
                }else{
                    tpl.push(_self._generateUsrBlock(val, notice));
                }

            });

            if(tpl.length){
                _element_userlist_loc.empty().append(tpl);
                _element_userlist_loc_count.html('Тренеров: '+count);
            }
        }

    };

    this._snowball_act = function(e, data, touser, name, val_id){
        _self._action({
            'type': 'snowball',
            'use': (val_id || 1),
            'touser': touser,
            'rand': (data ? 0 : 1),
            'count': (data ? (inputSnowball && inputSnowball.val() > 0 ? inputSnowball.val() : 1) : 1)
        }, function(resp){
            if(resp){
                if(data && resp['inf_snowball']){
                    _self._snowball(e, resp, touser, name);
                }
                Game.notifications.main('Снаряд успешно долетел до цели ('+name+').'+(resp['inf_count'] !== false ? ' Осталось: х'+resp['inf_count'] : '' ),'success');
            }
        });
    };

    this._snowball = function(e, data, touser, name){

        if(data){

            $('.GiveDiv').remove();

            var elm = $('<div />', {'class':'GiveDiv'}), tpl = [], tpl_list = [];

            if(data['inf_snowball']){

                tpl.push('<div id="DivAbout">Выберите снежок'+(name ? ' в '+name : '')+':</b></div>');

                $.each(data['inf_snowball'], function(key, val){

                    if(val['count'] && val['count'] > 0){
                        tpl_list.push(
                            $('<div />', {
                                'class':'PokBtn',
                                'html':val['name']+' x'+val['count'],
                                'click': function(e){
                                    _self._snowball_act(e, data, touser, name, val['id']);
                                }
                            })
                        );
                    }

                });

                if(tpl_list.length <= 0){
                    Game.notifications.main('Сейчас у вас нет комков. Попробуйте отобрать их у диких покемонов.','success');
                    return;
                }else{

                    if(inputSnowball){
                        inputSnowball.remove();
                        inputSnowball = null;
                    }

                    inputSnowball = $('<input />', {
                        'class':'no_hide',
                        'placeholder':'Введите желаемое количество',
                        'type':'number'
                    }).on('focus click', function(e){
                        e.stopImmediatePropagation();
                        e.stopPropagation();
                    });

                    tpl_list.unshift(
                        $('<div />', {
                            'class':'PokBtn no_hide'
                        }).append(
                            inputSnowball
                        )
                    );
                }

            }

            if(tpl.length && tpl_list.length){

                tpl_list.push(
                    $('<div />', {
                        'class':'PokBtn',
                        'html': 'Закрыть'
                    })
                );

                tpl.push(
                    $('<div />', {
                        'class':'wrap'
                    }).append(
                        $('<div />', {
                            'class':'PokList'
                        }).append(
                            tpl_list
                        )
                    )
                );

                elm.appendTo('body');

                elm.empty().append(tpl).css(getElCord(e, elm, [-45, -19]));
            }else{
                Game.notifications.main('Сейчас у вас нет комков. Попробуйте отобрать их у диких покемонов.','success');
            }
        }


    };

    this._generateUsrBlock = function(val, notice){
        if(val && val['id']){
            var elm = $('<div />', {
                'id':'_list_user_id_'+val['id'],
                //html: '<div class="user-link"> <div class="Info sexM"> <i class="fas fa-info"></i> </div> <div class="u-1">AnarHeest</div> </div>',
                'class':'Trainer'
            });


             if(_userInfo['id'] != val['id']){
                 elm.append(
                     $('<div />', {
                         'class':'snow-user'
                     }).on('click', function(e){
                         _self._action({
                             'type': 'snowball',
                             'view': 1,
                             'touser': val['id']
                         }, function(data){
                             if(data && data['inf_snowball']){
                                 _self._snowball(e, data, val['id'], val['login']);
                             }
                         });
                     })
                 );
             }

            elm.append(
                '<div class="user-link"><div onclick="showUserTooltip(\''+val['id']+'\')" class="Info-Link sex'+val['sex']+'"><i class="fa fa-info"></i></div> <div class="u-'+val['group']+'">'+val['login']+'</div></div>'
            );



            if(notice && notice['u'+val['id']]){
                $.each(notice['u'+val['id']], function(key, not){
                    if(not['type']){
                        switch(not['type']){
                            case 'battle':
                                elm.append(
                                    $('<div />', {
                                        'class': 'bt_battle __interval_effect',
										html: '<i class="fa fa-bolt"></i>'
                                    }).on('click', function(e){
                                        var el_this = $(this);
                                        _self._viewOffers(e, {
                                            'text': ''+val['login']+' вызывает вас на бой!',
                                            'yes':function(){
                                                _self._action({
                                                    'type': 'offers',
                                                    'offerID': not['id'],
                                                    'confirmed':1
                                                });
                                                el_this.remove();
                                                return false;
                                            },
                                            'no': function(){
                                                _self._action({
                                                    'type': 'offers',
                                                    'offerID': not['id'],
                                                    'confirmed':0
                                                });
                                                el_this.remove();
                                                return false;
                                            }
                                        });
                                    })
                                );
                                break;
                            case 'trade':
                                elm.append(
                                    $('<div />', {
                                        'class': 'bt_trade __interval_effect',
										html: '<i class="fa fa-handshake"></i>'
                                    }).on('click', function(e){
                                        var el_this = $(this);
                                        _self._viewOffers(e, {
                                            'text': val['login']+' хочет с вами обменяться!',
                                            'yes':function(){
                                                _self._action({
                                                    'type': 'offers',
                                                    'offerID': not['id'],
                                                    'confirmed':1
                                                });
                                                el_this.remove();
                                                return false;
                                            },
                                            'no': function(){
                                                _self._action({
                                                    'type': 'offers',
                                                    'offerID': not['id'],
                                                    'confirmed':0
                                                });
                                                el_this.remove();
                                                return false;
                                            }
                                        });
                                    })
                                );
                                break;
                        }
                    }
                });

            }
            var intervalNumber = 0, elements = elm.find('.__interval_effect');

            return elm;
        }
        return '';
    };

    this._viewOffers = function(e, info){

        if( info && info['close']){
            if(_element_window_offers && _element_window_offers.length){
                _element_window_offers.css('display', 'none');
            }
            return;
        }

        if(!_element_window_offers){

            _element_window_offers = $('<div />', {
                'class':'window offers'
            }).appendTo('#window_games');

            $('body')
                .off('click._viewOffers')
                .on( 'click._viewOffers', function(){
                    if(_element_window_offers){
                        _element_window_offers.css('display', 'none');
                    }
                    $('body').off('click.pokeInfoTrade');
                });
        }

        if(_element_window_offers.length && info && info['text']){

            _element_window_offers.empty().append(
                $('<div />', {
                    'class':'off-info'
                }).append(info['text'])
            ).append(
                $('<div />').append(
                    $('<div />', {
                        'class':'button',
                        'html':'Принять',
                        'on':{
                            'click':function(e){
                                if(info['yes'] && isFunction(info['yes'])){
                                    if(info['yes'].call(null, e) === false){
                                        _element_window_offers.css('display', 'none');
                                    }
                                }else{
                                    _element_window_offers.css('display', 'none');
                                }
                            }
                        }
                    }),
                    $('<div />', {
                        'class':'button',
                        'html':'Отказаться',
                        'on':{
                            'click':function(e){
                                if(info['no'] && isFunction(info['no'])){
                                    if(info['no'].call(null, e) === false){
                                        _element_window_offers.css('display', 'none');
                                    }
                                }else{
                                    _element_window_offers.css('display', 'none');
                                }
                            }
                        }
                    })
                )
            );

            _element_window_offers.css('display', 'block');
            _element_window_offers.css(getElCord(e, _element_window_offers, [-40, -30]));
            e.stopPropagation();
        }
    };

    this._update = function(data){

    };

    this._upInfo = function(info){
        if(info){
            _userInfo = $.extend(_userInfo, info);
        }
    };

    if(uInfo){
        _self._upInfo(uInfo);
    }
};


var GameBattle = function(info){

    var _self = this;

    var _element_window,
        _element_window_wrap,
        _element_window_started,
        _element_window_game = $('.DivWorld'),
        _element_poke_info_my,
        _element_poke_info_my_img,
        _element_poke_info_my_name,
        _element_poke_info_my_lvl,
        _element_poke_info_my_ball,
        _element_poke_info_my_unik,
	      _element_poke_info_my_tren,
        _element_poke_info_my_item,
        _element_poke_info_my_move,
        _element_poke_info_my_stat,

        _element_poke_info_enemy,
        _element_poke_info_enemy_img,
        _element_poke_info_enemy_name,
        _element_poke_info_enemy_lvl,
        _element_poke_info_enemy_ball,
        _element_poke_info_enemy_unik,
	      _element_poke_info_enemy_tren,
        _element_poke_info_enemy_item,
        _element_poke_info_enemy_stat,
        _element_enemy_ball,

        _element_my_name,
        _element_enemy_name,
        _element_round_time,
        _element_round_time_count,
        _element_round_count,
        _element_round_weather,
        _element_round_img,
        _element_content_log,
        _element_content_captcha,
        _element_content_captcha_input,
        _element_button_exit
    ;

    var _open = false,
        _selected = false,
        _battle_end = false,
        _data = {};

    this._action = function(data, suc, err, cpl){
        if(ClassInfo){

            data = $.extend({
                'type':'battle'
            }, data);

            ClassInfo._action(data, function(info){

                if(info && info['battleInfo']){
                    _self._update(info['battleInfo']);
                }

                if(info['error']){
                    Game.notifications.main(info['text'], 'error');
                }

                if(info && info['captcha']){
                    _self._update_captcha(info['captcha']);
                }


                if(suc && isFunction(suc)){
                    suc.call(_self, info);
                }

            }, err, cpl);

        }
    };

    this._close = function(){
        if(_open){
            if(_element_window){
                _element_window.empty().remove();
                _element_window = null;
            }
            if(_element_window_game){
				$('#battleMap').remove();
                _element_window_game.find('.DivMap').show();
            }
            _selected = false;
            _data = {};
            _open = false;
			document.title = 'League 18';
        }
    };

    this._open = function(data){

        if(_open){
            _self._update(data);
            return;
        }

        if(_element_window_game && _element_window_game.length){
            _open = true;
			if(UserAudio == 1){
				$('#battleAudio')[0].play();
			}
			document.title = 'League 18 - Бой!';
            _element_window = $('<div />', {
                'class':'Battle'
            }).css('display', 'none');
            _element_window_started = $('<div />', {
                'class':'started'
            }).append(
                '<h3>Для начала выберите стартового покемона:</h3>',
                '<div class="pokeList"></div>'
            ).on('click', function(){
                _element_window_started.css('display', 'none');
                _selected = false;
            });
            _element_window_wrap = $('<div />', {
                'class':'DivMap',
				'id': 'battleMap'
            });
            _element_poke_info_my_img = $('<img />', {
                'class':'imgPok Image blank',
                'src':'/img/css/blank.png'
            });
            _element_poke_info_my_name = $('<div />', {
                'class':'namePokemon Name __name',
                'html':'#??? ______'
            });
            _element_poke_info_my_lvl = $('<div />', {
                'class':'lvlPokemonOne Lvl __lvl',
                'html': '???'
            });
            _element_poke_info_my_ball = $('<div />', {
                'class':'ballPokemonOne Ball __ball'
            });
            _element_poke_info_my_unik = $('<div />', {
                'class':'unikPokemonOne Unik __unik',
                'html': ''
            });
            _element_poke_info_my_item = $('<div />', {
                'class':'itemPokemonOne Item __item'
            });
            _element_poke_info_my_move = $('<div />', {
                'class':'MoveBox'
            });
			_element_poke_info_my_tren = $('<div />', {
                'class':'Modif _modif_my'
            });
            _element_my_name = $('<div />', {
                'class':'Left'
            });
            _element_enemy_name = $('<div />', {
                'class':'Right'
            });
            _element_content_captcha_input = $('<input />', {
                'placeholder':'Введите результат',
                'maxlength':'200',
                'title':'Введите результат',
                'value':'',
                'type':'text',
                'class': 'inpt',
                'onclick': 'submit(e)'
            });
_element_content_captcha_input.keypress(function(e) {
  if (e.which == 13) {
        _self._action({
           'captcha':_element_content_captcha_input.val()
        });
  }
});
            _element_content_captcha = $('<div />', {'class':'captcha'}).append(
                '<h3>Сложите числа и введите полученный результат.</h3>',
                '<div class="title">2 + 3 = </div>',
                _element_content_captcha_input,
                $('<input />', {
                    'value':'OK',
                    'type':'button',
                    'class': 'ok'
                }).click(function(){
                    if(_element_content_captcha_input){
                        _self._action({
                            'captcha':_element_content_captcha_input.val()
                        });
                    }
                })
            );
            _element_round_weather = $('<img />');
            _element_round_count = $('<span />', {'html':'1'});
            _element_round_time_count = $('<span />', {'html':'0'});
            _element_round_time = $('<div />', {
                'class':'timeBattle'
            }).append(
                'Ход соперника<br>Осталось ',
                _element_round_time_count,
                ' сек.'
            );

            _element_poke_info_my = $('<div />', {
                'class':'PokemonA'
            }).append(
                $('<div />', {
                    'class':'PokemonBox2'
                }).append(
                    _element_poke_info_my_img,
                    _element_poke_info_my_name,
                    _element_poke_info_my_lvl,
                    _element_poke_info_my_ball,
                    _element_poke_info_my_unik,
                    _element_poke_info_my_tren,
                    _element_poke_info_my_item,
                    $('<div />', {
                        'class':'Bars'
                    }).append(
                        $('<div />', {
                            'class':'Bar'
                        }).append(
                          $('<div />', {
                              'class': 'Text __hp',
                              'html':'??? / ???'
                          }),
                          $('<div />', {
                              'class': 'HpBar __hpW',
                              'style': 'width: 100%;'
                          })
                        ),
                        $('<div />', {
                            'class':'Bar'
                        }).append(
                          $('<div />', {
                              'class': 'Text __exp',
                              'html':'??? / ???'
                          }),
                          $('<div />', {
                              'class': 'ExpBar __expW',
                              'style': 'width: 100%;'
                          })
                        )
                    )
                ),
                _element_poke_info_my_move
            );

            _element_poke_info_enemy_img = $('<img />', {
                'class':'imgPok Image blank',
                'src':'/img/css/blank.png'
            });
            _element_poke_info_enemy_name = $('<div />', {
                'class':'namePokemon Name __name',
                'html':'#??? ______'
            });
            _element_poke_info_enemy_lvl = $('<div />', {
                'class':'lvlPokemonTwo Lvl __lvl',
                'html':'???',

            });
            _element_poke_info_enemy_ball = $('<div />', {
                'class':'ballPokemonTwo Ball __ball',
                'style':'left: -15px;'
            });
            _element_poke_info_enemy_unik = $('<div />', {
                'class':'unikPokemonOne Unik __unik',
                'html': ''
            });
            _element_poke_info_enemy_item = $('<div />', {
                'class':'itemPokemonTwo Item __item'
            });
            _element_poke_info_enemy_tren = $('<div />', {
                'class':'Modif _modif_enemy'
            });
            _element_enemy_ball = $('<div />', {
                'class':'TeamB'
            });

            _element_button_exit  =  $('<div />', {
                'class':'buttonFight',
                  'html':'<img src="/img/world/items/exit.png" style="width: 45px;position: absolute; top: 30px;right: 850px;">'
            }).click(function(){
                _self._close();
            });
$(document).ready(function(){
    $("#showHideContent").click(function () {
        if ($("#content").is(":hidden")) {
            $("#content").slideDown("slow");
        } else {
            $("#content").slideUp("slow");
        }
        return false;
    });
});
            _element_poke_info_enemy = $('<div />', {
                'class':'PokemonB'
            }).append(
                $('<div />', {
                    'class':'PokemonBox3'
                }).append(
                   _element_poke_info_enemy_img,
                    _element_poke_info_enemy_name,
                    _element_poke_info_enemy_lvl,
                    _element_poke_info_enemy_ball,
                    _element_poke_info_enemy_unik,
	                  _element_poke_info_enemy_tren,
                    _element_poke_info_enemy_item,
                 
                    $('<div />', {
                        'class':'Bars'
                      }).append(
                          $('<div />', {
                              'class':'Bar'
                          }).append(
                            $('<div />', {
                                'class': 'Text __hp',
                                'html':'??? / ???'
                            }),
                            $('<div />', {
                                'class': 'HpBar __hpW',
                                'style': 'width: 100%;'
                            })
                          ),
                          $('<div />', {
                              'class':'Bar2'
                          }).append(
                            $('<div />', {
                              
                            })
                           
                          )
                      )
                ),
                $('<div />', {
                    'class':'Info'
                }).append(
                _element_enemy_ball,
                $('<div />', {
                    'class':'buttons'
                }).append(
                    $('<div />', {
                        'class':'buttonFight',
                        'html':'<img src="/img/world/items/balls.png" style="width: 45px;position: absolute; top: 30px;right: 720px;">'
                    }).click(function(){
                        if(_data['myTarget']){
                            _selected = true;
                            _self._viewMyTeam((_data['myTeam'] || null), _data['myTarget']['id'], 'Выберите замену:');
                            _element_window_started.find('div.pokeList').css('display', 'block');
                        }
                    }),
                    $('<div />', {
                        'class':'buttonFight',
                        'html':'<img src="/img/world/items/inv.png" style="width: 45px;position: absolute; top: 30px;right: 785px;">'
                    }).click(function(e){
                       _self._openBall(e);
                    }),
                    $('<div />', {
                        'class':'buttonFight',
                         'html':'<img src="/img/world/items/exit.png" style="width: 45px;position: absolute; top: 30px;right: 850px;">'
                    }).click(function(){
                        _self._action({
                            'coward':1
                        });
                    }), 
                    _element_button_exit
                  )
                )
            );

            _element_window_game.find('.DivMap').hide();

            _element_content_log =  $('<div />', {
                'class':'Log'
            });

            _element_poke_info_my_stat = $('<div />', {
                'class':'StatusStatsA'
            });
            _element_poke_info_enemy_stat = $('<div />', {
                'class':'StatusStatsB'
            });
			_element_poke_info_my_stat_a = $('<div />', {
                'class':'StatusStatusesA'
            });
			_element_poke_info_enemy_stat_a = $('<div />', {
                'class':'StatusStatusesB'
            });


            _element_window_game
                .append(
                    _element_window_wrap.append(
                        _element_window.append(
                            _element_window_started,
                            _element_poke_info_my,
                            $('<div />', {
                                'class':'Content'
                            }).append(
                                _element_content_captcha,
                                $('<div />', {
                                    'class':'Users'
                                }).append(
                                   _element_my_name,
                                   _element_enemy_name
                                ),
                                $('<div />', {
                                    'class':'Zone',
                                }).append(
                                  $('<div />', {
                                      'class':'StatusA',
                                  }).append(
                                    _element_poke_info_my_stat,
                                    _element_poke_info_my_stat_a
                                  ),
                                  $('<div />', {
                                      'class':'StatusB',
                                  }).append(
                                    _element_poke_info_enemy_stat,
                                    _element_poke_info_enemy_stat_a
                                  ),
                                  $('<div />', {
                                      'class':'Weath'
                                  }).append(
                                    _element_round_weather
                                  ),
                                  $('<div />', {
                                      'class':'Round'
                                  }).append(
                                      $('<div />', {
                                          'class':'Text',
                                          'html': 'Раунд '
                                      }).append(_element_round_count),
                                      _element_round_time
                                  )
                                ),
                                _element_content_log
                            ),
                            _element_poke_info_enemy
                        )
                    )
                );

            _self._update(data, true);
            _element_window.css('display', 'flex');
        }
    };

    this._openBall = function(e, data){
        if(!data){

            if(ClassInfo){
                ClassInfo._action({
                    'type':'items',
                    'cat':'ball'
                }, function(info){

                    if(info && info['ballList']){
                        _self._openBall(e, (info['ballList'] || true));
                    }

                });
            }
            return;
        }

        $('.GiveDiv').remove();

        var elm = $('<div />', {'class':'GiveDiv'});

        var tpl = [], tpl_list = [];

        $.each(data, function(key, val){
            tpl_list.push(
                $('<div />', {
                    'class':'PokBtn',
                    'html':val['name']+' ('+val['count']+' шт.)',
                    'click': function(){
                        _self._action({
                            'catch':val['id']
                        });
                    }
                })
            )
        });

        if(tpl_list.length){
            tpl.push('<div id="DivAbout">Выберите предмет</b></div>');

            tpl.push(
                $('<div />', {
                    'class':'wrap'
                }).append(
                    $('<div />', {
                        'class':'PokList'
                    }).append(
                        tpl_list
                    )
                )
            );

            elm.empty().append(tpl);

            elm.appendTo('body');

            elm.css(getElCord(e, elm, [-25, 6]));
        }
    };

    this._update = function(info, first){

        if(_element_window && _element_window.length && info){
            if(first){

            }
            if(_element_window_started && _element_window_started.length){

                if(!(_data['id'] && _data['id'] == info['id'])){
                    _data = {};
                    _battle_end = false;

                    if(_element_my_name && _element_enemy_name){
                        _element_my_name.empty().append(_self._viewName(info['my']));
                        _element_enemy_name.empty().append(_self._viewName(info['enemy']));
                    }

                    if(_element_content_log){
                        _element_content_log.empty();
                    }

                    if(_element_poke_info_my_move){
                        _element_poke_info_my_move.css('display', 'block');
                    }

                    _element_poke_info_enemy.find('div.buttonFight').css('display', 'block');

                    if(_element_button_exit){
                        _element_button_exit.css('display', 'none');
                    }
                }

                _data = info;

                if(!(info['myTarget'] && info['myTarget']['id'])){
                    _element_window_started.css('display', 'block');
                    _self._viewMyTeam((info['myTeam'] || null));
                }else{
                    if(!(info['enemyTarget'] && info['enemyTarget']['id'])){
                        _element_window_started.css('display', 'block');
                        _element_window_started.find('h3').html('Ожидайте выбор соперника...');
                        _element_window_started.find('div.pokeList').css('display', 'none');
                    }else{
                        if(!_selected){
                            _element_window_started.css('display', 'none');
                        }
                        _self._updatePoke(_element_poke_info_enemy, info['enemyTarget']);
                    }

                    if(_element_round_count && info['round']){
                        _element_round_count.html(info['round']);
                    }

                    if(_element_round_count && info['weather']){
                        _element_round_weather.attr('src','/img/weather/'+info['weather']+'.png');
                    }

                    $('.Battle .Content .Zone').attr('style','background-image: url(battlefon.png);');

                    var timer = 0;
                    if(info['timeout']){
                        $.each(info['timeout'], function(key, val){
                            if(val > 0){
                                if(timer <= 0 || timer <= val){
                                    timer = val;
                                }
                            }
                        });
                    }
                    _self._viewTime(timer, info);

                    _self._updatePoke(_element_poke_info_my, info['myTarget'], true);


                    var btlEnd = null;
                    if(info['log']){

                        if(info['log']['battleEND']){

                            btlEnd = info['log']['battleEND'];

                            if(_element_poke_info_my_move){
                                _element_poke_info_my_move.addClass('waiting');
                            }

                            _element_poke_info_enemy.find('div.buttonFight').css('display', 'none');

                            if(_element_button_exit){
                                _element_button_exit.css('display', 'block');
                            }

                            _element_content_log.prepend(
                                $('#battleMap .Battle .Content .Log').prepend(
                                    $('<div />', {
                                        'class':'endFight'
                                    }).html('Бой окончен! '+(btlEnd['winner'] === false && btlEnd['loser'] === false ? (btlEnd['title'] == 'CATCH' ? 'Вы успешный ловец!'  : 'Оба соперника были равными.') : 'Победа за '+(info['my']['id'] == btlEnd['winner'] ? info['my']['login'] : info['enemy']['login'])+'!'))
                                )
                            );
                        }

                    }
                    if(!btlEnd){
						if(info['myTarget'] && info['myTarget']['hp'] <= 0){
                            _self._viewMyTeam((_data['myTeam'] || null), info['myTarget']['id'], 'Выберите покемона для замены:');
							_element_window_started.find('div.pokeList').css('display', 'block');
                        }
						if(info['enemyTarget'] && info['enemyTarget']['hp'] <= 0){
							_element_poke_info_my_move.addClass('waiting');
						}
                    }else{
                        _battle_end = true;
                    }

                }
            }
        }
    };

    this._update_captcha = function(info){
        if(info && _element_content_captcha){
            if(info['title']){
                _element_content_captcha_input.val('');
                _element_content_captcha.find('div.title').html(info['title']);
                _element_content_captcha.css('display', 'block');
            }
            if(info['cpl']){
                _element_content_captcha.css('display', 'none');
            }
        }
    };

    this._aHH = function(team, e) {
      $('.GiveDiv').remove();

      var elm = $('<div />', {'class':'GiveDiv'});

      var tpl = [], tpl_list = [];

      $.each(team, function(key, val){
          tpl_list.push(
              $('<div />', {
                  'class':'PokeUse',
                  'html': function () {
                    var a = '';
                    a += '<img src="/img/pokemons/mini/'+val.type+'/'+val.basenum2+'.png"> <div class="NameUse '+val.type+'-color">#'+val.basenum2+' '+val.name+'</div>'
                    return a;
                  },
                  'click': function(){
                      _self._action({
                          'aHH':val['id']
                      });
                  }
              })
          )
      });

      if(tpl_list.length){
          tpl.push('<div id="DivAbout">Рука помощи на</b></div>');

          tpl.push(
              $('<div />', {
                  'class':'wrap'
              }).append(
                  $('<div />', {
                      'class':'PokList'
                  }).append(
                      tpl_list
                  )
              )
          );

          elm.empty().append(tpl);

          elm.appendTo('body');

          elm.css(getElCord(e, elm, [-25, 6]));
      }
    };

    this._viewMyTeam = function(team, delID, title){
        if(team && _element_window_started){

            if(!delID){
                delID = 0;
            }

            var tpl = [], elm_list = _element_window_started.find('div.pokeList');

            $.each(team, function(key, val){
                if(val['id'] && delID != val['id'] && val['hp'] > 0){
                    tpl.push(
                        $('<div />', {
                            'click':function(e){
                                _selected = false;

                                if(ClassInfo){

                                    ClassInfo._action({
                                        'type':'battle',
                                        'targetPoke':val['id']
                                    }, function(info){
                                        _self._update((info['battleInfo'] || null))
                                    });

                                }
                                e.stopPropagation();
                            },
                            'html': function() {
                              var hp = (val.hp/val.hp_max) * 100;
                              var happy = (val.happy/255) * 100;
                              var exp = (val.exp/val.exp_max) * 100;
                              var a = '';
                              a += '<div class="PokemonBox"><div class="Modif" style="background-image: url(/img/tren/'+val.tren+'.png);"></div><img class="Image" src=/img/pokemons/mini/'+val.type+'/'+val.basenum2+'.png><div class="Lvl">'+val.lvl+'</div><div style="background-image: url(/img/world/items/little/'+val.item+'.png);" class="Item"></div><div class="Unik '+val.type+'-color">'+val.type2+'</div><div class="Name '+val.type+'-color"><div class="Text">#'+val.basenum2+' '+val.name.slice(0,8)+'...'+'</div><div class="Sex"><i class="fas fa-'+val.sex2+'"></i></div></div><div class="Bars"><div class="Bar"><div class="Text">'+val.hp+' / '+val.hp_max+'</div><div class="HpBar" style="width: '+hp+'%;"></div></div></div></div>'
                              return a;
                            }
                        })
                    );
                }
            });

            if(tpl.length){
                _element_window_started.find('h3').html((title ? title : 'Для начала выберите стартового покемона:'));
                elm_list.empty().append(tpl);
                _element_window_started.css('display', 'block');
            }else{
                elm_list.empty();
                _element_window_started.css('display', 'none');
                _selected = false;
            }

        }
    };

    this._parserLogStatus = function(info){

        var tpl = [];

        $.each(info, function(key, val){
            tpl.push($('<div />', {
                'class':'sub',
                'html':val
            }));
        });

        if(tpl.length){
            return $('<div />', {
                'class':'pokLogBattle'
            }).append(
                $('<div />', {'class':'text'}).append(
                    tpl
                )
            );
        }

        return '';
    };

    this._parserLog = function(info, recurse){

        if(!recurse){
            var tpl = [];

            $.each(info, function(key, val){
                tpl.push(_self._parserLog(val, true));
            });

            return tpl;
        }

        var uInfo = (_data['my']['id'] == info['user'] ? _data['my'] : _data['enemy']),
            elm = $('<div />', {'class':'text'});

        if(!uInfo){
            return '';
        }

        if(info['start']){
            $.each(info['start'], function(key, val){
                elm.append(
                    $('<div />', {
                        'class':'sub',
                        'html':val
                    })
                );
            });
        }
        if(info['log']){
            $.each(info['log'], function(key, val){
                elm.append(
                    $('<div />', {
                        'class':'sub',
                        'html':val
                    })
                );
            });
        }
        if(info['end']){
            $.each(info['end'], function(key, val){
                elm.append(
                    $('<div />', {
                        'class':'sub',
                        'html':val
                    })
                );
            });
        }

        return $('<div />', {
            'class':'pokLogBattle'
        }).append(
            $('<div />', {
                'class':'pers'
            }).append(
                (uInfo['id'] > 0 ? '<img src="img/avatars/mini/'+uInfo['id']+'.png" class="ava">' : '<img src="img/avatars/mini/'+_data['enemyTarget']['id']+'.png" class="ava">'),
                '<div class="nick">'+(uInfo['id'] > 0 ? '<div class="user-link u-'+uInfo['group']+'">'+uInfo['login']+'</div>' : _data['enemyTarget']['name'])+'</div>'
            ),
            elm
        );
    };

    this._viewTime = function(timer, info){
        if(timer > 0){

            if(timer - info['time'] <= 0){
                if(!_battle_end){
                    _self._action({
                        'check_timer':1
                    });
                }
            }else{
                if(_element_round_time_count){
                    _element_round_time_count.html((info['time'] ?  (timer - info['time']) : 0));
                }
                if(_element_round_time){
                    _element_round_time.css('display', 'block');
                }
                if(_element_poke_info_my_move){
                    _element_poke_info_my_move.addClass('waiting');
                }
            }



        }else{
            if(_element_round_time){
                _element_round_time.css('display', 'none');
            }
            if(_element_poke_info_my_move){
                _element_poke_info_my_move.removeClass('waiting');
            }
        }
    };

    this._updatePoke = function(element, info, my){
        if(element && element.length && info){
            var tpl = [],
                sex;
			var num = (info['basenum'] || 0);
			num = (num < 10 ? '00'+num : num < 100 ? '0'+num : num);
			if(info['type'] != 'normal'){
				var typePok = info['type'];
			}else{
				var typePok = '';
			}
      if(info['basenum'] != 10000) {
        if(info['sex'] == 'Мальчик') {
          sex = 'mars';
        }else if(info['sex'] == 'Девочка'){
          sex = 'venus';
        }else{
          sex = 'genderless';
        }
        var pb = 'url(/img/world/items/little/'+info.ball+'.png)';
        var namePok = '#'+num+' '+info['name']+'';
      }else{
        sex = '';
        var pb = '';
        var namePok = info['name'];
      }
      element.find('div.__ball').css('background-image', pb);
      element.find('div.__item').css('background-image', 'url(/img/world/items/little/'+info.item+'.png)');
      element.find('div.__item').attr('onclick', 'issetAll('+info.item+',"item")');
      element.find('div.Modif').attr('style', 'background-image: url(/img/tren/'+info.tren+'.png);');
      element.find('div._modif_enemy').attr('style', 'background-image: url(/img/tren/'+info.tren+'.png); right: -8px; left: unset;');
      element.find('div.__unik').html(typePok);
      element.find('div.__unik').addClass(info['type']+'-color');
			element.find('.imgPok').removeClass('blank').attr('src', info.sprite);
      element.find('.imgPok').attr('onclick', 'openDex('+info.basenum2+')');
			element.find('.Classific').addClass('pow'+info['tren']);
			element.find('.ClassificEnemy').addClass('pow'+info['tren']);
      element.find('div.__lvl').html((info['lvl'] || '0'));
			element.find('div.__name').html('<div class="Text">'+namePok+'</div><div class="Sex"><i class="fas fa-'+sex+'"></i></div>');
      element.find('div.__name').addClass(info['type']+'-color');
            element.find('div.__hp').html(info['hp']+' / '+info['hp_max']);
            element.find('div.__hpW').width(Math.floor(((info['hp']/info['hp_max']) * 100))+'%');

            if(info['exp']){
                element.find('div.__exp').html(info['exp']['val']+' / '+info['exp']['next']);
                element.find('div.__expW').width(Math.floor(((info['exp']['val']/info['exp']['next']) * 100))+'%');
            }else{
                element.find('div.__exp').html('0 / 0');
            }


            if(my){
                if(_element_poke_info_my_move){
                    if(info['atkList']){
                        tpl = [];
                        var pp_atk = info['pp_my'].split(',');
                        $.each(info['atkList'], function(key, val){
                          var atkc;
                          if(val['category'] == 'physical') {
                            atkc = 1;
                          }else if(val['category'] == 'special') {
                            atkc = 2;
                          }else{
                            atkc = 3;
                          }
                            tpl.push(
                                $('<div />', {
                                    'class':'Move'
                                }).append(
                                    '<img src="/img/world/typs/'+(val['type'] || 'empty')+'.png">',
                                    ' <div class="MoveInfo"><div class="Name MoveCategory'+atkc+'">'+val['name']+'</div><div class="PP">'+pp_atk[val['attack_num']]+'/'+val['pp']+' pp</div></div>'
                                ).on('click', function(){
                                  if(val['target'] == 'ban') {
                                    alert('Атака не работает.');
                                  }else{
                                    if(val['id'] == 235) {
                                      _self._aHH((_data['myTeam'] || null));
                                    }else{
                                      $('.MoveBox').html('<center><img src="/img/loader/loader.gif" width="100"></center>');
                    									_self._action({
                                                            'targetAtk':val['id']
                                                        });
                                    }
                                  }

                                })
                            )
                        });

                        if(tpl.length){
                            _element_poke_info_my_move.empty().append(tpl);
                        }else{
                            _element_poke_info_my_move.empty();
                        }
                    }else{
                        _element_poke_info_my_move.empty();
                    }
                }
            }
			if(info['LogBattle']){
				$('#battleMap .Battle .Content .Log').html('<div class="Wrap">'+info['LogBattle']+'</div>');
			}
			if(info['BallsPoke']){
				_element_enemy_ball.html(info['BallsPoke']);
			}
            if(info['statMod']){
                tpl = [];
                $.each(info['statMod'], function(key, val){
                    var names,
                        cnt;
                    if(key == 'atk') {
                      names = 'Атака';
                    }else if(key == 'def'){
                      names = 'Защита';
                    }else if(key == 'spd'){
                      names = 'Скорость';
                    }else if(key == 'satk'){
                      names = 'Спец. Атака';
                    }else if(key == 'sdef'){
                      names = 'Спец. Защита';
                    }else if(key == 'acr'){
                      names = 'Точность';
                    }else if(key == 'agl'){
                      names = 'Ловкость';
                    }else{
                      names = '...';
                    }
                    if(val['plus']) {
                      cnt = 'Plus';
                    }else if(val['minus']){
                      cnt = 'Minus';
                    }else{
                      cnt = '';
                    }
                    tpl.push(
                        $('<div />', {
                            'class':'Status Status'+cnt
                        }).append(
                            (val['plus'] ? '<div class="StatusNum">'+names+' +'+val['plus']+'</div>' : ''),
                            (val['minus'] ? '<div class="StatusNum minus">'+names+' -'+val['minus']+'</div>' : '')
                        )
                    );
                });
				if(my){
					_element_poke_info_my_stat.empty().append(tpl);
				}else{
					_element_poke_info_enemy_stat.empty().append(tpl);
				}
            }else{
                _element_poke_info_my_stat.empty();
                _element_poke_info_enemy_stat.empty();
            }
			if(info['statusList']){
                tpl = [];
                $.each(info['statusList'], function(){
                    var names;
                    if(this.type == 'burn') {
                      names = 'Подожжен';
                    }else if(this.type == 'toxic'){
                      names = 'Отравлен';
                    }else if(this.type == 'nightmare'){
                      names = 'Кошмары';
                    }else if(this.type == 'toxic2'){
                      names = 'Сильно отравлен';
                    }else if(this.type == 'flinch'){
                      names = 'Напуган';
                    }else if(this.type == 'paralyzed'){
                      names = 'Парализован';
                    }else if(this.type == 'sleep'){
                      names = 'Спит';
                    }else if(this.type == 'frost'){
                      names = 'Заморожен';
                    }else if(this.type == 'lover'){
                      names = 'Влюблен';
                    }else if(this.type == 'curse'){
                      names = 'Проклят';
                    }else if(this.type == 'confused'){
                      names = 'Спутан';
                    }else if(this.type == 'rage'){
                      names = 'В бешенстве';
                    }else if(this.type == 'taunt'){
                      names = 'Насмешка';
                    }else if(this.type == 'aquaRing'){
                      names = 'Водяной щит';
                    }else if(this.type == 'stock'){
                      names = 'Накопление';
                    }else{
                      names = '...';
                    }
                    tpl.push(
                        $('<div />', {
                            'class':'Status Status'+this.type
                        }).append(
                            names
                        )
                    );
                    //  tpl.push( статусы img графика
                    //     $('<div />', {
                    //         'class':'Statusimg Statusimg'+this.type
                    //     }).append(
                    //         names
                    //     )
                    // );
                });
				if(my){
					_element_poke_info_my_stat_a.empty().append(tpl);
				}else{
					_element_poke_info_enemy_stat_a.empty().append(tpl);
				}
            }
        }
    };

    this._viewName = function(info){
        return $('<div />', {
            'class': (info['id'] > 0 ? 'user-link u-'+info['group'] : 'wild '+(info['catch'] ? '' : 'red')),
            'html': (info['id'] > 0 ? info['login'] : 'Дикий покемон')
        });
    };

    this._imgPoke = function(pokeInfo, mini){
        var num = (pokeInfo['basenum'] || 0);
        num = (num < 10 ? '00'+num : num < 100 ? '0'+num : num);
        return '/img/pokemons/mini/'+pokeInfo['type']+'/'+num+'.png';
    };

    if(info){
        _self._open(info);
    }
};
var i = {
    "stats":[
        ["sdef", 1, "minus", 50]
    ]
};
/*
var i = {
    "status":[
        ["chance", "name", "count", "val"]
    ]
};

/*
*/
