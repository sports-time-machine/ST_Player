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
            $i=0;
            foreach ($record['Record']['tags'] as $tag){
                echo $this->Form->text('Record.tags.'.$i, array('default' => h($tag), 
                    'style' => 'width:150px')); 
                echo " ";
                $i++;
            }
            ?>
        </td>
	</tr>
	<tr>
		<th>コメント</th>
		<td>
        <?php 
            echo $this->Form->text('comment', array('default' => h($record['Record']['comment']), 
                'style' => 'width:900px')); 
        ?>
        </td>
	</tr>
</table>
<?php echo $this->Form->hidden('id',array('value' => $record['Record']['id'])) ?>
<?php echo $this->Form->submit("けってい", array('class' => 'btn')); ?>
<?php echo $this->Form->end(); ?>