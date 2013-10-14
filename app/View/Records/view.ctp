<h1>はしったきろく</h1>

<h2>
	きろくデータ
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">はしった人</th>
		<td>
			<?php
			$nickname = h($this->Stm->getUserNickname($record));
			echo $this->Html->link($nickname,"/n/".h($record['User']['id']));
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
	<?php if (isset($partner)) {?>
	<tr>
		<th>いっしょにはしった人</th>
		<td>
			<?php
				$nickname = h($this->Stm->getPartnerNickname($data));

				if ($partner['is_linked'] == true){
					echo $this->Html->link($nickname,"/n/".h($data['Partner']['user_id']));
				}else{
					echo h($nickname);
				}
			?>
		</td>
	</tr>
	<tr>
		<th>いっしょにはしった人のきろくID</th>
		<td>
		<?php 
		if(isset($partner)){
			echo h($partner['record_id']); 
			ob_start();
			QRCode::png(h($partner['record_id']), null, 'H', 5, 2);
			$img_base64 = base64_encode( ob_get_contents() );
			ob_end_clean();
			echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
		}
		?>
		</td>
	</tr>
	<?php } ?>
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

<h2>サムネイル</h2>

<div style="width: 1000px;">
	<?php
		for ($i = 1; $i <= 6; $i++) {
			if (!empty($record['RecordImage'][$i])) {
				$recordImage = $record['RecordImage'][$i];
				echo $this->Stm->image($record['Record']['player_id'], $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], array('title' => $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], 'style' => 'width: 160px; margin-bottom: 6px;'));
			} else {
				echo "<img src='{$this->Html->webroot}/img/space.gif' style='width: 160px; height: 1px;'></img>";
			}
		};
		for ($i = 12; $i >= 7; $i--) {
			if (!empty($record['RecordImage'][$i])) {
				$recordImage = $record['RecordImage'][$i];
				echo $this->Stm->image($record['Record']['player_id'], $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], array('title' => $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], 'style' => 'width: 160px; margin-bottom: 6px;'));
			} else {
				echo "<img src='{$this->Html->webroot}/img/space.gif' style='width: 160px; height: 1px;'></img>";
			}
		};

	?>
</div>

<h2>3Dオブジェクト</h2>

<ul>
<?php foreach ($record['RecordObject'] as $key => $recordObject): ?>
	<li>
		<a href="../download/<?php echo $record['Record']['player_id'] ?>/<?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext'] ?>" ><?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext']; ?></a>
	</li>
<?php endforeach; ?>
</ul>