<script type="text/javascript">
$(function() {
	// 初期フォーカス
	$('#RecordUsername').focus();
});
</script>

<div class="records search">
	<?php
	echo $this->Form->create('Record', array(
		'url' => array('controller' => 'records', 'action' => 'search'),
	));
	echo $this->Form->label('せんしゅめい');
	echo $this->Form->text('username');
	echo $this->Form->label('タグ');
	echo $this->Form->text('tags');
	echo $this->Form->submit('検索', array('class' => 'btn btn-primary'));
	echo $this->Form->end();
	?>

	<h2>記録一覧</h2>

	<table class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('User.username', 'せんしゅめい'); ?></th>
			<th><?php echo $this->Paginator->sort('record_id', 'きろくID'); ?></th>
			<th><?php echo $this->Paginator->sort('comment', 'コメント'); ?></th>
			<th><?php echo $this->Paginator->sort('tags', 'タグ'); ?></th>
			<th><?php echo $this->Paginator->sort('register_date', 'はしった日'); ?></th>
	</tr>
	<?php foreach ($records as $record): ?>
	<tr>
		<!-- <?php echo h($record['Record']['id']); ?> -->
		<td><?php echo h($record['User']['username']); ?></td>
		<td><?php echo $this->Html->link(h($record['Record']['record_id']), array('action' => 'view', $record['Record']['record_id'])); ?></td>
		<td><?php echo h($record['Record']['comment']); ?>&nbsp;</td>
		<td><?php echo h($record['Record']['tags']); ?>&nbsp;</td>
		<td><?php echo h($record['Record']['register_date']); ?>&nbsp;</td>
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
