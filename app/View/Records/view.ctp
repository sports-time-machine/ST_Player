<h2>記録</h2>

<?php foreach ($record['Image'] as $key => $image): ?>

	<div>画像<?php echo $key; ?></div>
	<div>
		<?php echo $this->Stm->image($record['Record']['record_id'], $image['filename']); ?><br>
	</div>
<?php endforeach; ?>
