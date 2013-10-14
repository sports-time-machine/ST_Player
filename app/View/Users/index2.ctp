<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="canonical" href="http://www.sptmy.net/" />
<title>スポーツタイムマシン山口事務局</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript" ></script>
<script src="js/highcharts/highcharts.js" type="text/javascript" ></script>
<script src="js/highcharts/modules/exporting.js" type="text/javascript" ></script>
<style type="text/css">
body {
  font-family: "Lucida Grande","Hiragino Kaku Gothic Pro","ヒラギノ角ゴ Pro W3","メイリオ",Meiryo,"ＭＳ Ｐゴシック",Verdana,Arial,sans-serif; 
  font-size: 18px;
  color: #666;
  margin:0;
  padding:0;
}
a{
  color:#29aedb;
  text-decoration:none;
}
table{
  max-width:600px;
  margin:0 auto;
  text-align:left;
  border-collapse: collapse;
}
tr,td{
  border:1px solid #00aa9b;
}
td{
  padding:10px 20px;
}
a:hover{
  text-decoration:underline;
}
.header{ 
  position:relative;
  line-height:90px;
  border-bottom:1px solid #ddd;  
}
.wrapper { 
  border-bottom:1px solid #ddd;  
  padding:50px 0;
}
.wrapper-inner {
  position:relative; 
  max-width: 950px; 
  margin:0 auto; 
}
.catch{
  height:450px;
}
.right{
  text-align:right;
}
.center{
  display:block;
  width:100%;
  text-align:center;
}
.w50{
  display:inline-block;
  margin-bottom: 25px;
  width:400px;
  padding:0 25px;
  vertical-align:top;
}
.mt100{
  margin-top:100px;
}
.impact{
  font-size:36px;
  font-weight:bold;
  color: #f79122;
}
.btn{
  padding: 10px 20px;
  background-color: #29aedb;
  color: white !important;
  font-size: 18px;
  border: none;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  text-decoration: none;
}

#card{
  position:absolute;
  top:15px;
  right:120px;
}
.fade{
  display:none;
}


</style>
<script type="text/javascript">
$(document).ready(function() {
	$('.fade').delay(800).fadeIn("slow");
});

$(function () {
	$('#graph').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'スポーツタイムマシン　登録人数と走った回数'
		},
		xAxis: {
			categories: <?php echo json_encode($keys); ?>
		},
		yAxis: {
			min: 0,
			title: {
				text: 'number'
			}
		},
		tooltip: {
			formatter: function() {
				var msg = '<span style="font-size:10px">' + this.x + '</span>';
				$.each(this.points, function(i, point) {
					if (point.series.index == 0) {
						msg += '<br/><span style="color:' + point.series.color + '">'+ point.series.name + ': </span><b>' + point.y + ' 人</b>';
					} else if (point.series.index == 1) {
						msg += '<br/><span style="color:' + point.series.color + '">'+ point.series.name + ': </span><b>' + point.y + ' 回</b>';
					}
				});
				return msg;
			},
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [{
			name: '登録人数',
			data: <?php echo json_encode($count_users_full); ?>
		}, {
			name: '走った回数',
			data: <?php echo json_encode($count_records_full); ?>
		}]
	});
});
</script>

</head>

<body>

<!-- header -->
<div class="header">
  <div class="wrapper-inner right">
    <span id="card">
      <img src="./img/card.png" />
    </span>
    <a href="<?php echo $this->Html->url('/users/login'); ?>" class="btn">ログイン</a>
  </div>
</div><!-- /header -->


<!-- catch -->
<div class="wrapper">
  <div class="wrapper-inner catch">
    <div class="fade">
    <img src="./img/stm-logo.png" align="left" />
    <img src="./img/ycam10th.gif" align="right" />
    </div>
  </div>
  <div class="wrapper-inner">
    <a href="#about" class="center">スポーツタイムマシンとは？</a>
  </div>
</div><!-- /catch -->


<!-- now -->
<div class="wrapper" id="now">  
  <p class="center impact">スポーツタイムマシンのいま</p>

  <div class="wrapper-inner center">
    <p>7月6日から現在までに <?php echo $count_users_sum; ?> 人が登録し、<?php echo $count_records_sum; ?> 回走りました</p>
    <p><div id="graph2"></div></p>
    <p><div id="graph"></div></p>
　</div>
</div><!-- /now -->


