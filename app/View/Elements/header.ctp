<!-- Header -->
<div id="header">
    <div class="logo">スポーツタイムマシン</div>
    <div class="loginuser">
    <?php 
    
    if ($this->name != 'Users') {   //Usersコントローラ時は非表示
        echo $this->Form->create('Record', array(
            'url' => array('controller' => 'records', 'action' => 'search'),
            'class' => 'form-search',
        ));
        echo $this->Form->text('keyword');
        echo $this->Form->submit('検索', array('class' => 'btn btn-primary', 'style' => 'margin-left: 8px;', 'div' => false));
        echo $this->Form->end();
    } 
    ?>
    </div>
    
        
        
<?php if (!empty($LOGIN_USER)) { ?>
<div class="logout">
    <?php
       //echo $LOGIN_USER['password'];
    echo "ようこそ！".$this->Html->link($LOGIN_USER['username'] ,array('controller' => 'My', 'action' => 'index'))."選手！";
    echo "<br />";
    echo $this->Html->link('ログアウト',array('controller' => 'users' , 'action' => 'logout'));
    ?>
</div>
<?php }else { ?>
<div class="login">
    <?php
    echo $this->Html->link('ログイン',array('controller' => 'users' , 'action' => 'login'));
    ?>
</div>
<?php } ?>
       
    
</div>
<!-- Header -->
