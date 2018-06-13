<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Application;
use common\models\ApplicationSearch;

/**
 * 后台 申请 控制器
 */
class ApplicationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 列出所有申请列表
     * 默认显示时间范围为从现在起30天内
     *
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('manageRoom')) {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限。');
        }

        $searchModel = new ApplicationSearch();
        $searchModel->start_time_picker = date('Y-m-d H:i', time());
        $searchModel->end_time_picker = date('Y-m-d H:i', time() + 3600 * 24 * 30);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示一个申请详情
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('manageRoom')) {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限。');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 批准一条申请
     *
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionApprove($id)
    {
        if (!Yii::$app->user->can('manageRoom')) {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限。');
        }

        $model = $this->findModel($id);
        $model->status = Application::STATUS_APPROVED;

        try {
            $model->save();
        } catch (yii\db\Exception $e) {
            return $this->render('sqlerror');
        }

        return $this->redirect(['index']);
    }

    /**
     * 拒绝一条申请
     *
     * @param integer $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionReject($id)
    {
        if (!Yii::$app->user->can('manageRoom')) {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限。');
        }

        $model = $this->findModel($id);
        $model->status = Application::STATUS_REJECTED;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * 根据主键寻找申请模型
     * 如果未找到模型，抛出404异常
     *
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('你所请求的页面不存在。');
    }
}
