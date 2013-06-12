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
	$('#errorMessage').text(msg);
	$('#errorDialog').show();
}
function AuthQRCodeAjax(name, id) {
	var url = "<?php echo $this->Html->webroot . 'users/login'; ?>";
	var data = { User : {username : name , player_id : id }};
	
	$.ajax({
		type: "POST",
		url: url + '?time=' + (new Date).getTime(),
		data: data,
		async: true,
		success: function(html){
			if (html == "OK"){
				location.href = "<?php echo $this->Html->webroot . 'users/'; ?>";
			} else {
				$('#result').text("ログインに失敗しました。選手名が違うか、QRコードが正しく読み取られていません。");
			}
		},
		error: function(a,b,c){
			showErrorMessage(c);
			//alert(c);
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
		showErrorMessage('ご利用のブラウザは対応していません。最新バージョンのChromeブラウザをご利用ください');
		//alert("未対応ブラウザです");
	}
	window.URL = window.URL || window.webkitURL;
	navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia ||
							  navigator.mozGetUserMedia || navigator.msGetUserMedia;

	navigator.getUserMedia({video: true},
		function(stream) {
			video.src = window.URL.createObjectURL(stream);
			localMediaStream = stream;
		},
		function(err) {
			//alert("セットアップ中にエラーが発生しました");
			showErrorMessage('webカメラが利用できません');
		}
	);

	// QRコード取得時のコールバックを設定
	qrcode.callback = function(result) {
		// QRコード取得結果を表示
		if (result != null) {
			AuthQRCodeAjax($("#UserUsername").val(), result);
		} else {
			$('#result').text("ログインに失敗しました。選手名が違うか、QRコードが正しく読み取られていません。");
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

<!-- メッセージ -->
<div id="errorDialog" class="alert alert-error fade in" style="display: none;">
	<span id="errorMessage"></span>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>


<div>選手名を入力してください</div>
<?php echo $this->Form->text('username', array('label' => false, 'value' => "")); ?>

<div>選手カードにあるQRコードをかざしてログインボタンを押してください</div>
<div id="camera">
	<video id="video" autoplay width="320" height="240"></video> 
	<canvas id="canvas" ></canvas>
</div>

<?php echo $this->Form->button('ログイン',array('type' => 'button', 'div' => false, 'id' => 'read', 'class' => 'btn')) ?>

<div class="error" id="result"></div>
