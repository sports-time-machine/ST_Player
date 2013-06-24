<script type="text/javascript">
$(function() {
	// 初期フォーカス
	$('#LogLog').focus();
});
</script>

<div class="logs search">
	<h2>ログ</h2>

	<?php
	echo $this->Form->create('Log', array(
		'url' => array('controller' => 'logs', 'action' => 'search'),
	));
	echo $this->Form->label('log');
	echo $this->Form->text('log');
	echo $this->Form->submit('Search', array('class' => 'btn btn-primary'));
	echo $this->Form->end();
	?>


	<table class="table table-striped table-bordered">
	<tr>
		<th style="width: 70px;"><?php echo $this->Paginator->sort('id', 'ユーザー名'); ?></th>
		<th><?php echo $this->Paginator->sort('log', 'ログ'); ?></th>
		<th><?php echo $this->Paginator->sort('loglevel', 'ログレベル'); ?></th>
		<th style="width: 70px;"><?php echo $this->Paginator->sort('action', '操作'); ?></th>
		<th><?php echo $this->Paginator->sort('model', '画面'); ?></th>
		<th><?php echo $this->Paginator->sort('affected_id', 'データID'); ?></th>
		<th><?php echo $this->Paginator->sort('ip', '接続元'); ?></th>
		<th style="width: 122px;"><?php echo $this->Paginator->sort('created', '日時'); ?></th>
	</tr>
	<?php foreach ($data as $item): ?>
	<tr>
		<td><?php echo h($item['Log']['username']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['log']); ?></td>
		<td><?php echo h($item['Log']['loglevel']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['action']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['model']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['affected_id']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['ip']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['created']); ?>&nbsp;</td>
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
