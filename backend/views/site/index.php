<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = '管理后台-小田新闻网';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>石家庄伊赛牛肉+</h1>

        <p class="lead">http://bqsp.qianzhuli.top</p>
<!--        <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>-->
        <span><a class="btn btn-lg btn-success" href="<?= Url::to(['site/userlist']) ?>">用户管理</a></span>
        <span><a class="btn btn-lg btn-success" href="<?= Url::to(['site/jifenlist']) ?>">积分管理</a></span>
    </div>
</div>
