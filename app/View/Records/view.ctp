<h2 style="font-size: 14pt; border-bottom: 1px solid gray;">記録 <?php echo $record['Record']['record_id']; ?> </h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">選手ID</th>
		<td>
            <?php
            echo $this->Html->link(h($record['Record']['player_id']),"/P/".h($record['Record']['player_id']));
            ?>
        </td>
	</tr>
	<tr>
		<th>記録ID</th>
		<td><?php echo h($record['Record']['record_id']); ?></td>
	</tr>
	<tr>
		<th>走った日</th>
		<td><?php echo h($record['Record']['register_date']); ?></td>
	</tr>
	<tr>
		<th>タグ</th>
		<td>       
            <?php 
            foreach ($record['Record']['tags'] as $tag){
                echo $this->Html->link(h($tag), array('controller' => 'records', 'action' => 'search', 'tag' => h($tag)));
                echo " ";
            }
            ?>
        </td>
	</tr>
	<tr>
		<th>コメント</th>
		<td><?php echo h($record['Record']['comment']); ?></td>
	</tr>
	<tr>
		<th>パターン</th>
		<td><?php echo h($record['Record']['pattern']); ?></td>
	</tr>
	<tr>
		<th>音楽</th>
		<td><?php echo h($record['Record']['sound']); ?></td>
	</tr>
	<tr>
		<th>背景</th>
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
