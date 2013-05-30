<script type="text/javascript">
$(function(){
    
    var canvas = document.getElementById('canvas');
    if (!canvas || !canvas.getContext){
        alert("canvas未対応")
        return;
    }
    
    ctx = canvas.getContext('2d');
    width = 320;
    height = 240;
    count =0;
    str="";
    imgdata = new Array();
    for (var i =0 ; i<width ; i++){
        imgdata[i] = new Array();
        for (var j=0; j<height; j++){
            imgdata[i][j] = new Array();
            imgdata[i][j]['r']=0;
            imgdata[i][j]['g']=0;
            imgdata[i][j]['b']=0;
        }
    }
    
    
    $("#jquery_camera").webcam({
        width: width, // webcamの横サイズ
        height: height,// webcamの縦サイズ
        swffile: "swf/jscam_canvas_only.swf",
        onLoad: function() {
            var cams = webcam.getCameraList();
            for(var i in cams) {
                $("#cams").append("<li>" + cams[i] + "</li>");
            }
            for(var i in webcam) {
                $("#cams").append("<li>" + i + "</li>");
            }
        },
        onSave: function(data){
            
            var rows=data.split(";");
            var r,g,b;
            
            for(var i=0; i<rows.length ; i++){
                imgdata[i][count%width]['r'] = (rows[i] >> 16) & 0xFF;
                imgdata[i][count%width]['g'] = (rows[i] >> 8) & 0xFF;
                imgdata[i][count%width]['b'] = (rows[i] >> 0) & 0xFF;
                //str+="("+r+","+g+","+b+")";
            }
            
            //var img = base64_decode(data);
            //ctx.drawImage(img,width,height);
            if (count % width == 0){
                var img = ctx.createImageData(width,height);
                var byteArray = img.data;
                for (var i =0 ; i<width ; i++){                 
                    for (var j=0; j<height; j++){
                        var idx = (j + i * width) * 3;
                        byteArray[idx+0] = imgdata[i][j]['r'];
                        byteArray[idx+1] = imgdata[i][j]['g'];
                        byteArray[idx+2] = imgdata[i][j]['b'];
                        byteArray[idx+3] = 255;
                    }
                }
                ctx.putImageData(imgData, 0, 0);
                
                //$("#data").html(str); 
                //str = "";
            }
            count++;
        }
    });

    $("#button").click(function(){
        webcam.capture();
    });

    /*
    setInterval(function(){
        webcam.capture();
    },1000);
    */
    /*
    $("#camarastatus").click(function(){
        alert("aa");
        webcam.capture();
    });
    */
       
})
</script>
        
<strong>Webカメラから画像を設定</strong>
<div id="jquery_camera"></div>

<input type="button" id="button" value="キャプチャ">

<div id="camerastatus" style="margin-left: 10px;">
    <strong>カメラリスト</strong>
    <ul id="cams"></ul>
    <div id="status"></div>
</div>

<div id="data">
</div>

<div>
    <canvas id ="canvas"></canvas>
</div>

