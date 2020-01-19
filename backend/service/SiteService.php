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
        return array_reverse($orderList);
    }

    /**
     * 获取用户列表
     */
    public static function getUserList(){
        $userList = YisaiWxUserModel::find()->asArray()->all();
        if (!empty($userList)){
            foreach ($userList as $key => $user){
                //算出每个用户的总积分
                $sumPoints = YisaiOrdersModel::find()->select('SUM(award_point) as points')->where(['user_id' => $user['id']])->asArray()->all();
                Yii::error('lisihao11111111111111$sumPoints='.json_encode($sumPoints));
                $userList[$key]['points'] = $sumPoints ?? 0;
            }
        }
        return array_reverse($userList);
    }
}