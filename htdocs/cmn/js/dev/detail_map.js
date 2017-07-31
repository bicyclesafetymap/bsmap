// Map初期設定
// var homeLatLng = [35.8367, 139.2201]; // PHP の出力ビューへ移動
var homeZoomLev = 10;

var map = L.map('detailMap', {
  center: homeLatLng,
  zoom: homeZoomLev,
  zoomControl: false,
  scrollWheelZoom: false,
  dragging:true
});

$(".js-detiilMapOver-del").on('click', function(event) {
  $(this).css("display","none");
});


// ====== マップタイル設定 ======

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

// 初期表示マップ
map.addLayer(ggl2);


// アイコン初期設定
var baseIconSetting = L.Icon.extend({
  options: {
    // shadowUrl: 'http://leafletjs.com/docs/images/leaf-shadow.png',
    iconSize: [40, 50],
    // shadowSize: [50, 64],
    // iconAnchor: [22, 94],
    // shadowAnchor: [4, 62],
    // popupAnchor: [-3, -76]
  }
});

// Geojson Version
fetch('/api/mapdetail/'+point_id+'.json')
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
      // onEachFeature: onEachFeaturePopup
    });

    // markers2.addLayer(geoMarker);
    map.addLayer(geoMarker);

  }).catch(function(ex) {
    // console.log('parsing failed', ex);
  });

// ポップアップ each処理
function onEachFeaturePopup(feature, layer) {
  if (feature.properties && feature.properties.title) {
    layer.bindPopup("<div class='mapPopUp'>\
<div class='mapPopUp_day'>" + feature.properties.time + "</div>\
<div class='mapPopUp_inner'>\
<div class='mapPopUp_pic' style='background-image: url(/" + feature.properties.thumb + ")'>\
</div>\
<div class='mapPopUp_text'>" + feature.properties.title + "</div>\
</div>\
<div class='mapPopUp_more'><a href='" + feature.properties.detail + "'>詳細</a></div></div>\
");
  }
}

//アイコン説明文ポップアップ動作
$(function() {

  var item  = $(".detailIconContainer .detailIconContainer_item");
  var count = item.length - 1;

  var i;
  item.each(function(i) {

    //タイトル表示エリアの追加
    if( i % 4 == 0 && i !== 0){
      $(this).after('<div class="detailIconContainer_target js-target"></div>');
    } else if( i == count ){
      $(this).after('<div class="detailIconContainer_target js-target"></div>');
    }

    $(this).on('click', function() {
      var num    = item.index(this);
      var title  = $(this).attr("data-title");
      var target = $(".js-target");

      if($(this).hasClass('active')){
        target.hide();
        item.removeClass('active');
        return false;
      }

      target.hide();
      item.removeClass('active');
      $(this).addClass('active');

      $(this).parent().find('.js-target').text(title).fadeIn();

    });
  });
});




//ストリートビューのあるなし判定 start
var parameters, pitch = 0, heading = parseInt(Math.random()*180);
var latlng = new google.maps.LatLng(homeLatLng[0], homeLatLng[1]);

var map2 = new google.maps.Map(
    document.getElementById("stvMap"),{
        zoom : 16,
        center : latlng,
        mapTypeId : google.maps.MapTypeId.ROADMAP
    }
);

// ストリートビュー表示
var panorama = new google.maps.StreetViewPanorama(
  document.getElementById("stvMap"), {
    position : latlng,
    pov: {
      heading: heading,
      pitch: pitch
    }
  }
);
map2.setStreetView(panorama);

var streetViewDidAppearListener = google.maps.event.addListener(panorama, "status_changed", function() {
    google.maps.event.removeListener(streetViewDidAppearListener);

    // 通常は見たい場所の座標とカメラ座標が違う
    if ( ! panorama.getPosition().equals(latlng)) {
        adjustPanoramaPov();
        return;
    }

    // カメラ座標が指定場所と同じ場合、ストリートビュー用の画像がないことを疑う
    // 少し座標をずらしてもう一度試みる
    var stirredPosition = new google.maps.LatLng(latlng.lat(), latlng.lng() + 0.000004);
    setTimeout(function() {
        panorama.setPosition(stirredPosition);
    });
    document.getElementById("stvMap").style.display = "none"; // ストリートビュー画像なし

    document.getElementById("de_03").style.display = "none";
    // ストリートビュー画像なし
    $(".detailNavi_item-width").remove();


    var streetViewDidUpdateListener = google.maps.event.addListener(panorama, "status_changed", function() {
        google.maps.event.removeListener(streetViewDidUpdateListener);

        // ずらした位置からカメラ位置が変化していれば画像が存在すると判断
        if (!panorama.getPosition().equals(stirredPosition)) {
            document.getElementById("stvMap").style.display = "block"; // ストリートビュー画像あり
            adjustPanoramaPov();
        }
    });
});

function adjustPanoramaPov() {
    var posFrom, posTo, dlat, dlng, heading;

    posFrom = panorama.getPosition();
    posTo   = latlng;
    dlat    = posTo.lat() - posFrom.lat();
    dlng    = posTo.lng() - posFrom.lng();
    heading = Math.atan2(dlng, dlat) / Math.PI * 180;
    if (heading < 0) {
        // heading += 360; // [-180, 180] に対して heading の値は [0, 360] なので修正する
    }

    // タイマーを入れないと表示が更新されない
    setTimeout(function() {
        // panorama.setPov({ heading: heading, pitch: 0 });
    });
}
//ストリートビューのあるなし判定 end
