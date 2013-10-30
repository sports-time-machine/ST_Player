<script type="text/javascript">
$(function() {
	// 初期フォーカス
	$('#RecordKeyword').focus();
});
</script>

<div class="records search">

	<h1>きろくけんさく</h1>

	<h2>きろくいちらん</h2>

	<table class="table table-striped table-bordered">
	<tr>
			<th style="width: 120px;">画像</th>
			<th>きろく</th>
			<th class="span3">きろくID</th>
	</tr>
	<?php foreach ($data as $item): ?>
	<tr>
		<td>
			<div class="search-image">

			<?php if (!empty($item['RecordImage'])): ?>
				<a style="width: 140px;" class="" href="<?php echo $this->Html->url("/r/{$item['Record']['record_id']}"); ?>">
				<?php echo $this->Stm->image($item['Record']['player_id'], $item['Image']['filename'] . '.' . $item['Image']['ext'], array('title' => $item['Image']['filename'] . '.' . $item['Image']['ext'], 'style' => 'width: 120px; margin-bottom: 6px;')); ?>
				</a>
			<?php endif; ?>
			</div>
		</td>
		<td>
			<div class="clearfix">
				<!-- ニックネーム -->
				<div style="float: left;">
					<?php echo $this->Stm->getUserNicknameLink($item); ?> せんしゅのきろく
				</div>
				<!-- 時間 -->
				<div class="register_date" style="float: right;">
					<?php echo $this->Stm->getRecordRegisterDateJ($item); ?>
				</div>
			</div>
			<!-- コメント -->
			<div class="comment">
				<?php echo $this->Stm->getRecordComment($item); ?>
			</div>
			<!-- タグ -->
			<div class="tags">
				<?php echo $this->Stm->getRecordTagsLink($item); ?>
			</div>
		</td>
		<td>
			<!-- きろくID -->
			<div class="record_id">
				<a style="width: 140px;" class="btn btn-large btn-success" href="<?php echo $this->Html->url("/r/{$item['Record']['record_id']}"); ?>"><?php echo $item['Record']['record_id']; ?></a>
			</div>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	
	<!-- pagination -->
	<?php echo $this->element('pagination'); ?>
</div>
