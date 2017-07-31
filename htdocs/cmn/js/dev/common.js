// Device Change
var _getDevice = (function(){
    var _ua = navigator.userAgent;
    if(_ua.indexOf('iPhone') > 0 || _ua.indexOf('iPod') > 0 || _ua.indexOf('Android') > 0 && _ua.indexOf('Mobile') > 0){
        return 'mobile';
    }else if(_ua.indexOf('iPad') > 0 || _ua.indexOf('Android') > 0){
        return 'tablet';
    }else if(_ua.indexOf('Win') > 0 || _ua.indexOf('Mac') > 0){
        return 'pc';
    }else{
        return 'other';
    }
})();// End


var screenH = $(window).height();

// console.log(screenH);

$(function() {
// console.log(screenH);

    var gnavItems = $("#js-gnav");
    var html      = $("html");
    var menuBtn   = $("#js-menuBtn");
    var closeBtn  = $(".js-close");
    var btnHight  = $(".mapBtn").height();

    //レイヤー切り替えボタン位置設定
    if(_getDevice == "mobile"){
      $(".changeBtn").css('bottom', 54);
    }
    else {
      $(".changeBtn").css('bottom', 67);
    }
    // $(".changeBtn").css('bottom', btnHight);
    // $(".changeBtn").css('bottom', 238);

    //画面の高さ追加
    $(".layerBg").css('height', screenH+'px');
    $(".gnavMenuContainer").css('height', screenH+'px');
    $(".gnavMenuContainer_over").css('height', screenH+'px');
    gnavItems.css('height', screenH+'px');

    //メニューボタンクリック時
    menuBtn.on('click', function() {
        $(this).addClass('is-open');
        html.addClass('bodyNoScloll');
        gnavItems.addClass('is-open');

        $(".layerBg").on('click', function() {
            menuBtn.removeClass('is-open');
            html.removeClass('bodyNoScloll');
            gnavItems.removeClass('is-open');
        });
    });

    //クローズボタン動作
    closeBtn.on('click', function() {
        html.removeClass('bodyNoScloll');
        gnavItems.removeClass('is-open');
        menuBtn.removeClass('is-open');
    });

    //画面の高さ追加
    // $(".listContainer").css('height', screenH - btnHight + 'px');
    // $(".listContainer_over").css('height', screenH - btnHight + 'px');
    // $(".listContainer").css('height', 300 );

    $(".listContainer").css({
      // 'height': screenH / 2.5,
      'height': screenH * .4,
      'bottom': btnHight
    });

    if(_getDevice == "mobile"){
      // $(".changeBtn").css('bottom', 54);
      $(".listContainer").css({
        // 'height': screenH / 2.5,
        'height': screenH * .4,
        'bottom': 54
      });
    }
    else {
      // $(".changeBtn").css('bottom', 67);
      $(".listContainer").css({
        // 'height': screenH / 2.5,
        'height': screenH * .4,
        'bottom': 67
      });
    }

    // $(".listContainer_over").css('height', screenH / 2.5 );
    $(".listContainer_over").css('height', screenH * .4);

    $(".js-mapBtn .mapBtn_item").on('click', function() {
        var count = $(".js-mapBtn .mapBtn_item").index(this);

        $(".js-mapBtn .mapBtn_item").removeClass('active');
        $(this).addClass('active');
        if(count === 1){

            // $.cookie("test", "VALUE", { expires: 7 });

            $(".listContainer").show();
        } else {

            // $.removeCookie("test");
            // console.log("a");

            $(".listContainer").hide();
        }
    });

});


//Layer切り替え
$(function() {
    var html       = $("html");
    var btn        = $("#js-layerBtn");
    var layerItems = $(".layerContainer");
    var layerOver  = $(".layerContainer_over");
    var layerBg    = $(".layerContainer .layerBg");
    var closeBtn   = $(".layerContainer .js-close");

    layerOver.css('height', screenH+'px');
    layerItems.css('height', screenH+'px');

    btn.on('click', function() {
        html.addClass('bodyNoScloll');
        layerItems.addClass('is-open');

        layerBg.on('click', function() {
            html.removeClass('bodyNoScloll');
            layerItems.removeClass('is-open');
        });

    });

    closeBtn.on('click', function() {
        html.removeClass('bodyNoScloll');
        layerItems.removeClass('is-open');
    });
});

