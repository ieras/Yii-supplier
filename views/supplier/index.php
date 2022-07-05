<?php

use app\models\Supplier;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Supplier', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('导出选中数据', "javascript:void(0);", ['class' => 'btn btn-primary gridview_export']) ?>
        <a type="hidden" id="donload"></a>
    </p>

    <?php Pjax::begin(); ?>
    <?php
    echo $this->render('_search', ['model' => $searchModel]);
    $script = <<<SCRIPT
$(".gridview_export").on("click", function () {
if(confirm('仅导出选中的数据，确认？')){
    var keys = $("#grid").yiiGridView("getSelectedRows");
    var donload = document.getElementById('donload')
     $.ajax({
            url: '?r=supplier/export',
            data: {ids:keys},
            type: 'post',
            //下面这句代码是关键 如果不行的话可以试试 responseType: 'blob',
		    xhrFields: { responseType: "arraybuffer" },
            success: function (t) {
                var blob = new Blob([t]);
                donload.download = "data.csv";
                donload.href=window.URL.createObjectURL(blob);
                donload.click()
            },
            error: function () {
                alert("失败！")
            }
     
        })
    }
});
SCRIPT;
    $this->registerJs($script);
    ?>

    <?= GridView::widget([
        'options' =>['id'=>'grid'],
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn',],
            'id',
            'name',
            'code',
            't_status',
//            [
//                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, Supplier $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id]);
//                 }
//            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
