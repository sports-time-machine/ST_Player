<script type="text/javascript">
$(function() {
	// 初期フォーカス
	$('#RecordUsername').focus();
});
</script>

<div class="records search">

    <h1>きろくけんさく</h1>
    
	<h2>きろくいちらん</h2>

	<table class="table table-striped table-bordered">
	<tr>
			<th style="width: 40px;">画像</th>
			<th style="width: 140px;"><?php echo $this->Paginator->sort('record_id', 'きろくID'); ?></th>
			<th><?php echo $this->Paginator->sort('comment', 'コメント'); ?></th>
			<th><?php echo $this->Paginator->sort('tags', 'タグ'); ?></th>
			<th style="width: 260px;"><?php echo $this->Paginator->sort('register_date', 'はしった日'); ?></th>
	</tr>
	<?php foreach ($records as $record): ?>
	<tr>
		<td>
			<?php if (!empty($record['RecordImage'])): ?>
				★
			<?php endif; ?>
		</td>
		<td><?php echo $this->Html->link(h($record['Record']['record_id']), array('action' => 'view', $record['Record']['record_id'])); ?></td>
		<td><?php echo h($record['Record']['comment']); ?>&nbsp;</td>
		<td>
            <?php 
            foreach ($record['Record']['tags'] as $tag){
                echo $this->Html->link(h($tag), array('controller' => 'records', 'action' => 'search', 'tag' => h($tag)));
                echo " ";
            }
            ?>
        </td>
		<td><?php echo h($record['Record']['register_date']); ?></td>
	</tr>
	<?php endforeach; ?>
	</table>
	
	<!-- pagination -->
	<?php echo $this->element('pagination'); ?>
</div>
