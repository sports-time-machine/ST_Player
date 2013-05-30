<?php
echo $this -> Html -> script( 'grid', array( 'inline' => false ) );
echo $this -> Html -> script( 'version', array( 'inline' => false ) );
echo $this -> Html -> script( 'detector', array( 'inline' => false ) );
echo $this -> Html -> script( 'formatinf', array( 'inline' => false ) );
echo $this -> Html -> script( 'errorlevel', array( 'inline' => false ) );
echo $this -> Html -> script( 'bitmat', array( 'inline' => false ) );
echo $this -> Html -> script( 'datablock', array( 'inline' => false ) );
echo $this -> Html -> script( 'bmparser', array( 'inline' => false ) );
echo $this -> Html -> script( 'datamask', array( 'inline' => false ) );
echo $this -> Html -> script( 'rsdecoder', array( 'inline' => false ) );
echo $this -> Html -> script( 'gf256poly', array( 'inline' => false ) );
echo $this -> Html -> script( 'gf256', array( 'inline' => false ) );
echo $this -> Html -> script( 'decoder', array( 'inline' => false ) );
echo $this -> Html -> script( 'qrcode', array( 'inline' => false ) );
echo $this -> Html -> script( 'findpat', array( 'inline' => false ) );
echo $this -> Html -> script( 'alignpat', array( 'inline' => false ) );
echo $this -> Html -> script( 'databr', array( 'inline' => false ) );
?>
<script type="text/javascript">
$(function(){
    var video = document.querySelector('video');
    var canvas = document.querySelector('canvas');
    var ctx = canvas.getContext('2d');
    var localMediaStream = null;

    //カメラ使えるかチェック
    var hasGetUserMedia = function() {
        return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia || navigator.msGetUserMedia);
    }
    
    //カメラ画像キャプチャ
    var snapshot = function() {
        if (localMediaStream) {
            ctx.drawImage(video, 0, 0);
            // QRコード取得開始
            qrcode.decode(canvas.toDataURL('image/webp'));        
  
        }
    }

    if (hasGetUserMedia()) {
        console.log("カメラ OK");
    } else {
        alert("未対応ブラウザです。");
    }


    window.URL = window.URL || window.webkitURL;
    navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia ||
                              navigator.mozGetUserMedia || navigator.msGetUserMedia;

    navigator.getUserMedia({video: true},
    function(stream) {
      video.src = window.URL.createObjectURL(stream);
      localMediaStream = stream;
    },
    function(err){
        alert("未対応ブラウザです。");
    });

    // QRコード取得時のコールバックを設定
    qrcode.callback = function(result) {
      // QRコード取得結果を表示
      $('#result').text(result);
    };
      
    //ボタンイベント
    $("video").click(function() {
        snapshot();
    });

});
</script>
    
<video autoplay width="320" height="240"></video> 
<div id="result"></div>
<canvas style="display:none;" width="640" height="480"></canvas>

