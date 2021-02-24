<?php

namespace backend\controllers;

use Yii;
use common\models\Oadode;
use common\models\OadodeSearch;
use common\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\DescriptionOfGoods;
use common\models\User;
use yii\base\Exception;
use yii\helpers\Json;
use kartik\mpdf\Pdf;

/**
 * OadodeController implements the CRUD actions for Oadode model.
 */
class OadodeController extends BaseController
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
     * Lists all Oadode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OadodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Oadode model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
            'goods' => DescriptionOfGoods::find()
                ->where(['application_id' => $model->application_id])
                ->all()
        ]);
    }
    
    public function actionReport($id) {
        $model = $this->findModel($id);
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_view', [
            'model' => $model,
            'goods' => DescriptionOfGoods::find()
                ->where(['application_id' => $model->application_id])
                ->all()
        ]);
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Registration Form'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['Registration Form'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * Creates a new Oadode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $savedGoods = [];
        $goods = [];
        
        $model = new Oadode(); 
        $model->scenario = 'create';
        for ($i = 1; $i <= 5; $i++) {
            $goods[$i] = new DescriptionOfGoods();
        }
        
        $goodsPost = $request->post('DescriptionOfGoods');
        
        if ($model->load($request->post()) && $model->validate()) { 
            if ($goodsPost != null) {
                foreach ($goodsPost as $index => $row) {
                    $goods[$index] = new DescriptionOfGoods();
                    $goods[$index]->description = $row['description'];
                    $goods[$index]->ecl_group = $row['ecl_group'];
                    $goods[$index]->ecl_item = $row['ecl_item'];
                    
                    if ($goods[$index]->description != null) {
                        if ($goods[$index]->validate()) {
                            array_push($savedGoods, $goods[$index]);
                        }
                        else {
                            $model->addError('goods', \Yii::t('app', $goods[$index]->getErrorSummary(true)));
                        }
                    }
                }
            }
            
            if ($savedGoods != null) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $user = User::find()
                        ->where(['email' => $model->business_email])
                        ->one();
                    
                    if ($user == null) {
                        $user = new User();
                        $user->username = $model->business_email;
                        $user->email = $model->business_email;
                        $user->auth_key = 'AUTHKEY';
                        $user->password_hash = 'PASSWORDHASH'.rand(1, 10000);
                        $user->password_reset_token = 'PASSWORDRESETTOKEN'.rand(1, 10000);
                        $user->status = User::STATUS_ACTIVE;
                        $user->save();
                    }
                    
                    if ($user != null) {
                        $applicationId = $user->id . rand(1, 100);
                        /* $strBusinessTitle = '';
                        foreach ($model->business_title as $row) {
                            $strBusinessTitle = $strBusinessTitle . $row . ', ';
                        } */
                        
                        $model->user_id = $user->id;
                        $model->customer_id = $user->id;
                        $model->application_id = $applicationId;
                        $model->business_title = Json::encode($model->business_title);
                        
                        if ($model->save()) {
                            foreach ($savedGoods as $row) {
                                $row->application_id = $applicationId;
                                $row->customer_id = $user->id;
                                $row->user_id = $user->id;
                                
                                if(!$row->save()) {
                                    $transaction->rollBack();
                                }
                            }
                            
                            $transaction->commit();
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            } else  {
                $model->addError('goods', \Yii::t('app', 'Controlled Goods is empty'));
            }
        }

        return $this->render('create', [
            'model' => $model,
            'goods' => $goods
        ]);
    }

    /**
     * Updates an existing Oadode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $savedGoods = [];
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $model->business_title = Json::decode($model->business_title);
        $goods = DescriptionOfGoods::find()
            ->where(['application_id' => $model->application_id])
            ->all();
        
        $goodsPost = $request->post('DescriptionOfGoods');
        
        $goodsPost = $request->post('DescriptionOfGoods');
        if ($model->load($request->post()) && $model->validate()) {
            if ($goodsPost != null) {
                foreach ($goodsPost as $index => $row) {
                    $goodsModel = $goods[$index];
                    $goodsModel->description = $row['description'];
                    $goodsModel->ecl_group = $row['ecl_group'];
                    $goodsModel->ecl_item = $row['ecl_item'];
                    
                    if ($goods[$index]->description != null) {
                        if ($goodsModel->validate()) {
                            $goodsModel->update();
                        }
                        else {
                            $model->addError('goods', \Yii::t('app', $goodsModel->getErrorSummary(true)));
                        }
                    }
                }
            }
            
            if ($goods != null) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $user = User::find()
                        ->where(['email' => $model->business_email])
                        ->one();
                    
                    if ($user != null) {
                        $applicationId = $user->id . rand(1, 100);
                        $model->business_title = Json::encode($model->business_title);
                        
                        if ($model->update()) {
                            foreach ($savedGoods as $row) {
                                $row->application_id = $applicationId;
                                $row->customer_id = $user->id;
                                $row->user_id = $user->id;
                                
                                if(!$row->save()) {
                                    $transaction->rollBack();
                                }
                            }
                            
                            $transaction->commit();
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            } else  {
                $model->addError('goods', \Yii::t('app', 'Controlled Goods is empty'));
            }
        }

        /* if ($model->load(Yii::$app->request->post())) {
            $model->business_title = Json::encode($model->business_title);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } */

        return $this->render('update', [
            'model' => $model,
            'goods' => $goods
        ]);
    }

    /**
     * Deletes an existing Oadode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Oadode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Oadode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Oadode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
