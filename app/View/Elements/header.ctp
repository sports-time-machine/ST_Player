<!-- Header -->
<div id="header">
    <p class="left">
        <?php if ($user['username']){ ?>
        <span>ようこそ！<?php echo $user['username']; ?>選手！</span>
        <?php } ?>
    </p>
    <p class="right">
        <?php if ($user['username']){ ?>
            <?php echo $this->Html->link('ログアウト',array('action' => 'logout')) ?>
        <?php } ?>
    </p>
</div>
<!-- Header -->
