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
                <th>用户id</th>
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
                    <td><?= $value['user_id'] ?></td>
                    <td><?= $value['award_point'] ?></td>
                    <td><?= $value['apply_from'] ?></td>
                    <td><?= date('Y-m-d H:i:s',$value['create_at']) ?></td>
                    <?php if($value['order_status'] == '已核销') {?>
                        <td style="color: green"><?= $value['order_status'] ?></td>
                    <?php } else {?>
                        <td style="color: red"><?= $value['order_status'] ?></td>
                    <?php } ?>
                    <td><a href="<?=Url::to(['site/deluser','id' => $value['id']])?>">删除</a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
