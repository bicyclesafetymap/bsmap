var currentWindow = null;
var map;

function createMap(data) {
    $("#"+data[4]).css('height', data[6]);

    var myLatlng = new google.maps.LatLng(data[2],data[3]);

    //Google Roadmap Maps のスタイル指定
    var styles = [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-100},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}];

    var mapOptions = {
      zoom : 18,
      center : myLatlng,
      styles: styles,
      mapTypeControl: false,
      scrollwheel: false,
      panControl: false,
      streetViewControl: false,
      disableDoubleClickZoom: false,
      zoomControl: false,
      draggable: false
    };
    var name = '<strong>'+data[0]+'</strong><br>'+data[1];
    var latlng = new google.maps.LatLng(data[2],data[3]);
    var icons = {
        url : '/cmn/img/report/pic_mappin.png'
    }
    map = new google.maps.Map(document.getElementById(data[4]), mapOptions);

    var simpleMapStyle;

    createMarker(name,latlng,icons,map);
}

function createMarker(name,latlng,icons,map){
    var infoWindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        position: latlng,
        icon:icons,
        map: map,
        // animation : google.maps.Animation.DROP,
        draggable: false
    });
}

//ポップアップウィンドウのストップ
(function fixInfoWindow() {
  var set = google.maps.InfoWindow.prototype.set;
  google.maps.InfoWindow.prototype.set = function(key, val) {
    if (key === "map") {
      if (! this.get("noSuppress")) {
        return;
      }
    }
    set.apply(this, arguments);
  }
})();


// 画面のレンダリング
$(function() {
    createMap(['', '', post_latitude, post_longitude, 'changeMap', '600', '250']);
});


// 画面遷移の制御
function formSubmit(target) {
    event.preventDefault();

    var form = $("#inputform");

    // 送信先の変更
    form.attr('action', target);

    // 送信
    form.submit();
}
