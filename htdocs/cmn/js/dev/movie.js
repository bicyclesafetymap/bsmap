$.youtubeReady = function(callback){
    var EVENT_READY = "youtubeready";

    if(window.YT && window.YT.Player){
        return callback();
    }
    $(window).on(EVENT_READY, callback);
    window.onYouTubeIframeAPIReady = function(){
        $(this).trigger(EVENT_READY);
        window.onYouTubeIframeAPIReady = void 0;
    };
    $("<script>", {src: "https://www.youtube.com/iframe_api"}).appendTo("body");
};

$.youtubeReady(function(){
  var player = new YT.Player("youtubeMain", {
      // videoId: youtubeId[n],
      videoId: videoId, // PHP のビューで代数を宣言
      width: 640,
      height: 360,
      playerVars: {
          autoplay: 0, // 自動再生する・しない
          controls: 1, // コントロールを表示する・しない
          showinfo: 0, // 動画の情報テキストを表示する・しない+
          rel: 0, //再生終了後に関連動画を表示するかどうか 0:非表示 1:表示(デフォルト)
          theme: "light" // テーマの選択（dark|light）
      },
      events: {
          onReady: function(e){
              // console.log("--APIの準備が整いました--");
          },
          onStateChange: function(e){
              if(e.data === YT.PlayerState.PLAYING){
                  // console.log("--再生中--");
              }
          }
      }
    });
});



