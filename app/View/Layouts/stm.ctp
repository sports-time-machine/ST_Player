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
<?php $this->response->header('Access-Control-Allow-Origin', '*'); ?>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo __('スポーツタイムマシン'); ?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->script('jquery-1.9.1.min', array('inline' => false));
		echo $this->Html->script('jquery-ui-1.10.3.custom.min', array('inline' => false));
		echo $this->Html->script('jquery.ui.datepicker-ja', array('inline' => false));
		echo $this->Html->script('bootstrap.min', array('inline' => false));
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('jquery-ui/blitzer/jquery-ui-1.10.3.custom.min.css');
		echo $this->Html->css('style');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

<script type="text/javascript">
$(function() {
	// uploadPackのリンク切れ画像置き換え
	$('.thumbnails img, .search-image img').error(function() {
		$(this).attr({
			src: '<?php echo $this->Html->url("/img/noimage.png"); ?>',
			title: 'noimage'
			//style: 'width: 160px;'
		});
	});
	// jQuery-UI datepicker
	if ($('.datepicker').length) { /* IE6 FF */
		$('.datepicker').datepicker({
			inline: true,
			changeMonth: true,
			changeYear: true,
			yearRange: 'c-90:c+10',
			dateFormat: 'yy-mm-dd'
		});
	}
});
</script>
</head>
<body>
<div id="container">
	<!-- header -->
	<div id="header">
        <?php echo $this->element('header'); ?>
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
	
<!-- analytics -->
<?php echo $this->element('analytics'); ?>

</body>
</html>
