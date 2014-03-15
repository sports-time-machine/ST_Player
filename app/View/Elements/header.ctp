<!-- Header -->
<div id="header">
	<div class="logo"><?php echo __('スポーツタイムマシン'); ?></div>
	<div class="search">
	<?php 
		echo $this->Form->create('Record', array(
			'url' => array('controller' => 'records', 'action' => 'search'),
			'class' => 'form-search',
		));
		echo $this->Form->text('keyword');
		$action = $this->Html->url('/profiles/search');
		//echo $this->Form->submit('せんしゅけんさく', array('class' => 'btn btn-primary', 'style' => 'margin-left: 8px;', 'div' => false, 'onclick' => "this.form.action='{$action}'"));
		$action = $this->Html->url('/records/search');
		echo $this->Form->submit(__('きろくけんさく'), array('class' => 'btn btn-primary', 'style' => 'margin-left: 8px;', 'div' => false, 'onclick' => "this.form.action='{$action}'"));
		echo $this->Form->end();
	?>
	</div>
	
	<!-- Language -->
	<div class="language">
		<a href="<?php echo $this->Html->url($this->action.DS.'lang:ja'); ?>">日本語</a>
		 | <a href="<?php echo $this->Html->url($this->action.DS.'lang:en'); ?>">English</a>
	</div>

	<?php if (!empty($LOGIN_USER['User'])) { ?>
		<div class="welcome">
			<?php echo __('ようこそ！ '); ?><a href="<?php echo $this->Html->url('/My/index'); ?>"><?php echo $LOGIN_USER['User']['username']; ?></a><?php echo __(' せんしゅ！'); ?>
		</div>
		<div class="logout">
			<a class="btn" href="<?php echo $this->Html->url('/users/logout'); ?>"><?php echo __('ログアウト'); ?></a>
		</div>
	<?php } else { ?>
		<div style="text-align: right; position: absolute; top: 12px; right: 32px;">
			<a class="btn btn-success" href="<?php echo $this->Html->url('/Users/login'); ?>"><?php echo __('せんしゅカードでログイン'); ?></a>
			<a class="btn btn-warning" href="<?php echo $this->Html->url('/Users/passwordLogin'); ?>"><?php echo __('せんしゅばんごうでログイン'); ?></a>
		</div>
		<div class="login">
			<a class="btn" href="<?php echo $this->Html->url('/users/index2'); ?>"><?php echo __('トップにもどる'); ?></a>
		</div>
	<?php } ?>
	
</div>
<!-- Header -->
