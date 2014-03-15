<h1><?php echo __('マイページ'); ?></h1>

<h2>
	<?php echo __('きろくデータ'); ?>
</h2>

<?php if (h($record['Record']['is_public']) == false){ ?>
<div class="alert alert-block">
	<?php echo __('このきろくデータは、ほかの人がみることができません'); ?><br />
	<?php echo __('ほかの人がみることができるようにするには、「きろくデータへんこう」から「きろくをこうかいする」にチェックをいれてください'); ?>
</div>
<?php } ?>

<table class="table table-striped table-bordered">
	<tr>
		<th class="span3"><?php echo __('きろくID'); ?></th>
		<td>
        <?php 
            echo h($record['Record']['record_id']); 
            ob_start();
            QRCode::png(h($record['Record']['record_id']), null, 'H', 5, 2);
            $img_base64 = base64_encode( ob_get_contents() );
            ob_end_clean();
            echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
        ?>
        </td>
	</tr>
	<tr>
		<th><?php echo __('はしった日'); ?></th>
		<td><?php echo h($record['Record']['register_date']); ?></td>
	</tr>
    <?php if (isset($partner)) {?>
    <tr>
		<th><?php echo __('いっしょにはしった人'); ?></th>
		<td>
            <?php
                if ($partner['is_linked'] == true){
                    echo $this->Html->link(h($partner['name']),"/P/".h($partner['name']));
                }else{
                    echo h($partner['name']);
                }
            ?>
        </td>
	</tr>
    <tr>
		<th><?php echo __('いっしょにはしった人のきろくID'); ?></th>
		<td>
        <?php 
        if(isset($partner)){
            echo h($partner['record_id']); 
            ob_start();
            QRCode::png(h($partner['record_id']), null, 'H', 5, 2);
            $img_base64 = base64_encode( ob_get_contents() );
            ob_end_clean();
            echo $this->Html->div('qrcode', "<img src='" .sprintf('data:image/png;base64,%s', $img_base64). "'/>");
        }
        ?>
        </td>
	</tr>
    <?php } ?>
	<tr>
		<th><?php echo __('タグ'); ?></th>
		<td>       
            <?php 
            foreach ($record['Record']['tags'] as $tag){
                echo $this->Html->link(h($tag), array('controller' => 'records', 'action' => 'search', 'tag' => h($tag)));
                echo " ";
            }
            ?>
        </td>
	</tr>
	<tr>
		<th><?php echo __('コメント'); ?></th>
		<td><?php echo h($record['Record']['comment']); ?></td>
	</tr>
</table>
<?php if ($record['Record']['user_id'] == $LOGIN_USER['User']['id']) : ?>
    <p><a class="btn" href="<?php echo $this->Html->url("/My/record_edit/".h($record['Record']['record_id'])); ?>"><?php echo __('きろくデータへんこう'); ?></a></p>
<?php endif?>

<h2><?php echo __('サムネイル'); ?></h2>

<div style="width: 1000px;">
    <?php
        for ($i = 1; $i <= 6; $i++) {
            if (!empty($record['RecordImage'][$i])) {
                $recordImage = $record['RecordImage'][$i];
                echo $this->Stm->image($record['Record']['player_id'], $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], array('title' => $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], 'style' => 'width: 160px; margin-bottom: 6px;'));
            } else {
                echo "<img src='{$this->Html->webroot}/img/space.gif' style='width: 160px; height: 100px;'></img>";
            }
        };
        for ($i = 12; $i >= 7; $i--) {
            if (!empty($record['RecordImage'][$i])) {
                $recordImage = $record['RecordImage'][$i];
                echo $this->Stm->image($record['Record']['player_id'], $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], array('title' => $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'], 'style' => 'width: 160px; margin-bottom: 6px;'));
            } else {
                echo "<img src='{$this->Html->webroot}/img/space.gif' style='width: 160px; height: 100px;'></img>";
            }
        };

    ?>
</div>

<h2><?php echo __('3Dオブジェクト'); ?></h2>

<ul>
<?php foreach ($record['RecordObject'] as $key => $recordObject): ?>
    <li>
        <a href="../my/download/<?php echo $record['Record']['player_id'] ?>/<?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext'] ?>" ><?php echo $recordObject['Image']['filename'] . '.' . $recordObject['Image']['ext']; ?></a>
    </li>
<?php endforeach; ?>
</ul>

<div class="center"><a class="btn" href="<?php echo $this->Html->url("/My/"); ?>"><?php echo __('マイページにもどる'); ?></a></div>
