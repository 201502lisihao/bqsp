<?php

namespace backend\service;

use backend\service\base\BaseService;
use common\models\YisaiOrdersModel;
use common\models\YisaiWxUserModel;

class SiteService extends BaseService {
    /**
     * 获取伊赛所有积分订单
     */
    public static function getOrderList(){
        $orderList = YisaiOrdersModel::find()->asArray()->all();
        //添加用户相关信息
        if (!empty($orderList)){
            foreach ($orderList as $key => $order){
                $userInfo = YisaiWxUserModel::find()->where(['id' => $order['user_id']])->asArray()->one();
                $orderList[$key]['nickname'] = base64_decode($userInfo['nickname']);
                $orderList[$key]['headimg'] = $userInfo['headimg'];
            }
        }
        return $orderList;
    }
}