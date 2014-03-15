<h1><?php echo __('せんしゅページ'); ?></h1>

<h2>
	<?php echo __('せんしゅデータ'); ?>
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3"><?php echo __('せんしゅ名'); ?></th>
		<td>
			<?php if (!empty($data['User']['nickname'])): ?>
				<?php echo $data['User']['nickname']; ?>
			<?php else: ?>
				<?php echo $data['User']['id']; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th><?php echo __('コメント'); ?></th>
		<td><?php echo h($data['Profile']['comment']); ?></td>
	</tr>
</table>


<h2><?php echo __('はしったきろく'); ?></h2>

<table class="table table-striped table-bordered">
<tr>
		<th><?php echo $this->Paginator->sort('record_id', __('きろくID')); ?></th>
		<th><?php echo $this->Paginator->sort('comment', __('コメント')); ?></th>
		<th><?php echo $this->Paginator->sort('tags', __('タグ')); ?></th>
		<th><?php echo $this->Paginator->sort('register_date', __('はしった日')); ?></th>
</tr>
<?php foreach ($records as $record): ?>
<tr>
	<td><?php echo $this->Html->link(h($record['Record']['record_id']), array('controller' => 'records', 'action' => 'view', $record['Record']['record_id'])); ?></td>
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

