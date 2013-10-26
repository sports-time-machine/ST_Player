<h1>マイページ</h1>

<h2>
	きろくデータへんこう
</h2>

<?php echo $this->Form->create('Record',array('type' => 'post', 'class' => 'form-inline')); ?>
<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">きろくID</th>
		<td>
		<?php 
			echo h($this->request->data['Record']['record_id']); 
			ob_start();
			QRCode::png(h($this->request->data['Record']['record_id']), null, 'H', 5, 2);
			$img_base64 = base64_encode( ob_get_contents() );
			ob_end_clean();
			echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
		?>
		</td>
	</tr>
	<tr>
		<th>はしった日</th>
		<td>
			<?php echo $this->Stm->s2w($this->request->data['Record']['register_date']); ?>
			<?php echo $this->Form->hidden('Record.register_date'); ?>
		</td>
	</tr>
	<tr>
		<th>タグ</th>
		<td>
			<?php echo $this->Form->text('Record.tags', array('style' => 'width: 90%;', 'maxlength'=>'255')); ?>
			<div style="margin-top: 4px; font-size: 80%; color: #333333;">タグはスペースで区切って入力してください（例：小学生 男子 山口）</div>
		</td>
	</tr>
	<tr>
		<th>コメント</th>
		<td>
		<?php 
			echo $this->Form->text('Record.comment', array('style' => 'width: 90%;')); 
		?>
		</td>
	</tr>
	<tr>
		<th>こうかいはんい</th>
		<td>
			<?php echo $this->Form->radio('Record.is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
</table>
<?php echo $this->Form->hidden('Record.id'); ?>

<?php echo $this->Form->submit("けってい", array('class' => 'btn decide', 'div' => false)); ?>
<a class="btn decide" href="<?php echo $this->Html->url("/r/".h($this->request->data['Record']['record_id'])); ?>">もどる</a>

<?php echo $this->Form->end(); ?>