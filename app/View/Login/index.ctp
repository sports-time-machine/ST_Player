<script type="text/javascript">
$(function(){
    var width = 360;
    var height = 360;
    $("#jquery_camera").webcam({
        width: width, // webcamの横サイズ
        height: height,// webcamの縦サイズ
        swffile: "swf/jscam_canvas_only.swf",
        onTick: function(remain) {
            if(0 == remain){
                $("#status").text("Cheese!");
            }else{
                $("#status").text(remain + "seconds remaining...");
            }
        },
        onLoad: function() {
            var cams = webcam.getCameraList();
            for(var i in cams) {
                $("#cams").append("<li>" + cams[i] + "</li>");
            }
        }
    });
})
</script>
        
<strong>Webカメラから画像を設定</strong>
<div id="jquery_camera"></div>
<div id="camerastatus" style="margin-left: 10px;">
    <strong>カメラリスト</strong>
    <ul id="cams"></ul>
    <div id="status"></div>
</div>
