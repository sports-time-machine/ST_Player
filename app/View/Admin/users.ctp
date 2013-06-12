<div class="user index">
	<h3>選手一覧</h3>

	<div style="margin: 20px 0px;">
		<a class="btn" href="<?php echo $this->Html->url('/admin/userAdd'); ?>">選手新規登録</a>
	</div>

	<table class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('player_id', 'Player_id'); ?></th>
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
	<div class="pagination">
		<p>
			<?php echo $this->Paginator->counter(array('format' => __('{:count} 件中 {:start} ～ {:end} 件'))); ?>
		</p>
		<ul>
		<?php
			echo $this->Paginator->prev('< 前へ', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
			echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
			echo $this->Paginator->next('次へ >', array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
		?>
		</ul>
	</div>
</div>
