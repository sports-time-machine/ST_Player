<h1>はしったきろく</h1>


<h2>
	<!-- 選手名 -->
	<?php echo $this->Stm->getUserNickname($data); ?>
	<!-- 走った日時 -->
	<span class="sub">
		が
		<?php echo $this->Stm->getRecordRegisterDateJ($data); ?>
		に走ったきろく
	</span>
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span2">はしった人</th>
		<td class="span4">
			<?php echo $this->Stm->getUserNicknameLink($data); ?>
		</td>

		<th class="span2">いっしょに<br/>はしった人</th>
		<td class="span4">
			<?php echo $this->Stm->getPartnerNicknameLink($data['partners'][0]); ?>
		</td>
	</tr>
	<tr>
		<th>きろくID</th>
		<td>
			<div style="float: left;">
			<?php 
				ob_start();
				QRCode::png(h($data['Record']['record_id']), null, 'H', 5, 2);
				$img_base64 = base64_encode( ob_get_contents() );
				ob_end_clean();
				echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
			?>
			</div>
			<div style="padding-left: 16px; height: 145px; display: table-cell; vertical-align: middle;">
				<?php echo h($data['Record']['record_id']); ?>
			</div>
		</td>

		<th>いっしょに<br/>はしった人の<br/>きろくID</th>
		<td>
			<div style="float: left;">
			<?php 
				ob_start();
				QRCode::png(h($data['Partner'][0]['record_id']), null, 'H', 5, 2);
				$img_base64 = base64_encode( ob_get_contents() );
				ob_end_clean();
				echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
			?>
			</div>
			<div style="padding-left: 16px; height: 145px; display: table-cell; vertical-align: middle;">
			<?php
				$record_id = $data['Partner'][0]['record_id'];
				if ($data['Partner'][0]['is_linked']) {
					echo $this->Html->link($record_id,"/r/{$record_id}");
				} else {
					echo $record_id;
				}
			?>
			</div>
		</td>
	</tr>
	<tr>
		<th>タグ</th>
		<td colspan="3">
			<?php 
			foreach ($data['Record']['tags'] as $tag){
				echo $this->Html->link(h($tag), array('controller' => 'records', 'action' => 'search', 'tag' => h($tag)));
				echo " ";
			}
			?>
		</td>
	</tr>
	<tr>
		<th>コメント</th>
		<td colspan="3"><?php echo h($data['Record']['comment']); ?></td>
	</tr>
</table>

<h2>サムネイル</h2>

<div style="width: 1000px;">
	<?php
		for ($i = 1; $i <= 6; $i++) {
			if (!empty($data['RecordImage'][$i])) {
				$recordImage = $data['RecordImage'][$i];
				echo $this->Stm->image($data['Record']['player_id'], $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], array('title' => $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], 'style' => 'width: 160px; margin-bottom: 6px;'));
			} else {
				echo "<img src='{$this->Html->webroot}/img/space.gif' style='width: 160px; height: 1px;'></img>";
			}
		};
		for ($i = 12; $i >= 7; $i--) {
			if (!empty($data['RecordImage'][$i])) {
				$recordImage = $data['RecordImage'][$i];
				echo $this->Stm->image($data['Record']['player_id'], $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], array('title' => $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], 'style' => 'width: 160px; margin-bottom: 6px;'));
			} else {
				echo "<img src='{$this->Html->webroot}/img/space.gif' style='width: 160px; height: 1px;'></img>";
			}
		};

	?>
</div>

<h2>3Dオブジェクト</h2>

<ul>
<?php foreach ($data['RecordObject'] as $key => $recordObject): ?>
	<li>
		<a href="../download/<?php echo $data['Record']['player_id'] ?>/<?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext'] ?>" ><?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext']; ?></a>
	</li>
<?php endforeach; ?>
</ul>

<div class="center"><a class="btn" href="<?php echo $this->Html->url("/n/{$data['Record']['user_id']}"); ?>">せんしゅのページにもどる</a></div>
