<?php

use yii\helpers\Url;

$this->title = '用户管理';
?>
<div class="row table-responsive">
    <div class="col-sm-12">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>积分编号</th>
<!--                <th>编号</th>-->
                <th>用户id</th>
                <th>用户昵称</th>
                <th>用户头像</th>
                <th>分值</th>
                <th>积分来源</th>
                <th>创建时间</th>
                <th>积分状态</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $key => $value): ?>
                <tr>
                    <td><?= $value['id'] ?></td>
<!--                    <td>--><?//= $value['order_no'] ?><!--</td>-->
                    <td><?= $value['user_id'] ?></td>
                    <td><?= $value['nickname'] ?></td>
                    <td><img style="width:35px;height:35px;" src="<?= $value['headimg'] ?>" alt="<?=$value['nickname']?>"></td>
                    <td><?= $value['award_point'] ?></td>
                    <td><?= $value['apply_from'] ?></td>
                    <td><?= date('Y-m-d H:i:s',$value['create_at']) ?></td>
                    <?php if($value['order_status'] == '已核销') {?>
                        <td style="color: green"><?= $value['order_status'] ?></td>
                    <?php } else {?>
                        <td style="color: red"><?= $value['order_status'] ?></td>
                    <?php } ?>
                    <?php if($value['order_status'] == '已核销') {?>
                        <td></td>
                    <?php } else {?>
                        <td><a href="<?=Url::to(['site/verifyjifen','id' => $value['id']])?>">点击核销</a></td>
                    <?php } ?>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