//area切り替え
$(function() {
    var html       = $("html");
    var btn        = $("#js-positionBtn");
    var areaItems = $(".areaContainer");
    var areaOver  = $(".areaContainer_over");
    var layerBg    = $(".areaContainer .layerBg");
    var closeBtn   = $(".areaContainer .js-close");

    areaOver.css('height', screenH+'px');
    areaItems.css('height', screenH+'px');

    btn.on('click', function() {
        html.addClass('bodyNoScloll');
        areaItems.addClass('is-open');

        layerBg.on('click', function() {
            html.removeClass('bodyNoScloll');
            areaItems.removeClass('is-open');
        });

    });

    closeBtn.on('click', function() {
        html.removeClass('bodyNoScloll');
        areaItems.removeClass('is-open');
    });
});


$(function() {
    pageScloll(".js-pagescloll");
});

//page top
function pageScloll(obj){
    var topBtn = $(obj);
    topBtn.on('click', 'a', function() {
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $('body,html').animate({scrollTop:position}, 400);
        return false;
    });
}// End

$(function() {
  var topBtn = $(".js-pagetop");
  topBtn.hide();

  $(window).scroll(function () {
      if ($(this).scrollTop() > 300) {
          topBtn.fadeIn();
      } else {
          topBtn.fadeOut();
      }
  });
  //スクロールしてトップ
  topBtn.click(function () {
      $('body,html').animate({
          scrollTop: 0
      }, 500);
      return false;
  });






});




/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD (Register as an anonymous module)
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(jQuery);
  }
}(function ($) {

  var pluses = /\+/g;

  function encode(s) {
    return config.raw ? s : encodeURIComponent(s);
  }

  function decode(s) {
    return config.raw ? s : decodeURIComponent(s);
  }

  function stringifyCookieValue(value) {
    return encode(config.json ? JSON.stringify(value) : String(value));
  }

  function parseCookieValue(s) {
    if (s.indexOf('"') === 0) {
      // This is a quoted cookie as according to RFC2068, unescape...
      s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
    }

    try {
      // Replace server-side written pluses with spaces.
      // If we can't decode the cookie, ignore it, it's unusable.
      // If we can't parse the cookie, ignore it, it's unusable.
      s = decodeURIComponent(s.replace(pluses, ' '));
      return config.json ? JSON.parse(s) : s;
    } catch(e) {}
  }

  function read(s, converter) {
    var value = config.raw ? s : parseCookieValue(s);
    return $.isFunction(converter) ? converter(value) : value;
  }

  var config = $.cookie = function (key, value, options) {

    // Write

    if (arguments.length > 1 && !$.isFunction(value)) {
      options = $.extend({}, config.defaults, options);

      if (typeof options.expires === 'number') {
        var days = options.expires, t = options.expires = new Date();
        t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
      }

      return (document.cookie = [
        encode(key), '=', stringifyCookieValue(value),
        options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
        options.path    ? '; path=' + options.path : '',
        options.domain  ? '; domain=' + options.domain : '',
        options.secure  ? '; secure' : ''
      ].join(''));
    }

    // Read

    var result = key ? undefined : {},
      // To prevent the for loop in the first place assign an empty array
      // in case there are no cookies at all. Also prevents odd result when
      // calling $.cookie().
      cookies = document.cookie ? document.cookie.split('; ') : [],
      i = 0,
      l = cookies.length;

    for (; i < l; i++) {
      var parts = cookies[i].split('='),
        name = decode(parts.shift()),
        cookie = parts.join('=');

      if (key === name) {
        // If second argument (value) is a function it's a converter...
        result = read(cookie, value);
        break;
      }

      // Prevent storing a cookie that we couldn't decode.
      if (!key && (cookie = read(cookie)) !== undefined) {
        result[name] = cookie;
      }
    }

    return result;
  };

  config.defaults = {};

  $.removeCookie = function (key, options) {
    // Must not alter options, thus extending a fresh object...
    $.cookie(key, '', $.extend({}, options, { expires: -1 }));
    return !$.cookie(key);
  };

}));

