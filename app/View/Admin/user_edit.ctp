<div class="beans form">
<?php echo $this->Form->create('Bean'); ?>
	<fieldset>
		<legend><?php echo __('Edit Bean'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('product_code');
		echo $this->Form->input('country');
		echo $this->Form->input('name');
		echo $this->Form->input('summary');
		echo $this->Form->input('detail');
		echo $this->Form->input('address');
		echo $this->Form->input('farm');
		echo $this->Form->input('baisen');
		echo $this->Form->input('flavor');
		echo $this->Form->input('aftertaste');
		echo $this->Form->input('sweet');
		echo $this->Form->input('acidity');
		echo $this->Form->input('balance');
		echo $this->Form->input('mouthfeel');
		echo $this->Form->input('cleancup');
		echo $this->Form->input('delete_flag');
		echo $this->Form->input('create_user');
        echo $this->Form->input('base_flag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Bean.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Bean.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Beans'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Bean Images'), array('controller' => 'bean_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bean Image'), array('controller' => 'bean_images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recipes'), array('controller' => 'recipes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipe'), array('controller' => 'recipes', 'action' => 'add')); ?> </li>
	</ul>
</div>
