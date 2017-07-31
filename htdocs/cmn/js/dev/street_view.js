$("#stvMap").css('height', screenH - 55 + 'px');
var parameters, pitch = 0, heading = parseInt(Math.random()*180);

if (BaseURL !== '')
{
    var base_url_array = BaseURL.split('/');

    for (var i = 0; i < base_url_array.length; i++ ) {
        if (base_url_array[i].match(/^@/))
        {
            parameters = base_url_array[i].split(',');
        }
    }

    if (typeof parameters !== "undefined") {
        for (var j = 0; j < parameters.length; j++ ) {

            // 緯度
            if (parameters[j].match(/^@[0-9]{2}./))
            {
                BaseLat = parseFloat(parameters[j].replace(/@/, ''));
            }

            // 経度
            if (parameters[j].match(/^[0-9]{3}.[0-9]+$/))
            {
                BaseLong = parseFloat(parameters[j]);
            }

            // 水平回転（方角）
            if (parameters[j].match(/[0-9]+h$/))
            {
                heading = parseFloat(parameters[j]);
            }

            // 上下方向
            if (parameters[j].match(/^[0-9]+t$/))
            {
                pitch = parseFloat(parameters[j])-90;
            }
        }
    }
}


// var latlng = new google.maps.LatLng(35.689232, 139.698712);
var latlng = new google.maps.LatLng(BaseLat, BaseLong);

var map = new google.maps.Map(
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
map.setStreetView(panorama);


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
    document.getElementById("stvMap").style.visibility = "hidden"; // ストリートビュー画像なし

    var streetViewDidUpdateListener = google.maps.event.addListener(panorama, "status_changed", function() {
        google.maps.event.removeListener(streetViewDidUpdateListener);

        // ずらした位置からカメラ位置が変化していれば画像が存在すると判断
        if (!panorama.getPosition().equals(stirredPosition)) {
            document.getElementById("stvMap").style.visibility = "show"; // ストリートビュー画像あり
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
