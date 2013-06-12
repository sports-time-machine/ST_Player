<div class="user view">
<h2>選手 ( <?php echo h($user['User']['username']); ?> さん )</h2>
	<table class="table table-striped table-bordered">
		<tr>
			<th>顔写真</th>
			<td>
				<div><?php echo "{$user['UserImage']['Image']['id']}: {$user['UserImage']['Image']['image_file_name']}"; ?></div>
				<div><?php echo $this->Form->postLink(__('削除'), array('action' => 'userImageDelete', $user['User']['id'], $userImage['id']), array('class' => 'btn btn-danger'), __('%s を削除しますか？', $userImage['Image']['image_file_name'])); ?></div>

				<?php echo $this->upload->image($userImage['Image'], 'Image.image', array('style' => 'thumb'), array('class' => 'uploadPack_thumb')); ?>
				&nbsp;

			</td>
		</tr>
		<tr>
			<th>選手番号</th>
			<td>
				<?php echo h($user['User']['player_id']); ?>
				&nbsp;
			</td>
		</tr>
		<tr>
			<th>選手名</th>
			<td>
				<?php echo h($user['User']['username']); ?>
				&nbsp;
			</td>
		</tr>
		<tr>
			<th>登録日</th>
			<td>
				<?php echo h($user['User']['register_date']); ?>
				&nbsp;
			</td>
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td>
				<?php echo h($user['Profile']['mailaddress']); ?>
				&nbsp;
			</td>
		</tr>
		<tr>
			<th>生年月日</th>
			<td>
				<?php echo h($user['Profile']['birthday']); ?>
				&nbsp;
			</td>
		</tr>
		<tr>
			<th>性別</th>
			<td>
				<?php echo h($user['Profile']['sex']); ?>
				&nbsp;
			</td>
		</tr>
		<tr>
			<th>住所</th>
			<td>
				<?php echo h($user['Profile']['address']); ?>
				&nbsp;
			</td>
		</tr>
	</table>
</div>
