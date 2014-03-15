<div class="profiles viewId">

<h1><?php echo __('せんしゅページ'); ?></h1>

<h2>
	<?php echo __('せんしゅデータ'); ?>
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3"><?php echo __('ニックネーム'); ?></th>
		<td><?php echo $this->Stm->getUserNickname($data); ?></td>
	</tr>
	<tr>
		<th><?php echo __('Twitter ID'); ?></th>
		<td><?php echo $this->Stm->getProfileTwitterIdLink($data); ?></td>
	</tr>
	<tr>
		<th><?php echo __('ねんれい'); ?></th>
		<td><?php echo $this->Stm->getProfileAge($data); ?></td>
	</tr>
	<tr>
		<th><?php echo __('せいべつ'); ?></th>
		<td><?php echo $this->Stm->getProfileGender($data); ?></td>
	</tr>
	<tr>
		<th><?php echo __('コメント'); ?></th>
		<td><?php echo $this->Stm->getProfileComment($data); ?></td>
	</tr>
</table>



<!-- records and partners -->
<?php echo $this->element('records_and_partners'); ?>
