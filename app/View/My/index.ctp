<h2>記録一覧</h2>

<?php foreach ($records as $record): ?>

	<?php echo h($record['Record']['record_id']); ?><br>

<?php endforeach; ?>
