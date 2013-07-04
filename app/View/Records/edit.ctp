<h2 style="font-size: 14pt; border-bottom: 1px solid gray;">
    きろく
</h2>

<?php echo $this->Form->create('Record',array('type' => 'post', 'url' => '/records/edit/'.h($record['Record']['record_id']) )); ?>
<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">せんしゅID</th>
		<td>
            <?php
            echo $this->Html->link(h($record['Record']['player_id']),"/P/".h($record['Record']['player_id']));
            ?>
        </td>
	</tr>
	<tr>
		<th>きろくID</th>
		<td><?php echo h($record['Record']['record_id']); ?></td>
	</tr>
	<tr>
		<th>はしった日</th>
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
		<td><?php echo $this->Form->text('comment', array('default' => h($record['Record']['comment']), 
            'style' => 'width:900px')); ?></td>
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
<?php echo $this->Form->hidden('user_id',array('value' => $record['Record']['user_id'])) ?>
<?php echo $this->Form->end("けってい"); ?>