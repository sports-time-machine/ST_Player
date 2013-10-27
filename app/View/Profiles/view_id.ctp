<div class="profiles viewId">

<h1>せんしゅページ</h1>

<h2>
	せんしゅデータ
</h2>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">ニックネーム</th>
		<td><?php echo $this->Stm->getUserNickname($data); ?></td>
	</tr>
	<tr>
		<th>Twitter ID</th>
		<td><?php echo $this->Stm->getProfileTwitterIdLink($data); ?></td>
	</tr>
	<tr>
		<th>ねんれい</th>
		<td><?php echo $this->Stm->getProfileAge($data); ?></td>
	</tr>
	<tr>
		<th>せいべつ</th>
		<td><?php echo $this->Stm->getProfileGender($data); ?></td>
	</tr>
	<tr>
		<th>コメント</th>
		<td><?php echo $this->Stm->getProfileComment($data); ?></td>
	</tr>
</table>



<!-- records and partners -->
<?php echo $this->element('records_and_partners'); ?>
