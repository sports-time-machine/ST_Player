<h1><?php echo __('はしったきろく'); ?></h1>

<h2>
	<!-- 選手名 -->
	<?php echo $this->Stm->getUserNickname($data); ?>
	<!-- 走った日時 -->
	<span class="sub">
		せんしゅが
		<?php echo $this->Stm->getRecordRegisterDateJ($data); ?>
		に走ったきろく
	</span>
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span2"><?php echo __('はしった人'); ?></th>
		<td class="span4">
			<?php echo $this->Stm->getUserNicknameLink($data); ?>
		</td>

		<th class="span2">いっしょに<br/>はしった人</th>
		<td class="span4">
			<?php echo $this->Stm->getPartnerNicknameLink($data['partners'][0]); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo __('きろくID'); ?></th>
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
				if (!empty($data['Partner'][0]['record_id'])) {
					ob_start();
					QRCode::png(h($data['Partner'][0]['record_id']), null, 'H', 5, 2);
					$img_base64 = base64_encode( ob_get_contents() );
					ob_end_clean();
					echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
				} else {
					echo __("記録データが見つかりません！");
				}
			?>
			</div>
			<div style="padding-left: 16px; height: 145px; display: table-cell; vertical-align: middle;">
			<?php
				if (!empty($data['Partner'][0]['record_id'])) {
					$record_id = $data['Partner'][0]['record_id'];
					if ($data['Partner'][0]['is_linked']) {
						echo $this->Html->link($record_id,"/r/{$record_id}");
					} else {
						echo $record_id;
					}
				}
			?>
			</div>
		</td>
	</tr>
	<tr>
		<th><?php echo __('タグ'); ?></th>
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
		<th><?php echo __('コメント'); ?></th>
		<td colspan="3"><?php echo h($data['Record']['comment']); ?></td>
	</tr>
</table>

<h2><?php echo __('サムネイル'); ?></h2>

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

<h2><?php echo __('3Dオブジェクト'); ?></h2>

<?php foreach ($data['RecordObject'] as $key => $recordObject): ?>
	<div style="margin-bottom: 6px;">
		<a class="btn" href="../records/download/<?php echo $data['Record']['player_id'] ?>/<?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext'] ?>" ><?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext']; ?> ダウンロード</a>
		<a class="btn" target="_blank" href="../records/obj_view/<?php echo $data['Record']['player_id'] ?>/<?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext'] ?>" >見る</a>
	</div>
<?php endforeach; ?>

<h2><?php echo __('3Dムービー'); ?></h2>

<?php if (file_exists($this->Stm->getRecordMoviePath($data))): ?>
	<a class="btn" href="<?php echo $this->Stm->getRecordMovieUrl($data); ?>"><?php echo $data['Record']['record_id'] . '.zip'; ?></a>

	<div class="alert alert-block" style="margin-top: 20px; line-height: 30px;">
		<h3><?php echo __('3Dムービーの再生方法'); ?></h3>

		<div>
		<iframe width="560" height="315" src="//www.youtube.com/embed/JlcB3EOTXSg" frameborder="0" allowfullscreen></iframe>
		</div>

		1. <a class="btn" href="<?php echo $this->Stm->getRecordMovieUrl($data); ?>"><?php echo $data['Record']['record_id'] . '.zip'; ?></a>
		ボタンを押して3Dムービーデータをダウンロードします<br />

		2. <a href="<?php echo $this->base . '/ST_Viewer-0810-1041.zip'?>">3Dムービービューアー</a>をダウンロードします<br />

		3. 3Dムービービューアーを展開してできた ST_Viewer-0810-1041.exe に、3Dムービーデータの1つをドラッグ＆ドロップします<br />

		4. F1キーを押すと再生がはじまります<br />

		&nbsp;&nbsp;&nbsp;&nbsp;再生中に数字の1~6, 0, 9を押すとカメラの位置が変わります<br />
		<br/>
	</div>
<?php else: ?>
<?php echo __('近日公開予定！'); ?>
<?php endif; ?>

<div class="center"><a class="btn" href="<?php echo $this->Html->url("/n/{$data['Record']['user_id']}"); ?>"><?php echo __('せんしゅのページにもどる'); ?></a></div>
