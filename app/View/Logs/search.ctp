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
		'class' => 'form-search',
	));
	echo $this->Form->text('keyword');
	echo $this->Form->submit('Search', array('class' => 'btn btn-primary', 'style' => 'margin-left: 8px;', 'div' => false));
	echo $this->Form->end();
	?>


	<table class="table table-striped table-bordered table-condensed">
	<tr>
		<th style="width: 70px;"><?php echo $this->Paginator->sort('id', 'player_id'); ?></th>
		<th><?php echo $this->Paginator->sort('log', 'ログ'); ?></th>
		<th><?php echo $this->Paginator->sort('loglevel', 'Level'); ?></th>
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
		<td><?php echo h(@$LOG_LEVEL_LIST[ $item['Log']['loglevel'] ]); ?>&nbsp;</td>
		<td><?php echo h(@$LOG_ACTION_LIST[ $item['Log']['action'] ]); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['model']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['affected_id']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['ip']); ?>&nbsp;</td>
		<td><?php echo h($item['Log']['created']); ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</table>
	
	<!-- pagination -->
	<?php echo $this->element('pagination'); ?>
</div>
