<script type="text/javascript">
</script>

<?php echo $this->Form->create('User'); ?>
	<div><?php echo __('せんしゅ名を入力してください（例：やまぐちたろう）'); ?></div>
	<div><?php echo $this->Form->text('username', array('label' => false, 'value' => "", 'autocomplete' => 'off')); ?></div>
	<div><?php echo __('せんしゅばんごうを入力してください（例：ABCD）'); ?></div>
	<div><?php echo $this->Form->text('player_id', array('label' => false, 'value' => "", 'autocomplete' => 'off')); ?></div>
<?php echo $this->Form->submit(__('ログイン'),array('label' => false, 'class' => 'btn')); ?>
