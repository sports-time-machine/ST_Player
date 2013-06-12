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

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo "スポーツタイムマシン" ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->script('jquery-1.9.1.min', array('inline' => false));
		echo $this->Html->script('bootstrap.min', array('inline' => false));
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('style');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
<div id="container">
	<!-- header -->
	<div id="header">
		<div class="logo">スポーツタイムマシン</div>
		<div class="loginuser">
			<?php if ($user['User']['username']){ ?>
			<span>ようこそ！<?php echo $user['User']['username']; ?>選手！</span>
			<?php } ?>
		</div>
		<div class="logout">
			<?php if ($user['User']['username']){ ?>
				<?php echo $this->Html->link('ログアウト',array('action' => 'logout')) ?>
			<?php } ?>
		</div>
	</div>


	<!-- contents -->
	<div id="contents" class="clear">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>


	<!-- hooter -->
	<div id="footer">
		<div id="copyright" style="text-align: center; margin-top: 10px;">Sports Time Machine !</div>
	</div>
</div>
</body>
</html>
