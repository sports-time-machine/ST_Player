<h1><?php echo __('はしったきろく'); ?></h1>


<?php if ($data['Record']['is_public'] == ACCESS_LEVEL_SELF): ?>
<div class="alert alert-block">
	<h3><?php echo __('こうかいはんい： じぶん'); ?></h3>
	<?php echo __('このきろくデータは、ほかの人が見ることができません'); ?><br />
	<br />
	<?php echo __('スポーツタイムマシン会場と、せんしゅとうろくをした人に見てもらいたいきろくデータは、こうかいはんいを「全せんしゅ」にしてください'); ?><br />
	<?php echo __('全宇宙に見てもらいたいきろくデータは、こうかいはんいを「全宇宙」にしてください'); ?><br />
</div>
<?php elseif ($data['Record']['is_public'] == ACCESS_LEVEL_PLAYER): ?>
<div class="alert alert-success">
	<h3><?php echo __('こうかいはんい： せんしゅ'); ?></h3>
	<?php echo __('このきろくデータは、スポーツタイムマシン会場と、せんしゅとうろくをした人だけが見ることができます'); ?><br />
	<br />
	<?php echo __('ほかの人に見られたくないきろくデータは、こうかいはんいを「じぶん」にしてください'); ?><br />
	<?php echo __('全宇宙に見てもらいたいきろくデータは、こうかいはんいを「全宇宙」にしてください'); ?><br />
</div>
<?php elseif ($data['Record']['is_public'] == ACCESS_LEVEL_UNIVERSE): ?>
<div class="alert alert-info">
	<h3><?php echo __('こうかいはんい： 全宇宙'); ?></h3>
	<?php echo __('このきろくデータは、全宇宙から見ることができます'); ?><br />
	<br />
	<?php echo __('ほかの人に見られたくないきろくデータは、こうかいはんいを「じぶん」にしてください'); ?><br />
	<?php echo __('スポーツタイムマシン会場と、せんしゅとうろくをした人に見てもらいたいきろくデータは、こうかいはんいを「全せんしゅ」にしてください'); ?><br />
</div>
<?php endif; ?>


<h2>
	<!-- 選手名 -->
	<?php echo $this->Stm->getUserNickname($data); ?>
	<!-- 走った日時 -->
	<span class="sub">
		せんしゅが
		<?php echo $this->Stm->getRecordRegisterDateJ($data); ?>
		に走ったきろく
	</span>

	<a class="btn" href="<?php echo $this->Html->url("/My/record_edit/".h($data['Record']['record_id'])); ?>"><?php echo __('きろくデータへんこう'); ?></a>
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span2"><?php echo __('はしった人'); ?></th>
		<td class="span4">
			<?php
				$nickname = h($this->Stm->getUserNickname($data));
				echo $this->Html->link($nickname,"/n/".h($data['User']['id']));
			?>
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
		<a class="btn" href="../my/download/<?php echo $data['Record']['player_id'] ?>/<?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext'] ?>" ><?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext']; ?></a>
		<a class="btn" target="_blank" href="../my/obj_view/<?php echo $data['Record']['player_id'] ?>/<?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext'] ?>" >見る</a>
	</div>
<?php endforeach; ?>

<h2><?php echo __('3Dムービー'); ?></h2>

<?php if (file_exists($this->Stm->getRecordMoviePath($data))): ?>
	<a class="btn" href="<?php echo $this->Stm->getRecordMovieUrl($data); ?>"><?php echo $data['Record']['record_id'] . '.zip'; ?></a>

	<div class="alert alert-block" style="margin-top: 20px; line-height: 30px;">
		<h3>3Dムービーの再生方法</h3>

		<div>
		<iframe width="560" height="315" src="//www.youtube.com/embed/JlcB3EOTXSg" frameborder="0" allowfullscreen></iframe>
		</div>

		1. <a class="btn" href="<?php echo $this->Stm->url($data['Record']['player_id'], $item['Image']['filename'] . '.' . $item['Image']['ext']); ?>"><?php echo $item['Image']['filename'] . '.' . $item['Image']['ext']; ?></a>
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

<div class="center"><a class="btn" href="<?php echo $this->Html->url("/My/"); ?>"><?php echo __('マイページにもどる'); ?></a></div>
