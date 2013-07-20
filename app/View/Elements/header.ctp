<!-- Header -->
<div id="header">
    <div class="logo">スポーツタイムマシン</div>
    <div class="search">
    <?php 
    if ($this->name != 'Users') {   //Usersコントローラ時は非表示
        echo $this->Form->create('Record', array(
            'url' => array('controller' => 'records', 'action' => 'search'),
            'class' => 'form-search',
        ));
        echo $this->Form->text('keyword');
        echo $this->Form->submit('けんさく', array('class' => 'btn btn-primary', 'style' => 'margin-left: 8px;', 'div' => false));
        echo $this->Form->end();
    } 
    ?>
    </div>
    
    <?php if (!empty($LOGIN_USER)) { ?>
        <div class="welcome">
            ようこそ！ <a href="<?php echo $this->Html->url('/My/index'); ?>"><?php echo $LOGIN_USER['username']; ?></a> せんしゅ！
        </div>
        <div class="logout">
            <a class="btn" href="<?php echo $this->Html->url('/users/logout'); ?>">ログアウト</a>
        </div>
    <?php } else { ?>
        <div class="login">
            <a class="btn" href="<?php echo $this->Html->url('/users/index2'); ?>">トップにもどる</a>
        </div>
    <?php } ?>
    
</div>
<!-- Header -->
