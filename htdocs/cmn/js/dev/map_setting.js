var btnHight = $(".mapBtn").height();
if(_getDevice == "mobile"){
  $("#map").css('height', screenH - 54 + 'px');
  // $(".changeBtn").css('bottom', 54);
}
else {
  $("#map").css('height', screenH - 67 + 'px');
  // $(".changeBtn").css('bottom', 67);
}
// $("#map").css('height', screenH - btnHight + 'px');


// Map初期設定
var homeLatLng = [35.681382, 139.766084];
var homeZoomLev = 10;

var map = L.map('map', {
  center: homeLatLng,
  zoom: homeZoomLev,
  zoomControl: true
});

// URL 取得
var baseurl = window.location.href;


// ハッシュに対応
var hash = L.hash(map);

// geolocatを使用しているか確認
var geolocatCheck = false;

// ====== マップタイル設定 ======

// オープンストリートマップ
var osm = L.tileLayer('http://tile.openstreetmap.jp/{z}/{x}/{y}.png', {
  attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a>',
  maxZoom: 19,
  minZoom: 3
});

// 地理院地図の標準地図レイヤ
var cjstd = L.tileLayer('http://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
  attribution: '&copy; <a target="_blank" href="http://portal.cyberjapan.jp/help/termsofuse.html" target="_blank">国土地理院</a>',
  maxZoom: 18,
  minZoom: 3
});

// 地理院地図のオルソ画像レイヤ
var cjort = L.tileLayer('http://cyberjapandata.gsi.go.jp/xyz/ort/{z}/{x}/{y}.jpg', {
  attribution: '&copy; <a target="_blank" href="http://portal.cyberjapan.jp/help/termsofuse.html" target="_blank">国土地理院</a>',
  maxZoom: 18,
  minZoom: 6
});

// Google Map Satellite
var ggl = new L.Google('SATELLITE', {
  maxZoom: 21,
  minZoom: 3
});

//Google Roadmap Maps のスタイル指定
var styles = [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-100},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}];

// Google Map Roadmap
var ggl2 = new L.Google('ROADMAP', {
  maxZoom: 21,
  mapOptions: {
    styles: styles
  },
  minZoom: 3
});
// Google Map Terrain
var ggl3 = new L.Google('TERRAIN', {
  maxZoom: 21,
  minZoom: 3
});
// Google Map Hybrid
var ggl4 = new L.Google('HYBRID', {
  maxZoom: 21,
  minZoom: 3
});

// 最初の読み込み時のみ現在地へ移動
if (baseurl.match(/map\/$/) !== null) {
  geolocat_Move(16);
}

// 初期表示マップ
map.addLayer(ggl2);

// var markers = L.markerClusterGroup();
var markers1 = L.markerClusterGroup({
  maxClusterRadius: 25,
  showCoverageOnHover: false
});

/* ========== Fetch Version (https://github.com/github/fetch) ========== */
// fetch('https://bauhaus-web.jp/map/json/maker-388.json')
/*
fetch('/cmn/map/json/maker-388.json')
.then(function(response) {
  return response.json();
}).then(function(json) {
// console.log('parsed json', json)
// console.log(json.addressPoints[1].id)
$.each(json.addressPoints, function(i){
// for(var i = 0; i < json.addressPoints.length; i++) {
  var d = json.addressPoints[i];

  var marker = L.marker(new L.LatLng(d.lat, d.lng), { title: d.id, test: d.text, pin: d.pin, date: d.date, name: d.title, detail: d.detail, thumb: d.thumb  });

  marker.bindPopup("<strong>" + d.title + "</strong>" + "<br>" + d.text + "<br>" + "ID = " + d.id);
  markers.addLayer(marker);
});
// };

}).catch(function(ex) {
  console.log('parsing failed', ex);
});
map.addLayer(markers);
*/


map.addLayer(markers1);

