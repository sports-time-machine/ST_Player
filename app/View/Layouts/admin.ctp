<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

//$cakeDescription = 'myblend.jp';
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo "スポーツタイムマシン管理画面" ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->script('jquery-1.9.1.min', array('inline' => false));
		echo $this->Html->script('bootstrap.min', array('inline' => false));
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('admin');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

<script type="text/javascript">
$(function(){
	// メニューハイライト
	$('.<?php echo $this->action; ?>').addClass('active');
	// uploadPackのリンク切れ画像置き換え
	$('img.uploadPack').error(function() {
		$(this).attr({
			src: '<?php echo $this->Html->url("/img/uploadpack_default.jpg"); ?>',
			title: 'dummy image for uploadPack'
		});
	});
	$('img.uploadPack_thumb').error(function() {
		$(this).attr({
			src: '<?php echo $this->Html->url("/img/uploadpack_default.jpg"); ?>',
			title: 'dummy thumbnail image for uploadPack',
			style: 'width: 80px;'
		});
	});
});
</script>

</head>
<body>
	<div id="header">
		
	</div>
	<div id="navigation">
		<div class="navbar navbar-static-top navbar-inverse">
			<div class="navbar-inner">
				<a class="brand" href="#" onclick="return false;">ST_Player管理画面</a>
				<ul class="nav">
					<li class="users"><a href="<?php echo $this->Html->url("/admin/users"); ?>">選手</a></li>
					<li class="search"><a href="<?php echo $this->Html->url("/log/search"); ?>">ログ</a></li>
					<li><a href="<?php echo $this->Html->url("/users/logout"); ?>">ログアウト</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="contents" class="clear">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>
	<div id="footer">
	</div>
</body>
</html>
