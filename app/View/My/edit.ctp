<h1><?php echo __('マイページ'); ?></h1>

<h2><?php echo __('プロフィールへんこう'); ?></h2>

<?php echo $this->Form->create('User',array('type' => 'post', 'url' => '/My/edit', 'class' => 'form-inline')); ?>
<table class="table table-striped table-bordered">
	<tr>
		<th class="span3"><?php echo __('こうもく'); ?></th>
		<th><?php echo __('せってい'); ?></th>
		<th class="span4"><?php echo __('こうかいはんい'); ?></th>
	</tr>
	<tr>
		<th><?php echo __('せんしゅ名'); ?></th>
		<td>
			<?php echo $this->Form->text('User.username', array('style' => '', 'autocomplete' => 'off')); ?>
		</td>
		<td>
			<input type="radio" id="ProfileUserUsernameIsPublic" checked="checked"></input><label for="ProfileUserUsernameIsPublic"><?php echo __('じぶん'); ?></label>
		</td>
	</tr>
	<tr>
		<th><?php echo __('ニックネーム'); ?></th>
		<td>
			<?php echo $this->Form->text('User.nickname', array('style' => '', 'autocomplete' => 'off')); ?>
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
		<th><?php echo __('Twitter ID'); ?></th>
		<td>
			<?php echo $this->Form->text('Profile.twitter_id', array('style' => '', 'autocomplete' => 'off')); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.twitter_id_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo __('ねんれい'); ?></th>
		<td>
			<?php echo $this->Form->input('Profile.age', array('type' => 'select', 'options' => $AGE_SELECT_LIST, 'label' => false, 'div' => false, 'style' => '')); ?><?php echo __(' 歳（さい）'); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.age_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo __('せいべつ'); ?></th>
		<td>
			<?php echo $this->Form->radio('Profile.gender', $GENDER_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.gender_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
	<tr>
		<th><?php echo __('コメント'); ?></th>
		<td>
			<?php echo $this->Form->text('Profile.comment', array('style' => 'width: 400px;', 'autocomplete' => 'off')); ?>
		</td>
		<td>
			<?php echo $this->Form->radio('Profile.comment_is_public', $ACCESS_LEVEL_LIST, array('legend' => false, 'style' => '')); ?>
		</td>
	</tr>
</table>

<p><?php echo __('※せんしゅ名を変えると、もとのせんしゅ名でログインできなくなります。きをつけてへんこうしてください。'); ?></p>

<?php echo $this->Form->submit(__('けってい'), array('class' => 'btn decide', 'div' => false)); ?>
<a class="btn decide" href="<?php echo $this->Html->url("/My/"); ?>"><?php echo __('もどる'); ?></a>
<?php echo $this->Form->end(); ?>