// アイコン初期設定
var baseIconSetting = L.Icon.extend({
  options: {
    // shadowUrl: 'http://leafletjs.com/docs/images/leaf-shadow.png',
    iconSize: [38, 95],
    shadowSize: [50, 64],
    iconAnchor: [22, 94],
    shadowAnchor: [4, 62],
    popupAnchor: [-3, -76]
  }
});

// Geojson Version
// fetch('//api.dev.bicyclesafetymap.jp/json/map.geojson')
// fetch('/api/demomaps.json')
fetch('/api/mapsgeodata.json')
  .then(function(response) {
    return response.json();
  }).then(function(json) {

    // GeoJsonからマーカー生成
    var geoMarker = L.geoJson(json, {
      // 個別アイコン設定
      pointToLayer: function(feature, latlng) {
        var iconStyle = new baseIconSetting({
          iconUrl: "/" + feature.properties.icon.iconUrl
        });
        return L.marker(latlng, {
          icon: iconStyle
        });
      },
      // 個別ポップアップ設定
      onEachFeature: onEachFeaturePopup
    });

    markers1.addLayer(geoMarker);

  }).catch(function(ex) {
    console.log('parsing failed', ex);
  });

// ポップアップ each処理
function onEachFeaturePopup(feature, layer) {
  if (feature.properties && feature.properties.title) {
    // layer.bindPopup('a<br>'+feature.properties.title);
    // layer.bindPopup("2014.11.12.10:00<br>自動車と出会い頭衝突<br>pic_01.jpg<br>詳細" + feature.properties.icon.iconUrl);
    layer.bindPopup("<div class='mapPopUp'>\
<div class='mapPopUp_day'>" + feature.properties.time + "</div>\
<div class='mapPopUp_inner'>\
<div class='mapPopUp_pic' style='background-image: url(/" + feature.properties.thumb + ")'>\
</div>\
<div class='mapPopUp_text'>" + feature.properties.title + "</div>\
</div>\
<div class='mapPopUp_more'><a href='/" + feature.properties.detail + "'>詳細</a></div></div>\
");
  }
}



/* ========== マーカーリスト生成 ========== */

// マーカーリスト生成関数
function make_Maker_List() {

  // 空のリストを作成
  var inBounds = [],

    // 地図の境界を取得 左上と右下
    bounds = map.getBounds();

  // 地図の境界と比較し、現在表示されているかどうかを取得
  markers1.eachLayer(function(marker) {

    if (bounds.contains(marker.getLatLng())) {
      var lat = marker.getLatLng().lat;
      var lng = marker.getLatLng().lng;
      var latlng = [lat, lng];
      inBounds.push("\
<li>\
<a href='/" + marker.feature.properties.detail + "' class='listContainerMain_item' data-zoom='19' data-position='" + latlng + "'>\
<div class='listContainerMain_icon'>\
<img src='/" + marker.feature.properties.icon.iconUrl + "'></div>\
<div class='listContainerMain_data'>\
<div class='listContainerMain_data-day'>" + marker.feature.properties.time + "</div>\
<div class='listContainerMain_data-title'>" + marker.feature.properties.title + "</div>\
<div class='listContainerMain_data-info'>\
<span>" + marker.feature.properties.area + "<br>" + marker.feature.properties.tag + "</span>\
</div>\
<div class='listContainerMain_data-pic' style='background-image: url(/" + marker.feature.properties.thumb + ");'></div>\
</div>\
</a>\
</li>");
    }
  });

  // 表示エリア内にピンがない場合
  if (inBounds == false) {
    inBounds.push("<div class='listContainerMain_blank'><img src='/cmn/img/common/icon_list_blank.svg' alt='マップの表示エリア内にピンがありません' /></div>");
  };

  // マーカーリストを表示
  document.getElementById('makerList').innerHTML = inBounds.join('\n');
}

// マップが移動が完了したらマーカーリスト生成関数を実行
map.on('moveend', make_Maker_List);

