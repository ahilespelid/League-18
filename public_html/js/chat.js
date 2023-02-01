var Chat = function(){
    var _self = this,
        _last_id = 0,
        _timeout_id = 0,
        _time_refresh = 4000;

    this._send = function(){
        var user_to = $('#chat_user_to'),
            send = $('#chat_send'),
			channel = $('#gameChatBox .active').attr('data-channel');

        if(user_to.length && send.length){
            if(send.val().length < 1){
                $.notify('Для отправки сообщения нужен хотя бы 1 символ.');
                return;
            }
            if(send.val().length > 2000){
                $.notify('Для отправки сообщения привышен лимит в 2000 символов.');
                return;
            }

            if(_timeout_id){
                clearTimeout(_timeout_id);
            }

            $.ajax({
                url: "/do/chat",
                type: "POST",
                data: {
                    'chat': true,
                    'send': send.val(),
                    'to_user': (user_to.val().length > 1 ? user_to.val() : null),
					'channel': channel
                },
                complete: function(){
                    send.val('');
                    _self._refresh();
                },
                success: function (response) {
                    if(response){
                        response = JSON.parse(response);
                        if(response['error'] == 1){
                            $.notify(response['text'], 'error');
                        }else{
                            _self._response(response);
                        }
                    }
                }
            });

        }else{
            $.notify('Не могу найти данные форм...');
        }

        return false;
    };

    this._read = function(){
        $.ajax({
            url: "/do/chat",
            type: "POST",
            data: {
                'chat': true,
                'read': true
            },
            complete: function(){
                _self._refresh();
            },
            success: function (response) {
                if(response){
                    response = JSON.parse(response);
                    if(response['error'] == 1){
                        $.notify(response['text'], 'error');
                    }else{
                        _self._response(response);
                    }
                }
            }
        });
    };

    this._parse_sends = function(data, user_id){
        if(data){
            var append = [];
			var channel;
			console.log(data);
            $.each(data, function(key, val){
                key = key.split('_');
                if(val && key[1] && key[1] > 0 && key[1] > _last_id){
                    val = JSON.parse(val);
					if(val['msg_type'] == 3){
						return updateLocation();
					}
                    if(val['msg_time']){
						channel = val['user_channel'];
                        append.push(
                            '<div class="message '+((user_id == val['user_id'] || (val['userto_id'] && val['userto_id'] == user_id)) ? 'me' : '')+(val['msg_type'] == 30 ? ' private' : '' )+'"><div class="time">['+val['msg_time']+']</div>' +
                            '<div class="name"><div class="user-link u-'+val['user_group']+'">'+val['user_login']+'</div>' +
                            (val['userto_id'] ? ' » <div class="user-link u-'+val['userto_group']+'">'+val['userto_login']+'</div>' : '')+
                            ':</div><span class="text '+val['msg_class']+'">'+val['user_msg']+'</span></div>'
                        );
                    }
                    _last_id = key[1];
                }
            });

            if(append.length){
                var element = $('.Channel'+channel);
                element.append(append);
                element.animate({'scrollTop': element[0].scrollHeight}, 300);

                element.find('.user-link')
                    .off('.click-right')
                    .on('contextmenu.click-right', function(e){
                        $('#chat_user_to').val($(this).text());
                        $(document).trigger('mouseup');
                        e.stopImmediatePropagation();
                        e.stopPropagation();
                        return false;
                    })
            }
        }
    };

    this._response = function(data){
        if(data){
            if(data['SEND_LIST']){
                _last_id = _self._parse_sends(data['SEND_LIST'], (data['MY_ID'] || 0));
            }
            if(data['LAST_SEND']){
                _last_id = parseInt(data['LAST_SEND']);
            }
        }
    }; 

    this._refresh = function(clear){
        if(_timeout_id){
            clearTimeout(_timeout_id);
        }
        if(!clear){
            _timeout_id = setTimeout(function(){
                _self._read();
            }, _time_refresh);
        }
    };
};

var WorldChat = new Chat();

$(function(){
    WorldChat._read();
});
