function createMap(e){$("#"+e[4]).css("height",e[6]);var t=new google.maps.LatLng(e[2],e[3]),a=[{elementType:"geometry",stylers:[{hue:"#ff4400"},{saturation:-100},{lightness:-4},{gamma:.72}]},{featureType:"road",elementType:"labels.icon"},{featureType:"landscape.man_made",elementType:"geometry",stylers:[{hue:"#0077ff"},{gamma:3.1}]},{featureType:"water",stylers:[{hue:"#00ccff"},{gamma:.44},{saturation:-33}]},{featureType:"poi.park",stylers:[{hue:"#44ff00"},{saturation:-23}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{hue:"#007fff"},{gamma:.77},{saturation:65},{lightness:99}]},{featureType:"water",elementType:"labels.text.stroke",stylers:[{gamma:.11},{weight:5.6},{saturation:99},{hue:"#0091ff"},{lightness:-86}]},{featureType:"transit.line",elementType:"geometry",stylers:[{lightness:-48},{hue:"#ff5e00"},{gamma:1.2},{saturation:-23}]},{featureType:"transit",elementType:"labels.text.stroke",stylers:[{saturation:-64},{hue:"#ff9100"},{lightness:16},{gamma:.47},{weight:2.7}]}],o={zoom:16,center:t,styles:a,mapTypeControl:!1,scrollwheel:!1,panControl:!1,streetViewControl:!1,disableDoubleClickZoom:!1,zoomControl:!1,draggable:!1,disableDefaultUI:!0},n="<strong>"+e[0]+"</strong><br>"+e[1],s=new google.maps.LatLng(e[2],e[3]),r={url:"/cmn/img/report/pic_mappin.png"},l=new google.maps.Map(document.getElementById(e[4]),o);createMarker(n,s,r,l)}function createMarker(e,t,a,o){new google.maps.InfoWindow,new google.maps.Marker({position:t,icon:a,map:o,animation:google.maps.Animation.DROP})}var currentWindow=null;!function(){var e=google.maps.InfoWindow.prototype.set;google.maps.InfoWindow.prototype.set=function(t,a){("map"!==t||this.get("noSuppress"))&&e.apply(this,arguments)}}();