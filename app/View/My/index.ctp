<h2>選手</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">player_id</th>
		<td><?php echo $user['User']['player_id']; ?></td>
	</tr>
	<tr>
		<th>username</th>
		<td><?php echo h($user['User']['username']); ?></td>
	</tr>
</table>


<h2>記録</h2>

<ul>
	<?php foreach ($user['Record'] as $record): ?>
	<li>
		<?php echo $this->Html->link($record['record_id'], array('controller' => 'records', 'action' => 'view', $record['record_id'])); ?>
		- <?php echo h($record['modified']); ?> 
	</li>
	<?php endforeach; ?>
</ul>

