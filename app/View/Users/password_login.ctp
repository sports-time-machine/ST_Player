<script type="text/javascript">
</script>

<?php echo $this->Form->create('User'); ?>
	<div>選手名を入力してください（例：やまぐちたろう）</div>
	<div><?php echo $this->Form->text('username',array('label' => false, 'value' => "")); ?></div>
	<div>選手番号を入力してください（例：ABCD1234）</div>
	<div><?php echo $this->Form->text('player_id',array('label' => false, 'value' => "")); ?></div>
<?php echo $this->Form->submit('ログイン',array('label' => false, 'class' => 'btn')); ?>
