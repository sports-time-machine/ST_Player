<?php
echo $this->Html->script('webcam/grid', array('inline' => false));
echo $this->Html->script('webcam/version', array('inline' => false));
echo $this->Html->script('webcam/detector', array('inline' => false));
echo $this->Html->script('webcam/formatinf', array('inline' => false));
echo $this->Html->script('webcam/errorlevel', array('inline' => false));
echo $this->Html->script('webcam/bitmat', array('inline' => false));
echo $this->Html->script('webcam/datablock', array('inline' => false));
echo $this->Html->script('webcam/bmparser', array('inline' => false));
echo $this->Html->script('webcam/datamask', array('inline' => false));
echo $this->Html->script('webcam/rsdecoder', array('inline' => false));
echo $this->Html->script('webcam/gf256poly', array('inline' => false));
echo $this->Html->script('webcam/gf256', array('inline' => false));
echo $this->Html->script('webcam/decoder', array('inline' => false));
echo $this->Html->script('webcam/qrcode', array('inline' => false));
echo $this->Html->script('webcam/findpat', array('inline' => false));
echo $this->Html->script('webcam/alignpat', array('inline' => false));
echo $this->Html->script('webcam/databr', array('inline' => false));
?>
<script type="text/javascript">
function showErrorMessage(msg) {
	$('#errorMessage').html(msg);
	$('#errorDialog').show();
}

//エラーをモーダルで表示
function showModal(mes){
    $('#result').html(mes); 
    $("#errorModal").modal("show");
}

function AuthQRCodeAjax(id) {
	var url = "<?php echo $this->Html->webroot . 'users/login'; ?>";
	var data = { User : { player_id : id }};
	
	$.ajax({
		type: "POST",
		url: url + '?time=' + (new Date).getTime(),
		data: data,
		async: true,
		success: function(html){
			if (html == "OK"){
				location.href = "<?php echo $this->Html->webroot . 'users/'; ?>";
			} else {
                alert(html);
				showModal("<div>ログインに失敗しました</div>選手名が違うか、QRコードが正しく読み取られていません");
			}
		}
	});
}

$(function(){
	var video  = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	
	//canvasは２倍の大きさにしないと駄目みたい？
	canvas.width  = video.width * 2;
	canvas.height = video.height * 2;
	
	var ctx = canvas.getContext('2d');
	var localMediaStream = null;

	//カメラ使えるかチェック
	var hasGetUserMedia = function() {
		return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
			navigator.mozGetUserMedia || navigator.msGetUserMedia);
	}

	if (!hasGetUserMedia()) {
		showErrorMessage('ご利用のブラウザはWebカメラに対応していません。<a href="<?php echo $this->Html->webroot . 'users/passwordLogin'; ?>">選手番号ログイン</a>をご利用ください');
	}
	window.URL = window.URL || window.webkitURL;
	navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia ||
							  navigator.mozGetUserMedia || navigator.msGetUserMedia;

	navigator.getUserMedia({video: true, audio: false},
		function(stream) {
            if(navigator.userAgent.indexOf("Opera") != -1){
                video.src = stream; //Operaは直接streamを流し込む
            }else{
                video.src = window.URL.createObjectURL(stream);
            }
			localMediaStream = stream;
		},
		function(err) {
			showErrorMessage('webカメラが利用できません。<a href="<?php echo $this->Html->webroot . 'users/passwordLogin'; ?>">選手番号ログイン</a>をご利用ください');
		}
	);

	// QRコード取得時のコールバックを設定
	qrcode.callback = function(result) {
		// QRコード取得結果を表示
		if (result != null) {
            //読み込みできたら時間経過のイベント消去
            //非同期通信時にタイムアウトや読み込みを防ぐため
            clearInterval(intervalId);
            clearTimeout(timeoutId);        
			AuthQRCodeAjax(result);
		}
	};

    //ボタンイベント
    $("#read").click(function() {
    
        intervalId = setInterval(function(){
          
            if (localMediaStream) {
                ctx.drawImage(video, 0, 0);
                // QRコード取得開始
                qrcode.decode(canvas.toDataURL('image/webp'));        
            }     
            
        },500);

        //10秒経過するとタイムアウト
        timeoutId = setTimeout(function(){
            showModal("<div>読み込みに失敗しました</div>QRコードを読み取れませんでした");
        },10000);

        $("#read").attr('disabled', true);
        $('#info').html("<div>読み取り中です…</div><div>選手カードのQRコードをうつしてください</div>");
       
    });
    
    //エラー表示時には読み込みイベントを停止
    $("#errorModal").on('show',function(){
        clearInterval(intervalId);
        clearTimeout(timeoutId);        
    });
    
    //モーダルを閉じる時にボタンを利用可に
    $("#errorModal").on('hidden',function(){
        $('#read').removeAttr('disabled'); 
        $('#info').html("<div>選手カードにあるQRコードをかざして</div><div>ログインボタンを押してください</div>"); 
    });

});
</script>

<!-- メッセージ -->
<div id="errorDialog" class="alert alert-error fade in" style="display: none;">
	<span id="errorMessage"></span>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>

<div id="camera">
	<video id="video" autoplay width="480" height="360"></video> 
	<canvas id="canvas" style="display: none;"></canvas>
</div>

<div id="info">
    <div>選手カードにあるQRコードをかざして</div>
    <div>ログインボタンを押してください</div>
</div>
<?php echo $this->Form->button('ログイン',array('type' => 'button', 'div' => false, 'id' => 'read', 'class' => 'btn')) ?>

<div class="modal hide fade" id="errorModal">
    <div class="error modal-body" id="result"></div>
</div>
