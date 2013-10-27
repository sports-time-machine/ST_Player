<div class="profiles viewIdMy">

<h1>マイページ</h1>

<h2>
	<?php echo h($data['User']['username']);?> <span class="sub">せんしゅ</span>
	<a class="btn" href="<?php echo $this->Html->url("/My/edit"); ?>">プロフィールへんこう</a>
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">せんしゅID</th>
		<td><?php echo $data['User']['player_id']; ?></td>
		<td class="span3">じぶん に公開</td>
	</tr>
	<tr>
		<th>せんしゅ名</th>
		<td><?php echo h($data['User']['username']); ?></td>
		<td>じぶん に公開</td>
	</tr>
	<tr>
		<th>ニックネーム</th>
		<td><?php echo $this->Stm->getUserNickname($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['User']['nickname_is_public']); ?></td>
	</tr>
	<tr>
		<th>Twitter ID</th>
		<td><?php echo $this->Stm->getProfileTwitterIdLink($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['twitter_id_is_public']); ?></td>
	</tr>
	<tr>
		<th>ねんれい</th>
		<td><?php echo $this->Stm->getProfileAge($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['age_is_public']); ?></td>
	</tr>
	<tr>
		<th>せいべつ</th>
		<td><?php echo $this->Stm->getProfileGender($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['gender_is_public']); ?></td>
	</tr>
	<tr>
		<th>コメント</th>
		<td><?php echo $this->Stm->getProfileComment($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['comment_is_public']); ?></td>
	</tr>
</table>



<!-- records and partners -->
<?php echo $this->element('records_and_partners'); ?>
