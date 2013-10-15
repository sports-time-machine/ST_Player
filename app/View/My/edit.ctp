<h1>マイページ</h1>

<h2>プロフィールへんこう</h2>

<?php echo $this->Form->create('User',array('type' => 'post', 'url' => '/My/edit', 'class' => 'form-inline')); ?>
<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">せんしゅ名</th>
		<td>
			<?php echo $this->Form->text('User.username', array('style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th class="span3">ニックネーム</th>
		<td>
			<?php echo $this->Form->text('User.nickname', array('style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th class="span3">たんじょうび</th>
		<td>
			<div class="input-append">
				<?php echo $this->Form->text('Profile.birthday', array('class' => 'datepicker', 'style' => '')); ?>
				<button class="btn" type="button" onclick="$('#ProfileBirthday').datepicker('show');"><i class="icon-calendar"></i></button>
			</div>
		</td>
	</tr>
	<tr>
		<th class="span3">せいべつ</th>
		<td>
			<?php echo $this->Form->radio('Profile.sex', $SEX_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th>コメント</th>
		<td>
			<?php echo $this->Form->text('Profile.comment', array('style' => 'width: 90%;')); ?>
		</td>
	</tr>
</table>

<p>※せんしゅ名を変えると、もとのせんしゅ名でログインできなくなります。きをつけてへんこうしてください。</p>

<?php echo $this->Form->submit("けってい", array('class' => 'btn decide', 'div' => false)); ?>
<a class="btn decide" href="<?php echo $this->Html->url("/My/"); ?>">もどる</a>
<?php echo $this->Form->end(); ?>
