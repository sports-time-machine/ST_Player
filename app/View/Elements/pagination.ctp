	<!-- pagination element -->
	<div class="pagination">
		<p style="text-align: right;">
			<?php echo $this->Paginator->counter(array('format' => __('{:count} 件中 {:start} ～ {:end} 件'))); ?>
		</p>
		<div style="text-align: center;">
			<ul>
			<?php
				echo $this->Paginator->prev('< 前へ', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled prev', 'disabledTag' => 'a'));
				echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
				echo $this->Paginator->next('次へ >', array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled next', 'disabledTag' => 'a'));
			?>
			</ul>
		</div>
	</div>
	<!-- pagination element -->
