<script type="text/javascript">
</script>

<?php echo $this->Form->create('User'); ?>
	<div>ユーザー名を入力してください</div>
	<div><?php echo $this->Form->text('username',array('label' => false, 'value' => "")); ?></div>
	<div>パスワードを入力してください</div>
	<div><?php echo $this->Form->password('password',array('label' => false, 'value' => "")); ?></div>
<?php echo $this->Form->submit('ログイン',array('label' => false, 'class' => 'btn')); ?>
