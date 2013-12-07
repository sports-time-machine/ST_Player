<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="canonical" href="http://www.sptmy.net/" />
<title>スポーツタイムマシン山口事務局</title>
<meta name="description" content="山口情報芸術センター［YCAM］10周年記念祭「LIFE by MEDIA 国際コンペティション」をきっかけに、山口市道場門前商店街に作られた、世界で最初の“スポーツのタイムマシン”です。">
<meta name="keywords" content="山口,情報芸術センター,YCAM,スポーツ,タイムマシン,犬飼博士,安藤僚子">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript" ></script>
<script src="js/highcharts/highcharts.js" type="text/javascript" ></script>
<script src="js/highcharts/modules/exporting.js" type="text/javascript" ></script>
<link type="text/css" href="css/index2.css" media="all" rel="stylesheet" />

<script type="text/javascript">
$(document).ready(function() {
	$('.fade').delay(800).fadeIn("slow");
});

$(function () {

	// グラフテーマ
	Highcharts.theme = {
		xAxis: {
			gridLineWidth: 0,
			lineColor: '#000',
			tickColor: '#000',
			labels: {
				style: {
					color: '#000',
					font: '11px Trebuchet MS, Verdana, sans-serif'
				}
			},
			title: {
				style: {
					color: '#333',
					fontWeight: 'bold',
					fontSize: '12px',
					fontFamily: 'Trebuchet MS, Verdana, sans-serif'

				}
			}
		},
		yAxis: {
			minorTickInterval: 'auto',
			lineColor: '#000',
			lineWidth: 1,
			tickWidth: 1,
			tickColor: '#000',
			labels: {
				style: {
					color: '#000',
					font: '11px Trebuchet MS, Verdana, sans-serif'
				}
			},
			title: {
				style: {
					color: '#333',
					fontWeight: 'bold',
					fontSize: '12px',
					fontFamily: 'Trebuchet MS, Verdana, sans-serif'
				}
			}
		}
	};
	var highchartsOptions = Highcharts.setOptions(Highcharts.theme);

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
			max: 300,
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
    <ul id="button">
      <li class="mediaarts"><a href="http://j-mediaarts.jp/awards/excellence_award?locale=ja&section_id=2"><img src="./img/txt-mediaarts.png" /></a></li>
      <!--li class="btn1"><a href="http://www.sptmy.net/records/search/"><img src="./img/txt-btn1.png" /></a></li-->
      <li class="btn2"><a href="http://sportstimemacine.blogspot.jp/"><img src="./img/txt-btn2.png" /></a></li>
      <li class="btn3"><a href="http://www.sptmy.net/records/search/"><img src="./img/txt-btn3.png" /></a></li>
    </ul>
    <!--img src="./img/ycam10th.gif" align="right" /-->
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
      <p>2013年の夏、<a href="http://10th.ycam.jp/" target="_blank">山口情報芸術センター［YCAM］10周年記念祭</a>をきっかけに、世界で最初の“スポーツのタイムマシン”が誕生しました。
      </p>
      <p>7月6日から12月1日までに 3178 人が登録し、11149 回走りました。</p>
    </div>
    <div class="w50">
      <img src="./img/stm-pic2.jpg" />
    </div>
    <div class="w50">
      <p>山口市道場門前商店街に作られたスポーツタイムマシンは、たくさんの人に利用され、たくさんの笑顔を生みだしました。</p>
      <p>2013年12月5日、山口のスポーツタイムマシンは、<a href="http://j-mediaarts.jp/awards/excellence_award?locale=ja&section_id=2" target="_blank">第17回文化庁メディア芸術祭 エンターテインメント部門「優秀賞」</a>を受賞しました。</p>
      <p>2014年2月には、東京のどこかでスポーツタイムマシンを体験することが出来るかも知れません。
      </p>
    </div>
    <div class="w50">
      <img src="./img/stm-pic3.jpg" />
    </div>
    <div class="w50">
      <p>山口では、スポーツタイムマシンの楽しさを忘れられない人たちが「スポーツタイムマシン保存会(仮)」を発足しました。</p>
      <p>来年も楽しく走るにはどうしたらいいでしょう？みんなで一緒に考えましょう。</p>
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
      <p>どうぶつや、スポーツ選手、前に走ったお友達など、いろんな記録を選べるよ！</p>
      <p>スマートフォンやタブレットを使って、インターネットからも記録を選べるよ→<a href="http://www.sptmy.net/records/search/">きろくけんさく</a>
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
      </p>
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
    <p>第17回文化庁メディア芸術祭 エンターテインメント部門「優秀賞」受賞</a>
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

<!-- analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45317450-1', 'sptmy.net');
  ga('send', 'pageview');

</script><!-- /analytics -->

</body></html>
