<!-- Header -->
<div id="header">
    <div class="logo">スポーツタイムマシン</div>
    <div class="loginuser">
    <?php 
    if ($this->name != 'Users') {   //Usersコントローラ時は非表示
    //if (!empty($LOGIN_USER)) {
        echo $this->Form->create('Record', array(
            'url' => array('controller' => 'records', 'action' => 'search'),
        ));
        echo $this->Form->text('keyword');
        echo $this->Form->submit('検索', array('class' => 'btn btn-primary','div' => false));
        echo $this->Form->end();
    } 
    ?>
    </div>
    <div class="logout">
        <?php 
        if (!empty($LOGIN_USER)) {
            echo $this->Html->link('ログアウト',array('controller' => 'users' , 'action' => 'logout'));
        }else {
            echo $this->Html->link('ログイン',array('controller' => 'users' , 'action' => 'login'));
        }
        ?>
    </div>
</div>
<!-- Header -->
