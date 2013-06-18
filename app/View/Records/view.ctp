<h2 style="font-size: 14pt; border-bottom: 1px solid gray;">記録 <?php echo $record['Record']['record_id']; ?> </h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">player_id</th>
		<td><?php echo h($record['Record']['player_id']); ?></td>
	</tr>
	<tr>
		<th>record_id</th>
		<td><?php echo h($record['Record']['record_id']); ?></td>
	</tr>
	<tr>
		<th>movie_path</th>
		<td><?php echo h($record['Record']['movie_path']); ?></td>
	</tr>
	<tr>
		<th>movie_length</th>
		<td><?php echo h($record['Record']['movie_length']); ?></td>
	</tr>
	<tr>
		<th>register_date</th>
		<td><?php echo h($record['Record']['register_date']); ?></td>
	</tr>
	<tr>
		<th>data</th>
		<td><?php echo h($record['Record']['data']); ?></td>
	</tr>
	<tr>
		<th>tags</th>
		<td><?php echo h($record['Record']['tags']); ?></td>
	</tr>
	<tr>
		<th>comment</th>
		<td><?php echo h($record['Record']['comment']); ?></td>
	</tr>
	<tr>
		<th>pattern</th>
		<td><?php echo h($record['Record']['pattern']); ?></td>
	</tr>
	<tr>
		<th>sound</th>
		<td><?php echo h($record['Record']['sound']); ?></td>
	</tr>
	<tr>
		<th>background</th>
		<td><?php echo h($record['Record']['background']); ?></td>
	</tr>
</table>


<h2 style="font-size: 14pt; border-bottom: 1px solid gray;">サムネイル</h2>

<div class="row">
	<div class="span9">
		<ul class="thumbnails">
			
			<?php foreach ($record['RecordImage'] as $key => $recordImage): ?>
			<li class="span3">
				<a href="#" class="sumbnail"><?php echo $this->Stm->image($record['Record']['player_id'], $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], array('title' => $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'])); ?></a>
			</li>
			<?php endforeach; ?>

		</ul>
	</div>
</div>
