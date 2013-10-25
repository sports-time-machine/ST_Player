<h1>マイページ</h1>

<h2>プロフィールへんこう</h2>

<?php echo $this->Form->create('User',array('type' => 'post', 'url' => '/My/edit', 'class' => 'form-inline')); ?>
<table class="table table-striped table-bordered">
	<tr>
		<th class="span3">こうもく</th>
		<th>せってい</th>
		<th class="span4">こうかいはんい</th>
	</tr>
	<tr>
		<th>せんしゅ名</th>
		<td>
			<?php echo $this->Form->text('User.username', array('style' => '')); ?>
		</td>
		<td>
			<input type="radio" id="ProfileUserUsernameIsPublic" checked="checked"></input><label for="ProfileUserUsernameIsPublic">じぶん</label>
		</td>
	</tr>
	<tr>
		<th>ニックネーム</th>
		<td>
			<?php echo $this->Form->text('User.nickname', array('style' => '')); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('User.nickname_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
			<!--
			<div class="btn-group" data-toggle="buttons-radio">
				<button type="button" class="btn">じぶん</button>
				<button type="button" class="btn">せんしゅ</button>
				<button type="button" class="btn">全宇宙</button>
			</div>
			-->
				<!--
				<input class="btn" type="radio" name="data['Profile']['nickname_is_public']" id="ProfileNameIsPublic" value=""></input>
				<label for="ProfileNameIsPublic">じぶん</label>
				<input class="btn" type="radio" name="data['Profile']['nickname_is_public']" value="1"></input>
				<label for="ProfileNameIsPublic1">せんしゅ</label>
				<input class="btn" type="radio" name="data['Profile']['nickname_is_public']" value="99"></input>
				<label for="ProfileNameIsPublic99">全宇宙</label>
				-->
		</td>
	</tr>
	<tr>
		<th>Twitter ID</th>
		<td>
			<?php echo $this->Form->text('Profile.twitter_id', array('style' => '')); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.twitter_id_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th>ねんれい</th>
		<td>
			<?php echo $this->Form->input('Profile.age', array('type' => 'select', 'options' => $AGE_SELECT_LIST, 'label' => false, 'div' => false, 'style' => '')); ?> 歳（さい）
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.age_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th>せいべつ</th>
		<td>
			<?php echo $this->Form->radio('Profile.gender', $GENDER_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.gender_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th>コメント</th>
		<td>
			<?php echo $this->Form->text('Profile.comment', array('style' => 'width: 400px;')); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.comment_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
</table>

<p>※せんしゅ名を変えると、もとのせんしゅ名でログインできなくなります。きをつけてへんこうしてください。</p>

<?php echo $this->Form->submit("けってい", array('class' => 'btn decide', 'div' => false)); ?>
<a class="btn decide" href="<?php echo $this->Html->url("/My/"); ?>">もどる</a>
<?php echo $this->Form->end(); ?>
