<h2>せんしゅ</h2>

<?php echo $this->Form->create('User',array('type' => 'post', 'url' => '/My/edit')); ?>
<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">せんしゅID</th>
		<td><?php echo $user['User']['player_id']; ?></td>
	</tr>
	<tr>
		<th>せんしゅ名</th>
		<td>
            <?php echo $this->Form->text('username', array('default' => h($user['User']['username']), 
            'style' => 'width:900px')); ?>
        </td>
	</tr>
    <tr>
		<th>コメント</th>
		<td>
            <?php echo $this->Form->text('comment', array('default' => h($user['Profile']['comment']), 
            'style' => 'width:900px')); ?>
        </td>
	</tr>
</table>

<p>※せんしゅ名を変えると、もとのせんしゅ名でログインできなくなります。きをつけてへんこうしてください。</p>

<?php echo $this->Form->submit("けってい", array('class' => 'btn')); ?>
<?php echo $this->Form->end(); ?>
