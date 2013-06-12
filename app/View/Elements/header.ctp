<!-- Header -->
<div id="header">
    <p class="left">
        <?php if ($user['User']['username']){ ?>
        <span>ようこそ！<?php echo $user['User']['username']; ?>選手！</span>
        <?php } ?>
    </p>
    <p class="right">
        <?php if ($user['User']['username']){ ?>
            <?php echo $this->Html->link('ログアウト',array('action' => 'logout')) ?>
        <?php } ?>
    </p>
</div>
<!-- Header -->
