<div class="alert alert-block">
	<?php echo __('このきろくはこうかいされていません'); ?>
</div>

<?php if (!empty($userId)){ ?>
<div class="center"><a class="btn" href="<?php echo $this->Html->url("/n/{$userId}"); ?>"><?php echo __('せんしゅのページにもどる'); ?></a></div>
<?php } ?>
