<script type="text/javascript">
$(function() {
	// 初期フォーカス
	$('#UserKeyword').focus();
});
</script>

<div class="admin users">
	<h2>選手一覧</h2>

	<!--
	<div style="margin: 20px 0px;">
		<a class="btn" href="<?php echo $this->Html->url('/admin/userAdd'); ?>">選手新規登録</a>
	</div>
	-->
	<?php
	echo $this->Form->create('User', array(
		'url' => array('controller' => 'admin', 'action' => 'users'),
		//'url' => array('controller' => 'admin', 'action' => 'users', 'validates' => false), // 'validates' => false が効かない
	));
	echo $this->Form->label('選手番号 または 選手名');
	echo $this->Form->text('keyword');
	echo $this->Form->submit('検索', array('class' => 'btn btn-primary'));
	echo $this->Form->end();
	?>

	<table class="table table-striped table-bordered table-condensed">
	<tr>
			<th style="width: 60px;"><?php echo $this->Paginator->sort('id'); ?></th>
			<th style="width: 80px;"><?php echo $this->Paginator->sort('player_id', 'Player_id'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['player_id']); ?></td>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'user', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'userEdit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'userDelete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	
	<!-- pagination -->
	<?php echo $this->element('pagination'); ?>
</div>
