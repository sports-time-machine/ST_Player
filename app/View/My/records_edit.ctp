<h1>きろく <span style="font-size: 70%;">のせってい</span></h1>

<h2><?php echo h($LOGIN_USER['User']['username']);?> <span style="font-size: 70%;">せんしゅがはしったきろく</span></h2>

<table class="table table-striped table-bordered">
	<tr>
		<th><?php echo $this->Paginator->sort('record_id', 'きろくID'); ?></th>
		<th><?php echo $this->Paginator->sort('comment', 'コメント'); ?></th>
		<th><?php echo $this->Paginator->sort('tags', 'タグ'); ?></th>
		<th><?php echo $this->Paginator->sort('register_date', 'はしった日'); ?></th>
	</tr>
<?php foreach ($data as $record): ?>
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

