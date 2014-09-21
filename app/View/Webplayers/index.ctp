<script type='text/javascript' src='https://ssl-webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/jquery.min.js'></script>
<script type="text/javascript">
<!--
var unityObjectUrl = "http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject2.js";
if (document.location.protocol == 'https:')
	unityObjectUrl = unityObjectUrl.replace("http://", "https://ssl-");
document.write('<script type="text\/javascript" src="' + unityObjectUrl + '"><\/script>');
-->
</script>
<script type="text/javascript">
<!--
	var config = {
		width: 640, 
		height: 480,
		params: { enableDebugging:"0" }
		
	};
	var u = new UnityObject2(config);
	var sendParams = "";

	jQuery(function() {
		sendParams = jQuery("#userId").val() + "," + jQuery("#sptmId").val() +"," + jQuery("#hash").val();
		var $missingScreen = jQuery("#unityPlayer").find(".missing");
		var $brokenScreen = jQuery("#unityPlayer").find(".broken");
		$missingScreen.hide();
		$brokenScreen.hide();
		
		u.observeProgress(function (progress) {
			switch(progress.pluginStatus) {
				case "broken":
					$brokenScreen.find("a").click(function (e) {
						e.stopPropagation();
						e.preventDefault();
						u.installPlugin();
						return false;
					});
					$brokenScreen.show();
				break;
				case "missing":
					$missingScreen.find("a").click(function (e) {
						e.stopPropagation();
						e.preventDefault();
						u.installPlugin();
						return false;
					});
					$missingScreen.show();
				break;
				case "installed":
					$missingScreen.remove();
				break;
				case "first":
				break;
			}
		});
		u.initPlugin(jQuery("#unityPlayer")[0], "WebPlayer.unity3d");
	});

	function getData(){
		u.getUnity().SendMessage(
		"UnitsController",
		"Recieve",
		sendParams
		);
        }

-->
</script>
<style type="text/css">
<!--
div.content {
	margin: auto;
	width: 640px;
}
div.broken,
div.missing {
	margin: auto;
	position: relative;
	top: 50%;
	width: 193px;
}
div.broken a,
div.missing a {
	height: 63px;
	position: relative;
	top: -31px;
}
div.broken img,
div.missing img {
	border-width: 0px;
}
div.broken {
	display: none;
}
div#unityPlayer {
	cursor: default;
	height: 480px;
	width: 640px;
}
-->
</style>
<div class="content">
	<div id="unityPlayer">
		<div class="missing">
			<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">
				<img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
			</a>
		</div>
		<div class="broken">
			<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now! Restart your browser after install.">
				<img alt="Unity Web Player. Install now! Restart your browser after install." src="http://webplayer.unity3d.com/installation/getunityrestart.png" width="193" height="63" />
			</a>
		</div>
	</div>
</div>
<form action="" method="get">
	<input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>">
	<input type="hidden" name="sptmId" id="sptmId" value="<?php echo $sptmId; ?>">
	<input type="hidden" name="hash" id="hash" value="<?php echo $hash; ?>">
</form> 