// 初回ロード時にマーカーリスト生成関数を実行
window.onload = function() {
  make_Maker_List();
}


/* ========== マーカーリスト生成 END ========== */

// add layers
// var baseLayers = {
//     "OpenStreetMap": osm,
//     "Google Map Satellite": ggl,
//     "Google Map Roadmap": ggl2,
//     "Google Map Terrain": ggl3,
//     "Google Map Hybrid": ggl4,
//     "地理院地図 標準": cjstd,
//     "地理院地図 オルソ画像": cjort
// };

// SingleOverlays
// var overlays = {
//     "Marker1": markers1,
// };

if (_getDevice == "mobile") {
  var _collapsedSwitch = true
} else {
  var _collapsedSwitch = false
}


// 場所移動
$("#makerList").on('click', function(target) {
  locat_Move(target);
});


// 場所移動関数
function locat_Move(elm) {
  // Usage <a href="#" data-zoom="19" data-position="35.82109227,139.2209316">TEXT</a>
  var pos = elm.target.getAttribute('data-position');
  var zoom = elm.target.getAttribute('data-zoom');
  if (pos && zoom) {
    var locat = pos.split(',');
    var zoo = parseInt(zoom);
    map.setView(locat, zoo, {
      animation: true
    });
    return false;
  }
}

$(".js-area-change a").on('click', function(target) {
  locat_Move(target);

  $(".areaContainer").delay(100).queue(function(next) {
    $(this).removeClass('is-open');
    $("html").removeClass('bodyNoScloll');
    next();
  });

  return false;
});


// レイヤー切り替えラジオボタン
$(".layerSwitchRadio").on('click', function(event) {

  // マップ上の既存のレイヤをループして全て削除
  map.eachLayer(function(layer) {
    map.removeLayer(layer);
  });
  layerClicked = window[event.target.value];
  map.addLayer(layerClicked);

  // マーカーも消えてしまうのでレイヤに追加
  // map.addLayer(markers);
  map.addLayer(markers1);
  console.log(geolocatCheck);

  $(".layerContainer").delay(100).queue(function(next) {
    $(this).removeClass('is-open');
    $("html").removeClass('bodyNoScloll');
    next();
  });

});

// オーバーレイ切り替えチェックボックス
$(".layerSwitchCheckbox").on('click', function(event) {
  layerClicked = window[event.target.value];
  if (map.hasLayer(layerClicked)) {
    map.removeLayer(layerClicked);
  } else {
    map.addLayer(layerClicked);
  };
});

// 現在地を取得して移動
$(".js-geolocat-move a").on('click', function(target) {
  geolocat_Move(16);
  $(".areaContainer").delay(100).queue(function(next) {
    $(this).removeClass('is-open');
    $("html").removeClass('bodyNoScloll');
    next();
  });
  return false;
});





// クリックで円と中心点を生成
  var geolocatCircle01;
  var geolocatCircle02;

