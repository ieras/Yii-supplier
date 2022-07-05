<?php

namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierSearch;
use app\utils\ExcelUtil;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $export = $this->request->queryParams['export']??0;
        $this->request->queryParams['export'] = 0;
        if($export == 1){
            //执行导出
            $fileName = md5(json_encode($this->request->queryParams)).'.csv';
            $title = 'ID,Name,Code,T_Status'."\n";
            $q = clone $dataProvider->query;
            $data = $q->asArray()->all();
            $wrstr = '';
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    $wrstr .= $value['id'] . ',' . $value['name'] . ',' . $value['code'] . ',' . $value['t_status'];
                    $wrstr .= "\n";
                }
            }
            ExcelUtil::instance()->export( $fileName, $title, $wrstr);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 导出列表.
     */
    public function actionExport()
    {
        $ids = $this->request->bodyParams['ids'];
        $fileName = md5(json_encode($this->request->bodyParams)).'.csv';
        $title = 'ID,Name,Code,T_Status'."\n";
        $data = Supplier::find()->andFilterWhere(['in', 'id', $ids])->asArray()->all();
        $wrstr = '';
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $wrstr .= $value['id'] . ',' . $value['name'] . ',' . $value['code'] . ',' . $value['t_status'];
                $wrstr .= "\n";
            }
        }
        ExcelUtil::instance()->export( $fileName, $title, $wrstr);
    }

    /**
     * Displays a single Supplier model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Supplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
