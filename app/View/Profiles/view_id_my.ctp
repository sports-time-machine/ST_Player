<div class="profiles viewIdMy">

<h1><?php echo __('マイページ'); ?></h1>

<h2>
	<?php echo h($data['User']['username']);?> <span class="sub"><?php echo __('せんしゅ'); ?></span>
	<a class="btn" href="<?php echo $this->Html->url("/My/edit"); ?>"><?php echo __('プロフィールへんこう'); ?></a>
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3"><?php echo __('せんしゅID'); ?></th>
		<td><?php echo $data['User']['player_id']; ?></td>
		<td class="span3"><?php echo __('じぶん に公開'); ?></td>
	</tr>
	<tr>
		<th><?php echo __('せんしゅ名'); ?></th>
		<td><?php echo h($data['User']['username']); ?></td>
		<td><?php echo __('じぶん に公開'); ?></td>
	</tr>
	<tr>
		<th><?php echo __('ニックネーム'); ?></th>
		<td><?php echo $this->Stm->getUserNickname($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['User']['nickname_is_public']); ?></td>
	</tr>
	<tr>
		<th><?php echo __('Twitter ID'); ?></th>
		<td><?php echo $this->Stm->getProfileTwitterIdLink($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['twitter_id_is_public']); ?></td>
	</tr>
	<tr>
		<th><?php echo __('ねんれい'); ?></th>
		<td><?php echo $this->Stm->getProfileAge($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['age_is_public']); ?></td>
	</tr>
	<tr>
		<th><?php echo __('せいべつ'); ?></th>
		<td><?php echo $this->Stm->getProfileGender($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['gender_is_public']); ?></td>
	</tr>
	<tr>
		<th><?php echo __('コメント'); ?></th>
		<td><?php echo $this->Stm->getProfileComment($data); ?></td>
		<td><?php echo $this->Stm->showAccessLevel($data['Profile']['comment_is_public']); ?></td>
	</tr>
</table>



<!-- records and partners -->
<?php echo $this->element('records_and_partners'); ?>
