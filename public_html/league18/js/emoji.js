var emoji = {
  ':squirtle:': 'em-squirtle',
  ':charm:': 'em-charm',
  ':wabaffet:': 'em-wabaffet',
  ':gengar:': 'em-gengar',
  ':psy:': 'em-psy',
  ':slow:': 'em-slow',
  ':vulp:': 'em-vulp',
  ':pika:': 'em-pika',
  ':snorl:': 'em-snorl',
  ':lol:': 'em-lol',
  ':blessrng:': 'em-blessrng',
  ':bob:': 'em-bob',
  ':babyrage:': 'em-babyrage',
  ':residentsleeper:': 'em-residentsleeper',
  ':pogchamp:': 'em-pogchamp',
  ':takenrg:': 'em-takenrg',
  ':dansgame:': 'em-dansgame',
  ':brokeback:': 'em-brokeback',
  ':bibletump:': 'em-bibletump',
  ':kappa:': 'em-kappa',
  ':elehm:': 'em-elehm',
  ':gotit:': 'em-gotit',
  ':kiss:': 'em-kiss',
  ':ok:': 'em-ok',
  ':hello:': 'em-pikahello',
  ':omg:': 'em-omg'
};

function replaceEmoji(text){
    $.each(emoji, function(key, value){
        if (typeof emoji[key] !== "undefined") {
            text = text.replace(new RegExp(key,'g'), '<i class="em '+value+'"></i>');
        } else {
            return text;
        }
    });
    return text;
}

function showEmoji(){
    var tpl = [];
    $.each(emoji, function( key, value ) {
        tpl.push('<div class="emoji" title="'+key+'" data-emoji="'+key+'"><i class="em '+value+'"></i></div>');
    });
    return tpl;
}
