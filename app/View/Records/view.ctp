
<h2 style="font-size: 14pt; border-bottom: 1px solid gray;">
    きろく
</h2>

<?php if ( $record['Record']['user_id'] == $LOGIN_USER['id']) : ?>
    <p><a class="btn" href="<?php echo $this->Html->url("/records/edit/".h($record['Record']['record_id'])); ?>">へんしゅうする</a></p>
<?php endif?>
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
		<td>
        <?php 
            echo h($record['Record']['record_id']); 
            ob_start();
            QRCode::png(h($record['Record']['record_id']), null, 'H', 5, 2);
            $img_base64 = base64_encode( ob_get_contents() );
            ob_end_clean();
            echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
        ?>
        </td>
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
		<td><?php echo h($record['Record']['comment']); ?></td>
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
