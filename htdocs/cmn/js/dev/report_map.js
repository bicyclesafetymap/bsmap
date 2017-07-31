var currentWindow = null;
var map;

function createMap(data) {
    $("#"+data[4]).css('height', data[6]);

    var myLatlng = new google.maps.LatLng(data[2],data[3]);

    //Google Roadmap Maps のスタイル指定
    var styles = [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-100},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}];

    var mapOptions = {
      zoom : 16,
      center : myLatlng,
      styles: styles,
      mapTypeControl: false,
      scrollwheel: false,
      panControl: false,
      streetViewControl: false,
      disableDoubleClickZoom: false,
      zoomControl: false,
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

function createMarker(name,latlng,icons,map){
    var infoWindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        position: latlng,
        icon:icons,
        map: map,
        animation : google.maps.Animation.DROP,
        draggable: true
    });

    //ドラッグ時、緯度・経度の取得
    google.maps.event.addListener( marker, 'dragend', function(ev){
      $("#latitude").val(ev.latLng.lat());
      $("#longitude").val(ev.latLng.lng());
    });
}

// 地図の表示を開始
function start_func(){
    $('#changeMap').text('位置情報取得しています。');
    if (navigator.geolocation) {
        // 現在の位置情報取得を実施 正常に位置情報が取得できると、
        // successCallbackがコールバックされます。
        navigator.geolocation.getCurrentPosition(successCallback,errorCallback);
    }
}

function successCallback(pos) {
    // 緯度
    if (typeof post_latitude === "undefined") {
        Potition_lat = pos.coords.latitude;
    } else {
        Potition_lat = post_latitude;
    }

    // 経度
    if (typeof post_longitude === "undefined") {
        Potition_lng = pos.coords.longitude;
    } else {
        Potition_lng = post_longitude;
    }

    // 位置情報が取得出来たらGoogle Mapを表示する
    mapRender(Potition_lat,Potition_lng);
}

function errorCallback(error){
    $('#changeMap').text('位置情報取得します');
}

function mapRender(lat,long,inputChange){
    createMap(['','',lat,long,'changeMap','600','350']);

    if (typeof inputChange !== "undefined" && inputChange === true) {
        return;
    }

    $("#latitude").val(lat);
    $("#longitude").val(long);
}

$(function(){
    var Address_Box = $(".areaInputBox");
    var html = $("html");

    start_func();

    //現在地取得ボタン
    $("#js-position").on('click', function() {
      mapRender(Potition_lat,Potition_lng,true);
    });

    $("#js-address").on('click', function() {
        html.addClass('bodyNoScloll');
        Address_Box.show();

        $("#js-address-close").on('click', function() {
            html.removeClass('bodyNoScloll');
            Address_Box.hide();
        });
    });


  $("#js-pin-btn").on('click', function(event) {
      var address = $("#addressForm").val();
      getLatLng(address);
  })

  function getLatLng(place){
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({
      address: place
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        // 結果の表示範囲。結果が１つとは限らないので、LatLngBoundsで用意。
        var bounds = new google.maps.LatLngBounds();
        var latlng;

        for (var i in results) {
          if (results[i].geometry) {
            // 緯度経度を取得
            latlng = results[i].geometry.location;
          }
        }

        var address_lat = latlng.lat();
        var address_lng = latlng.lng();

        mapRender(address_lat,address_lng);

        html.removeClass('bodyNoScloll');
        Address_Box.hide();
      } else {
        // alert("Geocode 取得に失敗しました reason: " + status);
        $("#js-area-error").show();
      }

    });
  }
});
