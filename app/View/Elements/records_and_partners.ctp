<!-- records and partners element -->

<div style="width: 100%;">
	<div class="records" style="float: left; width: 50%;">
		<div style="margin-right: 10px;">
			<h2><?php echo $this->Stm->getUserNickname($data); ?> <span class="sub"><?php echo __('せんしゅがはしったきろく'); ?> (<span class="count"><?php echo count($data['records']); ?></span>回)</span></h2>
			<table class="table table-striped table-bordered">
				<tr>
 					<th><?php echo __('タグ・コメント'); ?></th>
					<th class="span3"><?php echo __('きろくID'); ?></th>
				</tr>
			<?php foreach ($data['records'] as $key => $item): ?>
				<?php if ($key < 20): ?>
				<tr class="item">
				<?php else: ?>
				<tr class="item" style="display: none;">
				<?php endif; ?>
					<td>
						<!-- 時間 -->
						<div class="register_date">
							<?php echo $this->Stm->getRecordRegisterDateJ($item); ?>
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
			<?php if (20 < count($data['records'])): ?>
				<tr id="records_display_all">
					<td colspan="2">
						<div style="text-align: center;">
							<a href="#" class="btn btn-large btn-warning" onclick="$('#records_display_all').hide(); $('.records .item').show('slow'); return false;"><?php echo __('ぜんぶ見る'); ?></a>
						</div>
					</td>
				</tr>
			<?php endif; ?>
			</table>

		</div>
	</div>
	<div class="partners" style="float: left; width: 50%;">
		<div style="margin-left: 10px;">
			<h2><?php echo $this->Stm->getUserNickname($data);?> <span class="sub"><?php echo __('せんしゅといっしょにはしった人'); ?> (<span class="count"><?php echo count($data['partners']); ?></span>人)</span></h2>

			<table class="table table-striped table-bordered">
				<tr>
 					<th><?php echo __('はしった人'); ?></th>
					<th class="span3"><?php echo __('きろくID'); ?></th>
				</tr>
			<?php foreach ($data['partners'] as $key => $item): ?>
				<?php if ($key < 20): ?>
				<tr class="item">
				<?php else: ?>
				<tr class="item" style="display: none;">
				<?php endif; ?>
					<td>
						<!-- 時間 -->
						<div class="register_date">
							<?php echo $this->Stm->getRecordRegisterDateJ($item); ?>
						</div>
						<!-- 1行プロフィール -->
						<div class="profile">
							<?php echo $this->Stm->getPartnerProfileOneLine($item); ?>
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
			<?php if (20 < count($data['partners'])): ?>
				<tr id="partners_display_all">
					<td colspan="2">
						<div style="text-align: center;">
							<a href="#" class="btn btn-large btn-warning" onclick="$('#partners_display_all').hide(); $('.partners .item').show('slow'); return false;"><?php echo __('ぜんぶ見る'); ?></a>
						</div>
					</td>
				</tr>
			<?php endif; ?>
			</table>

		</div>
	</div>
</div>
<br clear="all" />

<!-- records and partners element -->
