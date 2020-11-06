<?= $this->Html->script('jsQR.js', ['inline' => false]); ?>
<script type="text/javascript">
var sending = false;


//エラーをモーダルで表示
function showModal(mes){
    $('#result').html(mes); 
    $("#errorModal").modal("show");
}

function AuthQRCodeAjax(id) {
	if (sending === true) return;
	var url = "<?php echo $this->Html->webroot . 'users/login'; ?>";
	var data = { User : { player_id : id }};
	
	sending = true;
    $('#info').text('よみこみました。かくにんちゅうです…');
	$.ajax({
		type: "POST",
		url: url + '?time=' + (new Date).getTime(),
		data: data
	})
	.done((data) => {
		if (data == "OK"){
			location.href = "<?php echo $this->Html->webroot . 'users/'; ?>";
		} else {
			showModal("<div>ログインにしっぱいしました。</div>QRコードがだだしくよみとられていません。");
		}
	})
	.fail(() => {
        $('#info').text('せんしゅカードのQRコードをうつしてください');
	});
}

$(function(){
	var video  = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	
	var ctx = canvas.getContext('2d');
	var localMediaStream = null;

    if (!navigator.mediaDevices) {
		showModal('カメラがつかえませんでした。<a href="<?php echo $this->Html->webroot . 'users/passwordLogin'; ?>">せんしゅばんごうログイン</a>をつかってください。');
    }
	window.URL = window.URL || window.webkitURL;

    var constraints = {
        video:{ facingMode: 'user' },
        audio: false,
    }
 
    var readQrCode = () => {
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const image = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(image.data, canvas.width, canvas.height);
        if (code) {
            if (code.data.match(/^P[A-Z0-9]{8}$/)) {
                AuthQRCodeAjax(code.data);
            }
        }
    }

    navigator.mediaDevices.getUserMedia(constraints)
        .then( function(stream) {
            video.srcObject = stream;
            video.onloadedmetadata = (_) => {
                setInterval(readQrCode, 300);
            } 
        })
        .catch(function(err){
            alert("カメラがつかえません。");
        });

    $('#errorModal').on('hidden.bs.modal', function () {
        sending = false;
    });
});
</script>

<div class="cameraLogin">
	<!-- メッセージ -->
	<div id="errorDialog" class="alert alert-error fade in" style="display: none;">
		<span id="errorMessage"></span>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>

	<div class="camera">
        <video id="video" autoplay width="400" height="300" style="transform: scale(-1, 1);"></video>
        <canvas id="canvas" width="400" height="300"></canvas>
	</div>

	<div id="info" class="info">
		<?= __('せんしゅカードのQRコードをうつしてください') ?>
	</div>

	<div class="modal hide fade" id="errorModal">
		<div class="error modal-body" id="result"></div>
	</div>
</div>