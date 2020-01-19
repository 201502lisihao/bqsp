<?php
namespace backend\controllers;

use backend\models\LoginForm;
use common\models\PostsModel;
use common\models\YisaiOrdersModel;
use common\models\YisaiWxUserModel;
use backend\service\SiteService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'userlist', 'jifenlist', 'getjifenlistbyuserid', 'deluser', 'verifyjifen'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    //首页
    public function actionIndex()
    {
        return $this->render('index');
    }

    //登录
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    //退出登录
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    //伊赛Tool用户管理
    public function actionUserlist()
    {
        $result = SiteService::getUserList();
        return $this->render('user', ['data' => $result]);
    }

    //删除用户
    public function actionDeluser($id){
        $model = new YisaiWxUserModel();
        $query = $model->find()->where(['id' => $id])->one();
        if (!empty($query)) {
            $query->delete();
        }
//        return $this->actionUserlist();
        return $this->goBack(Yii::$app->request->getReferrer());
    }

    //积分管理
    public function actionJifenlist(){
        $result = SiteService::getOrderList();
        return $this->render('jifen', array('data' => $result));
    }

    //获取用户积分
    public function actionGetjifenlistbyuserid($id){
        $result = SiteService::getjifenListByUserId($id);
        return $this->render('usersjifen', array('data' => $result));
    }

    //核销积分
    public function actionVerifyjifen($id){
        $model = new YisaiOrdersModel();
        $query = $model->find()->where(['id' => $id])->one();
        if (!empty($query)) {
            $query->order_status = '已核销';
            $query->save(false);
        }
        return $this->goBack(Yii::$app->request->getReferrer());
    }

    //删除新闻 增删改---删除

    public function actionNews()
    {
        $model = new PostsModel();
        $result = $model->find()->select(['id', 'title', 'summary', 'label_img', 'is_valid', 'user_name'])->asArray()->all();
        //var_dump($result);exit;
        return $this->render('news', ['data' => $result]);
    }

    //审核新闻

    public function actionChecknews($id){
        $model = new PostsModel();
        $query = $model->find()->where(['id' => $id])->one();
        //完成审核
        $query->is_valid = 1;
        $query->save();
        return $this->actionNews();
    }

    //查看新闻
    public function actionLooknews($id){
        $model = new PostsModel();
        $query = $model->find()->where(['id' => $id])->asArray()->one();
        return $this->render('look',['post' => $query]);
    }

}
