<h1>マイページ</h1>

<h2><?php echo h($user['User']['username']);?> せんしゅ</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">せんしゅID</th>
		<td><?php echo $user['User']['player_id']; ?></td>
	</tr>
	<tr>
		<th>せんしゅ名</th>
		<td><?php echo h($user['User']['username']); ?></td>
	</tr>
	<tr>
		<th>コメント</th>
		<td><?php echo h($user['Profile']['comment']); ?></td>
	</tr>
</table>
<p><a class="btn" href="<?php echo $this->Html->url("/My/edit"); ?>">プロフィールへんこう</a></p>


<h2><?php echo h($user['User']['username']);?> せんしゅがはしったきろく</h2>

<table class="table table-striped table-bordered">
<tr>
        <th><?php echo $this->Paginator->sort('record_id', 'きろくID'); ?></th>
        <th><?php echo $this->Paginator->sort('comment', 'コメント'); ?></th>
        <th><?php echo $this->Paginator->sort('tags', 'タグ'); ?></th>
        <th><?php echo $this->Paginator->sort('register_date', 'はしった日'); ?></th>
</tr>
<?php foreach ($records as $record): ?>
<tr>
    <td><?php echo $this->Html->link(h($record['Record']['record_id']), array('controller' => 'My', 'action' => 'record_view', $record['Record']['record_id'])); ?></td>
    <td><?php echo h($record['Record']['comment']); ?>&nbsp;</td>
    <td>
        <?php 
        foreach ($record['Record']['tags'] as $tag){
            echo $this->Html->link(h($tag), array('controller' => 'records', 'action' => 'search', 'tag' => h($tag)));
            echo " ";
        }
        ?>
    </td>
    <td><?php echo h($record['Record']['register_date']); ?></td>
</tr>
<?php endforeach; ?>
</table>

	<!-- pagination -->
	<?php echo $this->element('pagination'); ?>

