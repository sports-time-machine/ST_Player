<h1>せんしゅページ</h1>

<h2>
	せんしゅデータ
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">せんしゅ名</th>
		<td>
			<?php if (!empty($data['User']['nickname'])): ?>
				<?php echo $data['User']['nickname']; ?>
			<?php else: ?>
				<?php echo $data['User']['id']; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>Twitter ID</th>
		<td>
			<?php if (!is_null($data['Profile']['twitter_id'])): ?>
				<a href="https://twitter.com/<?php echo h($data['Profile']['twitter_id']); ?>"><?php echo h($data['Profile']['twitter_id']); ?></a>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>ねんれい</th>
		<td>
			<?php if (!is_null($data['Profile']['age'])): ?>
				<?php echo h($data['Profile']['age']); ?> 歳（さい）
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>せいべつ</th>
		<td><?php echo h($GENDER_LIST[ $data['Profile']['gender'] ]); ?></td>
	</tr>
	<tr>
		<th>コメント</th>
		<td><?php echo h($data['Profile']['comment']); ?></td>
	</tr>
</table>


<h2>はしったきろく</h2>

<table class="table table-striped table-bordered">
<tr>
		<th><?php echo $this->Paginator->sort('record_id', 'きろくID'); ?></th>
		<th><?php echo $this->Paginator->sort('comment', 'コメント'); ?></th>
		<th><?php echo $this->Paginator->sort('tags', 'タグ'); ?></th>
		<th><?php echo $this->Paginator->sort('register_date', 'はしった日'); ?></th>
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