// 現在地取得関数
function geolocat_Move(zoom) {

  // ズーム情報が渡されていなかった場合の初期値設定
  var zoom_value = zoom || 17;

  // geolocationに対応している場合
  if (navigator.geolocation) {
    // 現在地を取得
    navigator.geolocation.getCurrentPosition(

      // [第1引数] 取得に成功した場合の関数
      function(position) {
        // 取得したデータの整理
        var data = position.coords;

        // データの整理
        var lat = data.latitude;
        var lng = data.longitude;
        var alt = data.altitude;
        var accLatlng = data.accuracy;
        var accAlt = data.altitudeAccuracy;
        var heading = data.heading; //0=北,90=東,180=南,270=西
        var speed = data.speed;
        var latlng = lat + ", " + lng;

        // アラート表示
        // alert( "あなたの現在位置は、\n[" + lat + "," + lng + "]\nです。" ) ;

        // HTMLへの書き出し
        // document.getElementById( 'result' ).innerHTML = '<dl><dt>緯度</dt><dd>' + lat + '</dd><dt>経度</dt><dd>' + lng + '</dd><dt>高度</dt><dd>' + alt + '</dd><dt>緯度、経度の精度</dt><dd>' + accLatlng + '</dd><dt>高度の精度</dt><dd>' + accAlt + '</dd><dt>方角</dt><dd>' + heading + '</dd><dt>速度</dt><dd>' + speed + '</dd></dl>' ;

        // 現在地に移動
        map.setView([lat, lng], zoom_value, {
          animation: true
        });

    if (geolocatCircle01 != undefined) {
      map.removeLayer(geolocatCircle01);
      map.removeLayer(geolocatCircle02);
    };

        geolocatCircle01 = L.circle([lat, lng], 50,{
           color: '#136AEC',
           fillColor: '#136AEC',
           opacity: .5,
           fillOpacity: .15,
           weight:2
        }).addTo(map);


        geolocatCircle02 = L.circle([lat, lng], 2,{
           color: '#136AEC',
           fillColor: '#136AEC',
           opacity: .9,
           fillOpacity: .7,
           weight:2
        }).addTo(map);

        // geolocatを使用しているか確認
        geolocatCheck = true;
      },

      // [第2引数] 取得に失敗した場合の関数
      function(error) {
        // エラーコード(error.code)の番号
        // 0:UNKNOWN_ERROR              原因不明のエラー
        // 1:PERMISSION_DENIED          利用者が位置情報の取得を許可しなかった
        // 2:POSITION_UNAVAILABLE       電波状況などで位置情報が取得できなかった
        // 3:TIMEOUT                    位置情報の取得に時間がかかり過ぎた…

        // エラー番号に対応したメッセージ
        var errorInfo = [
          "原因不明のエラーが発生しました。",
          "位置情報の取得が許可されませんでした。",
          "電波状況などで位置情報が取得できませんでした。",
          "位置情報の取得に時間がかかり過ぎてタイムアウトしました。"
        ];

        // エラー番号
        var errorNo = error.code;

        // エラーメッセージ
        var errorMessage = "[エラー番号: " + errorNo + "]\n" + errorInfo[errorNo];

        // アラート表示
        alert(errorMessage);

        // HTMLに書き出し
        // document.getElementById("result").innerHTML = errorMessage;
      },

      // [第3引数] オプション
      {
        "enableHighAccuracy": false,
        "timeout": 8000,
        "maximumAge": 2000,
      }

    );
  }

  // 対応していない場合
  else {
    // エラーメッセージ
    var errorMessage = "現在地が取得できませんでした。";

    // アラート表示
    alert(errorMessage);

    // HTMLに書き出し
    // document.getElementById( 'result' ).innerHTML = errorMessage ;
  }
}

// mapコンテナのサイズ可変 Map-Only
$(".js-mapOnly").on('click', function() {
  var vh = window.innerHeight;
  $('.changeBtn').css('display', 'block');
  if(_getDevice == "mobile"){
    $('#map').css('height', vh - 54);
    map.invalidateSize();
  }
  else {
    $('#map').css('height', vh - 67);
    map.invalidateSize();
  }
});

// mapコンテナのサイズ可変 Map-And-List
$(".js-mapAndList").on('click', function() {
  $('.changeBtn').css('display', 'none');
  if(_getDevice == "mobile"){
    $('#map').css('height', screenH * .6 - 54);
    map.invalidateSize();
  }
  else {
    $('#map').css('height', screenH * .6 - 67);
    map.invalidateSize();
  }
});

// setTimeout使ってトランジションに対応したい・・・
// setTimeout(function() {
//   map.invalidateSize();
// }, 500);

// リサイズがあった時にinvalidateSizeを実行
var timer = false;
$(window).on("resize", function() {
    if (timer !== false) {
        clearTimeout(timer);
    }
    timer = setTimeout(function() {
        // console.log('resized');
        map.invalidateSize();
    },500);
});