<!-- about -->
<div class="wrapper" id="about">
  <p class="center impact">スポーツタイムマシンとは？</p>
  <div class="wrapper-inner">
    <div class="w50">
      <img src="./img/stm-400px.jpg" />
    </div>
    <div class="w50">
      <p>スクリーンに映し出される昔の記録と「かけっこ」できる装置です。
      自分の記録だけではなく、家族や友達、動物の記録に挑戦することができます。
      </p>
      <p>
      このタイムマシンをみんなで作り、長い期間大切に運営していくプロジェクトです。
      </p>
    </div>
    <div class="w50">
      <iframe width="400" height="283" src="//www.youtube.com/embed/klkpkFE4Obo?list=UU1kmLlEbNZRamO7wJtk4fng" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="w50">
      <p>2013年7月6日から始まる<a href="http://10th.ycam.jp/" target="_blank">山口情報芸術センター(YCAM)10周年記念祭</a>で、世界初の「スポーツタイムマシン」を体験することができます。
      </p>
      <p>家族や友達と一緒に「スポーツタイムマシン」を楽しんでください！
      </p>
    </div>
  </div>
</div><!-- /about -->

<!-- play -->
<div class="wrapper" id="play">
  <p class="center impact">あそびかた</p>
  <div class="wrapper-inner" id="play">
    <div class="w50">
      <img src="./img/play1.png" />
    </div>
    <div class="w50">
      <h2>走るあいてをえらぶ</h2>
      <p>どうぶつや、スポーツ選手、前に走ったお友達など、いろんな記録を選べるよ！
      </p>
    </div>    
    <div class="w50">
      <h2>選手せんせい＋選手とうろく</h2>
      <p>選手カードで自分の走った情報が管理できるよ。
      </p>
    </div>
    <div class="w50">
      <img src="./img/play2.png" />
    </div>    
    <div class="w50">
      <img src="./img/play3.png" />
    </div>
    <div class="w50">
      <h2>よーいドン！</h2>
      <p>えらんだ記録の映像と一緒に、<br />25ｍを折り返して、50ｍはしろう！
      </p>
    </div>    
    <div class="w50">
      <h2>さいごに</h2>
      <p>自分の走った記録にコメントをつけて、<br />壁に貼ろう。
    </div>
    <div class="w50">
      <img src="./img/play4.png" />
      </p>
    </div>    
　</div>
</div><!-- play -->

<!-- info -->
<div class="wrapper" id="info">  
  <p class="center impact">スポーツタイムマシン</p>

  <div class="wrapper-inner center">
    <p>YCAM10周年記念祭 LIFE by MEDIA 国際コンペティション 受賞・展示作品</p>
    <table>
      <tr>
        <td>期間</td>
	<td>7月6日(土)～9月1日(日) 10時～19時 ※火曜定休</td>
      </tr>
      <tr>
        <td>会場</td>
	<td>山口市道場門前商店街 オアシスどうもん横</td>
      </tr>
      <tr>
        <td>料金</td>
	<td>無料</td>
      </tr>
    </table>
    <p>オフィシャルブログ：<a href="http://sportstimemacine.blogspot.jp/" target="_blank">スポーツタイムマシンをつくろう！</a>
　</div>
</div><!-- info -->


<!-- contact -->
<div class="wrapper" id="contact">  
  <p class="center impact">お問い合わせ</p>

  <div class="wrapper-inner center">
    <p>スポーツタイムマシン山口事務局</p>
    <p>
    <script type="text/javascript">
    <!--
      function converter(M){
      var str="", str_as="";
      for(var i=0;i<M.length;i++){
      str_as = M.charCodeAt(i);
      str += String.fromCharCode(str_as + 1);
      }
      return str;
      }
      function mail_to(k_1,k_2)
      {eval(String.fromCharCode(108,111,99,97,116,105,111,110,46,104,114,101,102,32,61,32,39,109,97,105,108,116,111,58) 
      + escape(k_1) + converter(String.fromCharCode(98,110,109,115,96,98,115,63,114,111,115,108,120,45,109,100,115,62,114,116,97,105,100,98,115,60)) 
      + escape(k_2) + "'");} 
      document.write('<a href=JavaScript:mail_to("","") class="btn">メールで問い合わせる<\/a>');
    //-->
    </script>
    </p>
    
    
　</div>
</div><!-- /contact -->

</body></html>