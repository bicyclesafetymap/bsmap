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
