<?php
echo $this -> Html -> script( 'webcam/grid', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/version', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/detector', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/formatinf', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/errorlevel', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/bitmat', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/datablock', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/bmparser', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/datamask', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/rsdecoder', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/gf256poly', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/gf256', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/decoder', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/qrcode', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/findpat', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/alignpat', array( 'inline' => false ) );
echo $this -> Html -> script( 'webcam/databr', array( 'inline' => false ) );
?>
<script type="text/javascript">
$(function(){
    var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    
    //canvasは２倍の大きさにしないと駄目みたい？
    canvas.width = video.width*2;
    canvas.height = video.height*2;
    
    var ctx = canvas.getContext('2d');
    var localMediaStream = null;

    //カメラ使えるかチェック
    var hasGetUserMedia = function() {
        return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia || navigator.msGetUserMedia);
    }

    if (!hasGetUserMedia()) {
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
        }
    );

    // QRコード取得時のコールバックを設定
    qrcode.callback = function(result) {
         
      // QRコード取得結果を表示
      if (result != null) {
        //QRコード出力値のバリデーションを行わなければならない
        var reg = /[A-Z0-9]{4}/;    //文字アルファベット４つだとマッチ
        
        if (result.match(reg)){
            $('#result').text("読み込みに成功しました！選手名を入力して、登録ボタンを押してください。");
            $('#disp_id').text("選手ID:"+result);
            $('#UserPlayerId').val(result);
            $('#register_name').css("display", "block");
            $('#read').css("display", "none");
        }else{
            $('#result').text("読み込みに失敗しました。QRコードの内容が違うか、正しく読み取られていません。");
        }
      }else{
          $('#result').text("読み込みに失敗しました。QRコードの内容が違うか、正しく読み取られていません。");
      }
    };
      
    //ボタンイベント
    $("#read").click(function() {
        if (localMediaStream) {
            $('#result').text("QRコードを読み取り中です…");
            
            ctx.drawImage(video, 0, 0);
            // QRコード取得開始
            qrcode.decode(canvas.toDataURL('image/webp'));        
        }
    });

});
</script>

<?php echo $this->Form->create('User'); ?>
<div>選手カードにあるQRコードをかざしてボタンを押してください</div>
<div id="camera">
    <video id="video" autoplay width="320" height="240"></video> 
    <canvas id="canvas" ></canvas>
</div>
<?php echo $this->Form->button('読み込み',array('type' => 'button', 'div' => false, 'id' => 'read')) ?>

<div id="register_name">
    <div id="disp_id"></div>
    <div>選手名を入力してください</div>
    <?php echo $this->Form->text('username',array('label' => false, 'value' => "")); ?>
    <?php echo $this->Form->hidden('player_id'); ?>
    <?php echo $this->Form->submit('登録',array('label' => false)); ?>
    </div>
<div  class="error" id="result"></div>
<?php echo $this->Html->link('選手ログイン画面へ',array('action' => 'login')) ?>