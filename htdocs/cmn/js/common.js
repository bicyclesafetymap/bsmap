function pageScloll(e){var n=$(e);n.on("click","a",function(){var e=$(this).attr("href"),n=$("#"==e||""==e?"html":e),o=n.offset().top;return $("body,html").animate({scrollTop:o},400),!1})}var _getDevice=function(){var e=navigator.userAgent;return e.indexOf("iPhone")>0||e.indexOf("iPod")>0||e.indexOf("Android")>0&&e.indexOf("Mobile")>0?"mobile":e.indexOf("iPad")>0||e.indexOf("Android")>0?"tablet":e.indexOf("Win")>0||e.indexOf("Mac")>0?"pc":"other"}(),screenH=$(window).height();$(function(){var e=$("#js-gnav"),n=$("html"),o=$("#js-menuBtn"),i=$(".js-close"),t=$(".mapBtn").height();"mobile"==_getDevice?$(".changeBtn").css("bottom",54):$(".changeBtn").css("bottom",67),$(".layerBg").css("height",screenH+"px"),$(".gnavMenuContainer").css("height",screenH+"px"),$(".gnavMenuContainer_over").css("height",screenH+"px"),e.css("height",screenH+"px"),o.on("click",function(){$(this).addClass("is-open"),n.addClass("bodyNoScloll"),e.addClass("is-open"),$(".layerBg").on("click",function(){o.removeClass("is-open"),n.removeClass("bodyNoScloll"),e.removeClass("is-open")})}),i.on("click",function(){n.removeClass("bodyNoScloll"),e.removeClass("is-open"),o.removeClass("is-open")}),$(".listContainer").css({height:.4*screenH,bottom:t}),"mobile"==_getDevice?$(".listContainer").css({height:.4*screenH,bottom:54}):$(".listContainer").css({height:.4*screenH,bottom:67}),$(".listContainer_over").css("height",.4*screenH),$(".js-mapBtn .mapBtn_item").on("click",function(){var e=$(".js-mapBtn .mapBtn_item").index(this);$(".js-mapBtn .mapBtn_item").removeClass("active"),$(this).addClass("active"),1===e?$(".listContainer").show():$(".listContainer").hide()})}),$(function(){var e=$("html"),n=$("#js-layerBtn"),o=$(".layerContainer"),i=$(".layerContainer_over"),t=$(".layerContainer .layerBg"),s=$(".layerContainer .js-close");i.css("height",screenH+"px"),o.css("height",screenH+"px"),n.on("click",function(){e.addClass("bodyNoScloll"),o.addClass("is-open"),t.on("click",function(){e.removeClass("bodyNoScloll"),o.removeClass("is-open")})}),s.on("click",function(){e.removeClass("bodyNoScloll"),o.removeClass("is-open")})}),$(function(){var e=$("html"),n=$("#js-positionBtn"),o=$(".areaContainer"),i=$(".areaContainer_over"),t=$(".areaContainer .layerBg"),s=$(".areaContainer .js-close");i.css("height",screenH+"px"),o.css("height",screenH+"px"),n.on("click",function(){e.addClass("bodyNoScloll"),o.addClass("is-open"),t.on("click",function(){e.removeClass("bodyNoScloll"),o.removeClass("is-open")})}),s.on("click",function(){e.removeClass("bodyNoScloll"),o.removeClass("is-open")})}),$(function(){pageScloll(".js-pagescloll")}),$(function(){var e=$(".js-pagetop");e.hide(),$(window).scroll(function(){$(this).scrollTop()>300?e.fadeIn():e.fadeOut()}),e.click(function(){return $("body,html").animate({scrollTop:0},500),!1})}),function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){function n(e){return c.raw?e:encodeURIComponent(e)}function o(e){return c.raw?e:decodeURIComponent(e)}function i(e){return n(c.json?JSON.stringify(e):String(e))}function t(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(r," ")),c.json?JSON.parse(e):e}catch(n){}}function s(n,o){var i=c.raw?n:t(n);return e.isFunction(o)?o(i):i}var r=/\+/g,c=e.cookie=function(t,r,a){if(arguments.length>1&&!e.isFunction(r)){if(a=e.extend({},c.defaults,a),"number"==typeof a.expires){var l=a.expires,d=a.expires=new Date;d.setMilliseconds(d.getMilliseconds()+864e5*l)}return document.cookie=[n(t),"=",i(r),a.expires?"; expires="+a.expires.toUTCString():"",a.path?"; path="+a.path:"",a.domain?"; domain="+a.domain:"",a.secure?"; secure":""].join("")}for(var p=t?void 0:{},u=document.cookie?document.cookie.split("; "):[],f=0,m=u.length;f<m;f++){var h=u[f].split("="),$=o(h.shift()),v=h.join("=");if(t===$){p=s(v,r);break}t||void 0===(v=s(v))||(p[$]=v)}return p};c.defaults={},e.removeCookie=function(n,o){return e.cookie(n,"",e.extend({},o,{expires:-1})),!e.cookie(n)}});